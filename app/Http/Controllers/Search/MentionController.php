<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\Ability;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\Organisation;
use App\Models\OrganisationMember;
use App\Models\Tag;
use Illuminate\Http\Request;

class MentionController extends Controller
{
    public function __construct(protected \App\Services\Search\MentionService $service) {}

    public function index(Request $request, Campaign $campaign)
    {

        if (auth()->check()) {
            $this->service->user(auth()->user());
        }

        $this->service
            ->request($request)
            ->campaign($campaign);

        return response()->json(
            $this->service->search()
        );
    }

}
