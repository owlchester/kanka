<?php


namespace App\Observers;


use App\Facades\PostCache;
use App\Models\AppRelease;

class AppReleaseObserver
{
    use PurifiableTrait;

    /**
     * @param AppRelease $release
     */
    public function creating(AppRelease $release)
    {
        $release->created_by = auth()->user()->id;
    }

    /**
     * @param AppRelease $release
     */
    public function saving(AppRelease $release)
    {
        $release->name = $this->purify($release->name);
        $release->excerpt = $this->purify($release->excerpt);
    }

    /**
     * @param AppRelease $release
     */
    public function saved(AppRelease $release)
    {
        PostCache::clearLatest();
    }
}
