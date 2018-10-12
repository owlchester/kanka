<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Faq;
use App\User;
use TCG\Voyager\Models\Role;

class FrontController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function about()
    {
        // We need to do this workaround since role->users() returns the TCG\User group, which doesn't have
        // our accessors for the patreon data.
        $role = Role::where(['name' => 'patreon'])->first();
        $ids = $role->users()->pluck('id');
        $users = User::whereIn('id', $ids)->get();
        return view('front.about', compact('users'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tos()
    {
        return view('front.tos');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function privacy()
    {
        return view('front.privacy');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function help()
    {
        return view('front.help');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function features()
    {
        return view('front.features');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function faq()
    {
        $faqs = Faq::locale(app()->getLocale())->visible()->ordered()->get();
        return view('front.faq')->with('faqs', $faqs);
    }

    /**
     * Public Campaigns
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function campaigns()
    {
        $features = Campaign::public()->featured()->orderBy('name', 'asc')->get();
        $campaigns = Campaign::public()->featured(false)->orderBy('name', 'asc')->paginate();

        return view('front.campaigns')
            ->with('featured', $features)
            ->with('campaigns', $campaigns);
    }
}
