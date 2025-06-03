<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Search\AttributeSearchService;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function __construct(protected AttributeSearchService $searchService)
    {
        $this->middleware('auth');
    }

    public function index(Request $request, Campaign $campaign, Entity $entity)
    {
        return response()->json(
            $this
                ->searchService
                ->entity($entity)
                ->request($request)
                ->find()
        );
    }
}
