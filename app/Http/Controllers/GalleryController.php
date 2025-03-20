<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Image;

class GalleryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Campaign $campaign)
    {
        $this->authorize('gallery', $campaign);

        $folder = null;
        $folderId = request()->get('folder_id');
        if (! empty($folderId)) {
            $folder = Image::where('is_folder', '1')->where('id', $folderId)->firstOrFail();
        }

        return view('gallery.index', compact('campaign', 'folder'));
    }
}
