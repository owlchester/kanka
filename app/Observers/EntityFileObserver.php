<?php

namespace App\Observers;

use App\Models\EntityFile;
use App\Models\Event;
use App\Models\MiscModel;
use App\Services\ImageService;
use App\Services\LinkerService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Stevebauman\Purify\Purify;

class EntityFileObserver
{
    /**
     * @param EntityFile $EntityFile
     */
    public function creating(EntityFile $entityFile)
    {
        $entityFile->created_by = auth()->user()->id;
    }

    public function deleted(EntityFile $entityFile)
    {
        ImageService::cleanup($entityFile, 'path');
    }

    /**
     * @param EntityFile $EntityFile
     */
//    public function saving(EntityFile $EntityFile)
//    {
//    }
}
