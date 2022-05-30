<?php

namespace App\Http;

use Illuminate\Http\Response as BaseResponse;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Class Response
 *
 * Follows JSON API specification: http://jsonapi.org/format
 *
 * @package App\Api
 */

class Response extends BaseResponse
{
    /**
     * @param array $data
     * @param int $code
     * @return \Illuminate\Contracts\Routing\ResponseFactory|BaseResponse
     *
     * Note that the return array must be associative (or empty). If it's a
     * standard indexed array, final results will be distorted as the
     * "status" key is added.
     */
    public static function success(array $data = [], $code = 0) {
        $ret['data']   = $data;
        $ret['status'] = 'success';
        return response($ret, self::validateCode($code));
    }

    /**
     * @param string $error
     * @param int $code
     * @param bool $is_web
     * @return \Illuminate\Contracts\Routing\ResponseFactory|BaseResponse
     */
    public static function error($error = '', $code = 0, $is_web = false) {
        if (!is_string($error) || trim($error) === '') {
            return self::errors(['No error specified'], $code, $is_web);
        }
        $error = trim($error);
        return self::errors([$error], $code, $is_web);
    }

    /**
     * @param array $errors
     * @param int $code
     * @param bool $is_web
     * @return \Illuminate\Contracts\Routing\ResponseFactory|BaseResponse
     */
    public static function errors($errors = [], $code = 0, $is_web = false) {
        if ( !is_array($errors) || empty($errors) ) {
            return self::errors(['No errors specified']);
        }
        $code = self::validateCode($code, self::HTTP_INTERNAL_SERVER_ERROR);

        if ($is_web) {
            return response(
                view(
                    'errors.all',
                    [
                        'errors' => $errors,
                        'status' => 'errors',
                        'page'   => $code,
                    ]
                ),
                $code
            );
        }

        return response(
            [
                'errors' => $errors,
                'status' => 'errors',
            ],
            $code
        );
    }

    /**
     * @param $code
     * @param int $default
     * @return int
     */
    protected static function validateCode($code, $default = 0)
    {
        $default = intval($default);
        if (!array_key_exists($default, self::$statusTexts)) {
            $default = self::HTTP_OK;
        }
        if ($default === 0) {
            $default = self::HTTP_OK;
        }

        $code = intval($code);
        if (!array_key_exists($code, self::$statusTexts)) {
            $code = $default;
        }

        return $code;
    }
}
