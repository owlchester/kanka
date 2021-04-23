<?php


namespace App\Models\Concerns;


trait EntityAsset
{

    public function isLink(): bool
    {
        return $this->isLink;
    }
    public function isFile(): bool
    {
        return $this->isFile;
    }
}
