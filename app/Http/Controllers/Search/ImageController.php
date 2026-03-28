<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Image;
use Illuminate\Http\JsonResponse;

class ImageController extends Controller
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

    public function folders(Campaign $campaign): JsonResponse
    {
        $this->authorize('gallery', $campaign);

        /** @var Image[] $folders */
        $folders = Image::where('campaign_id', $campaign->id)
            ->where('is_folder', true)
            ->where('name', 'like', '%' . request()->get('q') . '%')
            ->orderBy('name', 'asc')
            ->limit(20)
            ->get();

        $formatted = [];

        foreach ($folders as $folder) {
            $formatted[] = [
                'id' => $folder->id,
                'text' => $folder->name,
            ];
        }

        return response()->json($formatted);
    }
}
