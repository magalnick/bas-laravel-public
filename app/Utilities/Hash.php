<?php

namespace App\Utilities;

class Hash
{
    /**
     * @param string $string_to_hash
     * @param string $salt
     * @return string
     */
    public static function sha512($string_to_hash, $salt = '')
    {
        if (!is_string($string_to_hash)) {
            return '';
        }
        $string_to_hash = trim($string_to_hash);
        if ($string_to_hash === '') {
            return '';
        }

        if (!is_string($salt)) {
            $salt = '';
        }
        $salt = trim($salt);

        return FunWithText::sixesAndSevens(
            hash('sha512', "{$string_to_hash}:{$salt}")
        );
    }
}
