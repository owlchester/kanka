<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\NewsletterStore;
use App\Jobs\Emails\MailSettingsChangeJob;
use Illuminate\Http\Request;

class NewsletterApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'identity', 'shadow']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(NewsletterStore $request)
    {
        $request->user()
            ->updateSettings($request->only(['mail_newsletter', 'mail_release', 'mail_vote']))
            ->save();

        MailSettingsChangeJob::dispatch($request->user());

        return response()->json(['success' => true]);
    }
}
