<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Models\Entity;
use App\Traits\GuestAuthTrait;

class TimelineController extends Controller
{
    use GuestAuthTrait;

    public function index(Entity $entity)
    {
        if (empty($entity->child)) {
            abort(404);
        }

        return redirect()->to($entity->url());
    }
}
