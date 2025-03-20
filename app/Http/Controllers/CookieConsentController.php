<?php

namespace App\Http\Controllers;

use App\Services\CountryService;

class CookieConsentController extends Controller
{
    protected CountryService $service;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CountryService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $country = $this->service->getCountry();

        return response()->json([
            'country' => $country,
        ]);
    }
}
