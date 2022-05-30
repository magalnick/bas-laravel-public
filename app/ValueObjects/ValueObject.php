<?php

namespace App\ValueObjects;

interface ValueObject
{
    public static function factory($data);
    public function __get($name);
    public function __set($name, $value);
}
