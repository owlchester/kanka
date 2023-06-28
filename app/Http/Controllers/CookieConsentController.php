<?php

namespace App\Http\Controllers;

class CookieConsentController extends Controller
{
    public function index()
    {
        $country = 'CH';
        if (isset($_SERVER["HTTP_CF_IPCOUNTRY"])) {
            $country = mb_substr($_SERVER["HTTP_CF_IPCOUNTRY"], 0, 6);
        }
        return response()->json([
            'country' => $country
        ]);
    }
}
