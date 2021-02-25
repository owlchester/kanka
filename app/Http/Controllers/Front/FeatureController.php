<?php


namespace App\Http\Controllers\Front;


use App\Http\Controllers\Controller;
use Carbon\Carbon;

class FeatureController extends Controller
{
    public function timelines()
    {
        return $this->cachedResponse('front.features.timelines');
    }

    protected function cachedResponse(string $view, int $days = 7)
    {
        return response(view($view))
            ->header('Expires', Carbon::now()->addDays($days)->toDateTimeString());
    }
}
