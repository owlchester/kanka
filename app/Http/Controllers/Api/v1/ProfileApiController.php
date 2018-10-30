<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Resources\Profile;

class ProfileApiController extends ApiController
{
    public function index()
    {
        return new Profile(auth()->user());
    }
}
