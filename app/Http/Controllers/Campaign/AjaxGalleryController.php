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
        /*
        [{
            "src": "https://picsum.photos/id/40/200/200",
            "title": "a galerie test"
        }, {
            "src": "https://picsum.photos/id/50/200/200",
            "title": "a galerie test"
        }]
        */

        $start = request()->get('page', 0);
        $perPage = 20;
        $offset = $start * $perPage;

        $response = [
            'data' => [],
            'links' => []
        ];
        $images = Image::orderBy('updated_at', 'desc')->offset($offset)->take(20)->get();
        foreach ($images as $image) {
            $response['data'][] = [
                'src' => Storage::url($image->path),
                'title' => $image->name,
            ];
        }

        // Next page
        $total = Image::count();
        if ($offset + $perPage < $total) {
            $response['links']['next'] = route('campaign.gallery.summernote', ['page' => $start + 1]);
        }

        return response()->json($response);
    }
}
