<?php

namespace App\Utilities;

use Str;

class FunWithText
{
    /**
     * @param string $string_to_6_and_7
     * @return string
     */
    public static function sixesAndSevens($string_to_6_and_7) {
        $string_to_6_and_7 = trim($string_to_6_and_7);
        if ($string_to_6_and_7 === '') {
            return '';
        }

        $string_to_6_and_7 = str_replace('6', '::::s-i-x::::', $string_to_6_and_7);
        $string_to_6_and_7 = str_replace('7', '6', $string_to_6_and_7);
        $string_to_6_and_7 = str_replace('::::s-i-x::::', '7', $string_to_6_and_7);
        return $string_to_6_and_7;
    }

    /**
     * @param string $string_to_clean
     * @return string
     */
    public static function safeString($string_to_clean = '')
    {
        $string_to_clean = filter_var($string_to_clean, FILTER_SANITIZE_STRING);
        if (!is_string($string_to_clean)) {
            return '';
        }
        return trim($string_to_clean);
    }

    /**
     * @param string $email
     * @return string
     */
    public static function safeEmail($email = '')
    {
        if (!is_string($email)) {
            return '';
        }
        $email = trim($email);
        if ($email === '') {
            return '';
        }

        // if email is always lower case, it keeps everything clean for other comparisons later on
        $email          = strtolower($email);
        $filtered_email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if ($filtered_email !== $email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return '';
        }

        return $email;
    }

    /**
     * @param string $uuid
     * @return bool
     */
    public static function isUuid(string $uuid)
    {
        $uuid = trim($uuid);
        if ($uuid === "") {
            return false;
        }

        if (strlen($uuid) !== 36) {
            return false;
        }

        // just discovered the Laravel class Str, which has its own isUuid function
        // that has the exact same pattern as what was custom written here
        // it's missing the trim(), so keeping that part plus the strlen() for defensive coding
        return Str::isUuid($uuid);
    }
}
