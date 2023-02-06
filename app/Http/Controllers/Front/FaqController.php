<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\FaqCategory;

class FaqController extends Controller
{
    /**
     */
    public function index()
    {
        // @phpstan-ignore-next-line
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
