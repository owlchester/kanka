<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Http\Requests\Campaigns\Vanity;
use App\Models\Campaign;
use Illuminate\Support\Str;

class VanityController extends Controller
{
    public function index(Vanity $request, Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        return response([
            'success' => true,
            'vanity' => Str::slug($request->post('vanity')),
        ]);
    }
}
