<?php


namespace App\Observers;


use App\Facades\PostCache;
use App\Models\Release;

class ReleaseObserver
{
    public function saved(Release $release)
    {
        PostCache::clearLatest();
    }
}
