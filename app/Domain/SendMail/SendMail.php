<?php

namespace App\Domain\SendMail;

use App\Domain\SendMail\Contracts\SendMail as SendMailContract;

abstract class SendMail implements SendMailContract
{
    protected $from;
    protected $reply_to;
    protected $to;
    protected $cc;
    protected $bcc;
    protected $subject;
    protected $body;
    protected $attached_files;

    public function __construct()
    {
        $this->from = '';
        $this->reply_to = '';
        $this->to = [];
        $this->cc = [];
        $this->bcc = [];
        $this->subject = '';
        $this->body = [
            'html' => '',
            'text' => '',
        ];
        $this->attached_files = [];
        $this->init();
    }

    public function init()
    {
        return $this;
    }

    public function from($email)
    {
        //
    }

    public function replyTo($email)
    {
        //
    }

    public function to($email)
    {
        //
    }

    public function cc($email)
    {
        //
    }

    public function bcc($email)
    {
        //
    }

    public function subject($subject)
    {
        //
    }

    public function body($html = '', $text = '')
    {
        $this->bodyHtml($html);
        $this->bodyText($text);
    }

    public function bodyHtml($html)
    {
        if (!is_string($html)) {
            $html = '';
        }
        $html = trim($html);
        $this->body['html'] = $html;
    }

    public function bodyText($text)
    {
        if (!is_string($text)) {
            $text = '';
        }
        $text = trim($text);
        $this->body['text'] = $text;
    }

    public function attachFile($file)
    {
        //
    }

    public function send()
    {
        //
    }
}
