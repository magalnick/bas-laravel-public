<?php

namespace App\ValueObjects;

use Exception;

abstract class AbstractValueObject implements ValueObject
{
    protected $properties   = [];
    protected $property_map = [];

    /**
     * @param $data
     */
    public static function factory($data)
    {
        $class = get_called_class();
        return new $class($data);
    }

    /**
     * AbstractValueObject constructor.
     * @param $data
     */
    protected function __construct($data)
    {
        //
    }

    /**
     * @param string $name
     * @return mixed
     * @throws Exception
     */
    public function __get($name)
    {
        $name = $this->validatePropertyName($name);
        return $this->property_map[$name];
    }

    /**
     * @param string $name
     * @param $value
     * @throws Exception
     */
    public function __set($name, $value)
    {
        $name = $this->validatePropertyName($name);
        $this->property_map[$name] = $value;
    }

    /**
     * @param $name
     * @throws Exception
     */
    protected function validatePropertyName($name)
    {
        if (!is_string($name)) {
            throw new Exception("Property name must be a string", 417);
        }

        $name = trim($name);
        if ($name === '') {
            throw new Exception("No property name specified", 417);
        }
        if (!in_array($name, $this->properties)) {
            throw new Exception("Invalid property: {$name}", 417);
        }

        return $name;
    }
}
