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
     */
    public function index()
    {
        $categories = FaqCategory::visible()->ordered()->with(['localeTranslation', 'faqs', 'faqs.localeTranslation'])->get();

        return view('front.faqs.index', compact('categories'));
    }

    /**
     */
    public function show(Faq $faq, $slug = '')
    {
        return view('front.faqs.show', [
            'model' => $faq,
        ]);
    }
}
