<?php

namespace App\ValueObjects;

class PhoneNumber extends AbstractValueObject implements ValueObject
{
    protected $original_value = '';
    protected $formatted = '';
    protected $raw = '';

    protected $data;
    protected $validate_data_results;

    /**
     * PhoneNumber constructor.
     * @param $data
     */
    protected function __construct($data)
    {
        parent::__construct($data);

        if (!$this->validateData($data)) {
            return;
        }
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return $this->validate_data_results;
    }

    /**
     * @return string
     */
    public function raw()
    {
        return $this->raw;
    }

    /**
     * @return string
     */
    public function formatted()
    {
        return $this->formatted;
    }

    /**
     * @return string
     */
    public function originalValue()
    {
        return $this->original_value;
    }

    /**
     * @param $data
     * @return bool
     */
    protected function validateData($data)
    {
        // if this has been run before, return back the prior results
        // if there's future weirdness when resetting values, this may be the culprit
        if (!is_null($this->data)) {
            return $this->validate_data_results;
        }

        $this->validate_data_results = false;

        if (!is_string($data)) {
            return $this->validate_data_results;
        }

        $data = trim($data);
        if ($data === '') {
            return $this->validate_data_results;
        }

        $this->original_value = $data;

        // extract only digits, if final starts with 1, remove the 1
        // goal is to get a 10 digit number
        $data = preg_replace("/[^0-9]/", "", $data);
        if (substr($data, 0, 1) === '1') {
            $data = substr($data, 1);
        }
        if (strlen($data) !== 10) {
            return $this->validate_data_results;
        }

        $this->data                  = $data;
        $this->validate_data_results = true;
        $this->formatRaw()->formatFormatted();
        return $this->validate_data_results;
    }

    /**
     * @return $this
     */
    protected function formatRaw()
    {
        $this->raw = "+1{$this->data}";
        return $this;
    }

    /**
     * @return $this
     */
    protected function formatFormatted()
    {
        $area_code       = substr($this->data, 0, 3);
        $prefix          = substr($this->data, 3, 3);
        $suffix          = substr($this->data, 6, 4);
        $this->formatted = "+1 ({$area_code}) {$prefix}-{$suffix}";
        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (!$this->isValid()) {
            return $this->originalValue();
        }
        return $this->raw();
    }
}
