<?php

namespace App\Http\Controllers\Summernote;

use App\Http\Controllers\Controller;
use App\Http\Requests\Campaigns\GalleryImageStore;
use App\Models\Campaign;
use App\Models\Image;
use App\Services\Gallery\SummernoteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;

class GalleryController extends Controller
{
    protected SummernoteService $service;

    public function __construct(SummernoteService $service)
    {
        $this->middleware('auth');
        $this->service = $service;
    }

    public function index(Campaign $campaign)
    {
        $start = request()->get('page', 0);
        $name = request()->get('name');
        $perPage = 20;
        $offset = $start * $perPage;

        $response = [
            'data' => [],
            'links' => [],
        ];

        // Has folder? Go back option
        $folderId = request()->get('folder_id');
        if (! empty($folderId) && ! request()->has('page')) {
            $image = Image::where('is_folder', true)->where('id', $folderId)->firstOrFail();

            $response['data'][] = [
                'title' => __('crud.actions.back'),
                'folder' => $image->is_folder,
                'id' => $image->id,
                'icon' => 'fa-regular fa-arrow-left',
                'url' => route('campaign.gallery.summernote', $image->folder_id ? [$campaign, 'folder_id' => $image->folder_id] : [$campaign]),
            ];
        }
        $canBrowse = auth()->user()->can('browse', [Image::class, $campaign]);
        $images = Image::acl($canBrowse)
            ->where('is_default', false)
            ->orderBy('is_folder', 'desc')
            ->orderBy('updated_at', 'desc')
            ->imageFolder($folderId)
            ->offset($offset)
            ->take(20);
        if ($name) {
            $images->where('name', 'like', "%{$name}%");
        }
        $images = $images->get();
        /** @var Image $image */
        foreach ($images as $image) {
            $response['data'][] = [
                'src' => $image->url(),
                'title' => $image->name,
                'folder' => $image->is_folder,
                'icon' => 'fa-regular fa-folder',
                'id' => $image->id,
                'url' => $image->is_folder ? route('campaign.gallery.summernote', [$campaign, 'folder_id' => $image->id]) : [$campaign],
                'thumb' => $image->getImagePath(128, 128),
            ];
        }

        // Next page
        $total = Image::count();
        if ($offset + $perPage < $total) {
            $params = ['page' => $start + 1];
            $params[] = $campaign;
            if (! empty($folderId)) {
                $params['folder_id'] = $folderId;
            }
            $response['links']['next'] = route('campaign.gallery.summernote', $params);
        }

        return response()->json($response);
    }

    /**
     * Called when adding an image from the text editor
     */
    public function upload(GalleryImageStore $request, Campaign $campaign): JsonResponse
    {
        $this->authorize('create', [Image::class, $campaign]);

        $images = $this->service
            ->campaign($campaign)
            ->user(auth()->user())
            ->store($request);
        /** @var Image $image */
        $image = Arr::first($images);

        return response()->json([
            'url' => $image->url(),
            'id' => $image->id,
        ]);
    }
}
