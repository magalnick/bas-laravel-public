<?php

namespace App\Models\Database;

use Illuminate\Database\Eloquent\Model;
use Exception;
use DB;

class DbFunction extends Model
{
    private static $instance = null;

    /**
     * @return DbFunction|null
     */
    public static function singleton()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * DbFunction constructor.
     * @param array $attributes
     */
    private function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * @return string
     */
    public function uuid()
    {
        return $this->functionCall('UUID()');
    }

    /**
     * @return string
     */
    public function now()
    {
        return $this->functionCall('NOW()');
    }

    /**
     * @return string
     */
    public function unixtime()
    {
        return $this->functionCall('UNIX_TIMESTAMP()');
    }

    /**
     * @param string $fxn
     * @return string
     */
    private function functionCall($fxn = '')
    {
        return (string) DB::select("SELECT {$fxn} as fxn")[0]->fxn;
    }
}
