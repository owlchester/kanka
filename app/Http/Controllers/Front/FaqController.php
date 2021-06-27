<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\FaqCategory;
use App\Services\CommunityVoteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FaqController extends Controller
{
    /**
     * @var FaqService
     */
    protected $service;

    /**
     * FaqController constructor.
     * @param FaqService $service
     */
    public function __construct(CommunityVoteService $service)
    {
        //$this->service = $service;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $categories = FaqCategory::orderBy('order')->with('faqs')->get();

        return view('front.faqs.index', compact('categories'));
    }


    /**
     * @param $id
     * @param string $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Faq $faq, $slug = '')
    {
        return view('front.faqs.show', [
            'model' => $faq,
        ]);
    }
}
