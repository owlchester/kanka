<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Resources\ProfileResource;

class ProfileApiController extends ApiController
{
    public function index()
    {
        return new ProfileResource(auth()->user());
    }
}
