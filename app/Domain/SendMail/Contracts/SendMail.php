<?php

namespace App\Domain\SendMail\Contracts;

interface SendMail
{
    public function __construct();
    public function init();
    public function from($email);
    public function replyTo($email);
    public function to($email);
    public function cc($email);
    public function bcc($email);
    public function subject($subject);
    public function body($html, $text);
    public function attachFile($file);
    public function send();
}
