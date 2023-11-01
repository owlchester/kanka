<?php

namespace App\Http\Controllers\Campaign\Gallery;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Image;

class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('campaign.member');
    }

    public function index(Campaign $campaign)
    {
        $this->authorize('gallery', $campaign);

        $name = trim(request()->get('q', null));
        if (empty($name)) {
            $images = $campaign->images()->with('user')
                ->imageFolder(null)
                ->defaultOrder()
                ->paginate(50);
        } else {
            $images = Image::where('name', 'like', "%{$name}%")
                ->defaultOrder()
                ->take(50)
                ->get();
        }

        return view('gallery.images', compact(
            'images',
            'campaign',
        ));
    }
}
