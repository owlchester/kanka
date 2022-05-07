<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\VisibilityResource;
use App\Models\Visibility;

class VisibilityController extends Controller
{
    public function index()
    {
        return VisibilityResource::collection(
            Visibility::get()
        );
    }
}
