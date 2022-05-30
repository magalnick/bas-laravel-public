<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\ValueObjects\Newsletter;
use App\ValueObjects\StorageFileAttachment;
use App\Http\Response as ApiResponse;
use Exception;

class NewslettersController extends Controller
{
    private $newsletters;
    private $newsletter_directory;
    private $newsletter_extension = 'pdf';

    /**
     * NewslettersController constructor.
     */
    public function __construct()
    {
        $this->newsletters = $this->newslettersBaseStructure();
        $this->newsletter_directory = config('bas.newsletter_directory');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getNewsletters(Request $request)
    {
        try {
            $newsletters_directory_listing = Storage::files($this->newsletter_directory);

            // only use PDF files from the directory listing
            $newsletters = array_filter(
                $newsletters_directory_listing,
                function ($newsletter) {
                    return strtolower(pathinfo($newsletter)['extension']) === $this->newsletter_extension;
                }
            );
            if (empty($newsletters)) {
                return ApiResponse::success($this->newslettersBaseStructure(), 404);
            }

            rsort($newsletters);

            // yank off the first entry as "current",
            // loop through the rest to categorize by year
            // put them all into the key/value store for easy retrieval access
            $current = Newsletter::factory(array_shift($newsletters));
            $this->newsletters['current'] = $current->filename;
            $this->newsletters['newsletters'][$current->filename] = $current;

            foreach ($newsletters as $newsletter) {
                $newsletter = Newsletter::factory($newsletter);
                if (!array_key_exists("{$newsletter->year}", $this->newsletters['archive'])) {
                    $this->newsletters['archive']["{$newsletter->year}"] = [];
                }
                $this->newsletters['archive']["{$newsletter->year}"][]   = $newsletter->filename;
                $this->newsletters['newsletters'][$newsletter->filename] = $newsletter;
            }

            return ApiResponse::success($this->newsletters);
        } catch (Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode());
        }
    }

    public function getNewsletter(Request $request, $filename)
    {
        try {
            if (!is_string($filename) || trim($filename) === '') {
                throw new Exception('Filename must be a string', ApiResponse::HTTP_PRECONDITION_REQUIRED);
            }

            $filename = trim($filename);
            $file     = "{$this->newsletter_directory}/{$filename}.{$this->newsletter_extension}";

            return ApiResponse::success(['newsletter' => StorageFileAttachment::factory($file)]);
        } catch (Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function view(Request $request)
    {
        return view(config('bas.view.main_site_blade_template'), [
            'page'        => 'newsletter',
            'js'          => 'newsletter',
            'newsletters' => $this->getNewsletters($request)->original,
        ]);
    }

    /**
     * @return array
     */
    private function newslettersBaseStructure()
    {
        return [
            'current'     => null,
            'archive'     => [],
            'newsletters' => [],
        ];
    }
}
