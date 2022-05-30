<?php

namespace App\ValueObjects;

use Illuminate\Support\Facades\Storage;

class StorageFileAttachment extends StorageFile implements ValueObject
{
    public $contents;

    protected function __construct($data)
    {
        parent::__construct($data);

        if (!$this->validateData($data)) {
            return;
        }

        $this->contents = base64_encode(Storage::get($this->data));
    }
}
