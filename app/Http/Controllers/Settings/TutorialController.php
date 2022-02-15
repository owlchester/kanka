<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Services\TutorialService;

class TutorialController extends Controller
{
    /** @var TutorialService */
    protected $service;

    /**
     * @param TutorialService $service
     */
    public function __construct(TutorialService $service)
    {
        $this->middleware(['auth', 'identity']);
        $this->service = $service;
    }

    /**
     * @param string $key
     * @param $next
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function done(string $key, $next = null)
    {
        return $this->service
            ->user(auth()->user())
            ->done($key, $next);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function disable()
    {
        $this->service
            ->user(auth()->user())
            ->disable();

        return response()
            ->json([
                'success' => true,
            ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reset()
    {
        $this->service
            ->user(auth()->user())
            ->reset();

        //return redirect()->route('home');
    }
}
