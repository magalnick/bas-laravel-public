<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticController extends Controller
{
    public function robotsTxt()
    {
        header("Content-type: text/plain");

        $allow_or_disallow = config('bas.allow_robots_txt') ? 'Allow' : 'Disallow';
        $directives = [
            'User-agent' => '*',
            $allow_or_disallow => '/',
        ];

        $o = '';
        foreach ($directives as $directive => $value) {
            $o .= "{$directive}: {$value}\n";
        }

        // do echo and exit to force immediate output with the text/plain content type
        // when doing a return $o, the final content type is not plain text
        echo $o;
        exit;
    }
}
