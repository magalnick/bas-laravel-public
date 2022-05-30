<?php

namespace App\ValueObjects;

use Illuminate\Support\Facades\Storage;

class Newsletter extends StorageFile implements ValueObject
{
    public $url;
    public $api;
    public $year;
    public $month;

    protected function __construct($data)
    {
        parent::__construct($data);

        if (!$this->validateData($data)) {
            return;
        }

        $this->url   = asset(Storage::url($this->data));
        $this->api   = config('app.api_url_base') . "newsletters/{$this->filename}";
        $this->year  = $this->getYearFromFilename($this->data);
        $this->month = $this->getMonthFromFilename($this->data);
    }

    /**
     * @param $file
     * @return mixed
     */
    private function getYearFromFilename($file)
    {
        return $this->filenameRegex($file)[1];
    }

    /**
     * @param $file
     * @return string
     */
    private function getMonthFromFilename($file)
    {
        return $this->mapRawMonthToPrettyMonth(
            $this->filenameRegex($file)[3]
        );
    }

    /**
     * @param $month
     * @return string
     */
    private function mapRawMonthToPrettyMonth($month)
    {
        switch ($month) {
            case 'jan-feb':
                return 'January - February';
            case 'jan':
                return 'January';
            case 'feb':
                return 'February';
            case 'mar-apr':
                return 'March - April';
            case 'mar':
                return 'March';
            case 'apr':
                return 'April';
            case 'may-jun':
                return 'May - June';
            case 'may':
                return 'May';
            case 'jun':
                return 'June';
            case 'jul-aug':
                return 'July - August';
            case 'jul':
                return 'July';
            case 'aug':
                return 'August';
            case 'sep-oct':
                return 'September - October';
            case 'sep':
                return 'September';
            case 'oct':
                return 'October';
            case 'nov-dec':
                return 'November - December';
            case 'nov':
                return 'November';
            case 'dec':
                return 'December';
            default:
                return '';
        }
    }

    /**
     * @param $file
     * @return mixed
     */
    private function filenameRegex($file)
    {
        $file = strtolower($this->filename($file));
        preg_match('/^([0-9]{4})(.+)([a-z]{3}-[a-z]{3})$/', $file, $matches);
        return $matches;
    }

    /**
     * @param $file
     * @return mixed
     */
    private function filename($file)
    {
        return pathinfo($file)['filename'];
    }
}
