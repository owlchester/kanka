<?php

namespace App\Http\Controllers\Entity\Posts;

use App\Http\Controllers\Controller;
use App\Models\Entity;
use App\Models\Campaign;

class LayoutController extends Controller
{
    public function index(Campaign $campaign, Entity $entity)
    {
        $this->authorize('view', [$entity]);

        return view('entities.pages.posts.layouts.index')
            ->with('campaign', $campaign)
            ->with('entity', $entity);
    }
}
