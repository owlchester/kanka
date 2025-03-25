<?php

namespace App\Http\Controllers\Templates;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Services\Attributes\TemplateService;
use Illuminate\Http\Request;

class LoadController extends Controller
{
    protected TemplateService $templateService;

    public function __construct(TemplateService $templateService)
    {
        $this->templateService = $templateService;
    }

    public function index(Request $request, Campaign $campaign)
    {

        return response()->json(
            $this
                ->templateService
                ->campaign($campaign)
                ->api($request->get('template'))
        );
    }
}
