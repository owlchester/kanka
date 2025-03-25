<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Image;

class ImageSearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Campaign $campaign)
    {
        /** @var Image[] $images */
        $images = Image::where('is_default', false)
            ->where('is_folder', false)
            ->where('name', 'like', '%' . request()->get('q') . '%')
            ->limit(10)
            ->get();

        $formatted = [];

        foreach ($images as $image) {
            $format = [
                'id' => $image->id,
                'text' => $image->name,
                'image' => $image->getUrl(40),
            ];

            $formatted[] = $format;
        }

        return response()->json($formatted);
    }
}
