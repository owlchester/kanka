<?php

namespace App\Http\Controllers;

use App\Facades\FrontCache;
use App\Http\Requests\FilterPublicCampaignRequest;
use App\Models\Campaign;
use App\Services\ReferralService;
use Carbon\Carbon;

class FrontController extends Controller
{
    /**
     * FrontController constructor.
     */
    public function __construct(ReferralService $referralService)
    {
        $referralService->validate(request());

        $this->middleware('fullsetup', ['except' => 'index']);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index()
    {
        // Don't want unlogged people to think about this url
        if (!auth()->check()) {
            return redirect()->route('home');
        }
        $campaigns = FrontCache::featured();
        return view('front.home')
            ->with('campaigns', $campaigns);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function about()
    {
        return view('front.about');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function goodbye()
    {
        return view('front.goodbye');
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
    public function features()
    {
        return $this->cachedResponse('front.features');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function roadmap()
    {
        return $this->cachedResponse('front.roadmap');
    }

    /**
     */
    public function pricing()
    {
        if (!config('services.stripe.enabled')) {
            return redirect()->route('home');
        }
        if (request()->has('callback') && auth()->check()) {
            $id = request()->get('callback');
            $campaign = Campaign::find($id);
            if ($campaign) {
                return view('front.pricing')
                    ->with('campaign', $campaign);
            }
        }
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
    public function pressKit()
    {
        return $this->cachedResponse('front.press-kit');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function security()
    {
        return $this->cachedResponse('front.security');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function boosters()
    {
        return $this->cachedResponse('front.boosters');
    }
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function premium()
    {
        return $this->cachedResponse('front.premium');
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
    public function campaigns(FilterPublicCampaignRequest $request)
    {
        $featured = Campaign::public()->front()->featured()->get();
        $sort = (int) $request->get('sort_field_name');
        $campaigns = Campaign::public()
            ->front($sort)
            ->featured(false)
            ->filterPublic($request->only(['language', 'system', 'is_boosted', 'is_open', 'featured_until', 'genre']))
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
            ->to('https://docs.kanka.io/en/latest');
    }

    /**
     * Redirect to the api docs
     * @return \Illuminate\Http\RedirectResponse
     */
    public function api()
    {
        return redirect()
            ->to(app()->getLocale() . config('larecipe.docs.route') . '/1.0/overview');
    }

    protected function cachedResponse(string $view, int $days = 7)
    {
        return response(view($view))
            ->header('Expires', Carbon::now()->addDays($days)->toDateTimeString());
    }
}
