<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Faq;
use App\Services\PatreonService;
use App\Services\ReferralService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

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
    public function __construct(PatreonService $patreonService, ReferralService $referralService)
    {
        $this->patreon = $patreonService;
        $referralService->validate(request());
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index()
    {
        // Don't want unlogged people to think about this url
        if(!auth()->check()) {
            return redirect()->route('home');
        }
        return view('front.home');
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
    public function hallOfFame()
    {
        $patrons = $this->patreon->patrons();
        return view('front.hall_of_fame', compact('patrons'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tos()
    {
        return $this->cachedResponse('front.tos');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function privacy()
    {
        return $this->cachedResponse('front.privacy');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function terms()
    {
        return $this->cachedResponse('front.terms');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function help()
    {
        return $this->cachedResponse('front.help');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function features()
    {
        return $this->cachedResponse('front.features');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function community()
    {
        return abort(404);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function roadmap()
    {
        return $this->cachedResponse('front.roadmap');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function pricing()
    {
        return $this->cachedResponse('front.pricing');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function contact()
    {
        return $this->cachedResponse('front.contact');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function media()
    {
        return $this->cachedResponse('front.media');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function gmFeatures()
    {
        return $this->cachedResponse('front.features.gm');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function wbFeatures()
    {
        return $this->cachedResponse('front.features.worldbuilding');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function partners()
    {
        return $this->cachedResponse('front.partners');
    }

    /**
     * Public Campaigns
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function campaigns(Request $request)
    {
        $featured = Campaign::public()->front()->featured()->get();
        $campaigns = Campaign::public()
            ->front()
            ->featured(false)
            ->filterPublic($request->only(['language', 'system', 'is_boosted', 'is_open']))
            ->paginate();

        return view('front.campaigns')
            ->with('featured', $featured)
            ->with('campaigns', $campaigns);
    }

    /**
     * Redirect to the kanka documentation campaign
     * @return \Illuminate\Http\RedirectResponse
     */
    public function documentation()
    {
        return redirect()
            ->to(app()->getLocale() . '/campaign/' . 20000);
    }

    protected function cachedResponse(string $view, int $days = 7)
    {
        return response(view($view))
            ->header('Expires', Carbon::now()->addDays($days)->toDateTimeString());
    }
}
