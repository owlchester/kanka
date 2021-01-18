<?php


namespace App\Http\Controllers\Campaign;


use App\Facades\Img;
use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class AjaxGalleryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $start = request()->get('page', 0);
        $perPage = 20;
        $offset = $start * $perPage;

        $response = [
            'data' => [],
            'links' => []
        ];

        // Has folder? Go back option
        $folderId = request()->get('folder_id');
        if (!empty($folderId) && !request()->has('page')) {
            $image = Image::where('is_folder', true)->where('id', $folderId)->firstOrFail();

            $response['data'][] = [
                'title' => __('crud.actions.back'),
                'folder' => $image->is_folder,
                'id' => $image->id,
                'url' => route('campaign.gallery.summernote', $image->folder_id ? ['folder_id' => $image->folder_id] : null),
            ];
        }
        $images = Image::where('is_default', false)
            ->orderBy('is_folder', 'desc')
            ->orderBy('updated_at', 'desc')
            ->imageFolder($folderId)
            ->offset($offset)
            ->take(20)
            ->get();
        foreach ($images as $image) {
            $response['data'][] = [
                'src' => Storage::url($image->path),
                'title' => $image->name,
                'folder' => $image->is_folder,
                'id' => $image->id,
                'url' => $image->is_folder ? route('campaign.gallery.summernote', ['folder_id' => $image->id]) : null,
            ];
        }

        // Next page
        $total = Image::count();
        if ($offset + $perPage < $total) {
            $params = ['page' => $start + 1];
            if (!empty($folderId)) {
                $params['folder_id'] = $folderId;
            }
            $response['links']['next'] = route('campaign.gallery.summernote', $params);
        }

        return response()->json($response);
    }
}
