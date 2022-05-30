<?php

namespace App\ValueObjects;

use Illuminate\Support\Facades\Storage;

class StorageFile extends AbstractValueObject implements ValueObject
{
    public $path;
    public $filename;
    public $extension;
    public $mimetype;
    public $timestamp;
    public $size;
    public $sizef;

    protected $data;
    protected $validate_data_results;

    /**
     * StorageFile constructor.
     * @param $data
     */
    protected function __construct($data)
    {
        parent::__construct($data);

        if (!$this->validateData($data)) {
            return;
        }

        $this->path      = $this->data;
        $this->filename  = strtolower(pathinfo($this->data)['filename']);
        $this->extension = strtolower(pathinfo($this->data)['extension']);
        $this->mimetype  = mime_content_type(Storage::path($this->data));
        $this->timestamp = date('c', Storage::lastModified($this->data));
        $this->size      = Storage::size($this->data);
        $this->sizef     = $this->formatSize($this->size);
    }

    /**
     * @param $size
     * @return string
     */
    protected function formatSize($size)
    {
        if (!is_numeric($size)) {
            return '0 bytes';
        }

        switch (true) {
            case $size >= 1024 * 1024 * 1024:
                return sprintf('%01.1f Gb', $size / 1024 / 1024 / 1024);
            case $size >= 1024 * 1024:
                return sprintf('%01.1f Mb', $size / 1024 / 1024);
            case $size >= 1024:
                return sprintf('%01.1f Kb', $size / 1024);
            default:
                return "{$size} bytes";
        }
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
        if (!Storage::exists($data)) {
            return $this->validate_data_results;
        }

        $this->data                  = $data;
        $this->validate_data_results = true;
        return $this->validate_data_results;
    }
}
