<?php


namespace App\Observers;


use App\Facades\PostCache;
use App\Models\AppRelease;

class AppReleaseObserver
{
    public function creating(AppRelease $release)
    {
        $release->created_by = auth()->user()->id;
    }

    public function saved(AppRelease $release)
    {
        PostCache::clearLatest();
    }
}
