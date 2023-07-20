<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostLayoutResource as Resource;
use App\Models\PostLayout;

class PostLayoutApiController extends Controller
{
    public function index()
    {
        return Resource::collection(PostLayout::get());
    }
}
