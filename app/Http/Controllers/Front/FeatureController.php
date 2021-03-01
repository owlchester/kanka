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

    public function calendars()
    {
        return $this->cachedResponse('front.features.calendars');
    }

    public function secrets()
    {
        return $this->cachedResponse('front.features.secrets');
    }

    public function permissions()
    {
        return $this->cachedResponse('front.features.permissions');
    }

    public function maps()
    {
        return $this->cachedResponse('front.features.maps');
    }

    public function boosters()
    {
        return $this->cachedResponse('front.features.boosters');
    }

    public function inventoriesAbilities()
    {
        return $this->cachedResponse('front.features.inventory-abilities');
    }


    protected function cachedResponse(string $view, int $days = 7)
    {
        return response(view($view))
            ->header('Expires', Carbon::now()->addDays($days)->toDateTimeString());
    }
}
