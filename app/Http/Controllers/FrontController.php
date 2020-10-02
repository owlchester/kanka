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
        response()->header('Expires', Carbon::now()->addDays(7)->toDateTimeString());
        return view('front.community');
        return $this->cachedResponse('front.contact');
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
     * Public Campaigns
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function campaigns(Request $request)
    {
        $features = Campaign::public()->front()->featured()->get();
        $campaigns = Campaign::public()->front()->featured(false)->filterPublic($request->only(['language', 'system', 'is_boosted']))->paginate();

        if (getenv('APP_ENV') === 'shadow') {
            $features = $campaigns = new Collection();
        }

        return view('front.campaigns')
            ->with('featured', $features)
            ->with('campaigns', $campaigns);
    }

    protected function cachedResponse(string $view, int $days = 7)
    {
        return response(view($view))
            ->header('Expires', Carbon::now()->addDays($days)->toDateTimeString());
    }
}
