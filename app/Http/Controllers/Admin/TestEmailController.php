<?php


namespace App\Http\Controllers\Admin;


use App\Jobs\Emails\WelcomeEmailJob;
use Illuminate\Support\Facades\Auth;

class TestEmailController
{
    /**
     * Send a test email
     * @return \App\Mail\WelcomeEmail|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $send = request()->has('send');

        if ($send) {
            WelcomeEmailJob::dispatch(Auth::user(), app()->getLocale());

            return response()->json(['success' => true]);
        }

        return new \App\Mail\WelcomeEmail(Auth::user());
    }
}
