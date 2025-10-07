<?php

namespace App\Services\Entity;

use App\Traits\EntityAware;
use Carbon\Carbon;

class ArchiveService
{
    use EntityAware;

    public function toggle(): void
    {
        //If archived, unarchive and vice versa 
        if (isset($this->entity->archived_at)) {
            $this->entity->archived_at = null;
        } else {
            $this->entity->archived_at = Carbon::now();
        }
        
        $this->entity->save();
    }
}
