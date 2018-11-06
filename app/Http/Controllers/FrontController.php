<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Faq;
use App\Services\PatreonService;

class FrontController extends Controller
{
    /**
     * @var PatreonService
     */
    protected $patreon;

    /**
     * FrontController constructor.
     * @param PatreonService $patreonService
     */
    public function __construct(PatreonService $patreonService)
    {
        $this->patreon = $patreonService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function about()
    {
        $patrons = $this->patreon->patrons();
        return view('front.about', compact('patrons'));
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
    public function community()
    {
        return view('front.community');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function roadmap()
    {
        return view('front.roadmap');
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
