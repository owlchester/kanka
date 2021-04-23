<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEntityLink;
use App\Models\Entity;
use App\Models\EntityLink;
use App\Traits\GuestAuthTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class AssetController extends Controller
{
    /**
     * Guest Auth Trait
     */
    use GuestAuthTrait;

    public function __construct()
    {
        //$this->middleware('campaign.boosted');
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Entity $entity)
    {
        // Policies will always fail if they can't resolve the user.
        if (Auth::check()) {
            $this->authorize('view', $entity->child);
        } else {
            $this->authorizeEntityForGuest('read', $entity->child);
        }

        return view('entities.pages.assets.index', compact(
            'entity'
        ));
    }
}
