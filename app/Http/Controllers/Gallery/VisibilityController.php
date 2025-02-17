<?php

namespace App\Http\Controllers\Gallery;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditPostVisibility;
use App\Models\Campaign;
use App\Models\Image;

class VisibilityController extends Controller
{
    public function index(Campaign $campaign, Image $image)
    {
        $this->authorize('gallery', $campaign);

        return view('gallery.file.visibility.edit')
            ->with('campaign', $campaign)
            ->with('image', $image);
    }

    public function save(EditPostVisibility $request, Campaign $campaign, Image $image)
    {
        $this->authorize('gallery', $campaign);

        if (request()->ajax()) {
            return response()->json();
        }

        $image->visibility_id = $request->visibility_id;
        $image->save();

        return redirect()->back()->withSuccess(__('entities/image.visibility.updated'));
    }
}
