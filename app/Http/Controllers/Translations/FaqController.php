<?php

namespace App\Http\Controllers\Translations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Translation\StoreFaqTranslationRequest;
use App\Models\FaqCategory;
use App\Models\FaqCategoryTranslation;
use App\Models\FaqTranslation;
use Stevebauman\Purify\Facades\Purify;

class FaqController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function index()
    {
        $categories = [];
        $lang = request()->get('lang');
        if (!empty($lang)) {
            $categories = FaqCategory::ordered()->with(['translations', 'faqs', 'faqs.translations'])->get();
        }

        return view('admin.translations.faqs.index', compact(
            'categories',
            'lang',
        ));
    }

    /**
     * @param StoreFaqTranslationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(StoreFaqTranslationRequest $request)
    {
        $category = FaqCategory::find($request->get('category_id'));
        $locale = $request->get('locale');

        // Translation of cat
        $trans = FaqCategoryTranslation::categoryID($category->id)->locale($locale)->first();
        if (empty($trans)) {
            $trans = FaqCategoryTranslation::create([
                'faq_category_id' => $category->id,
                'locale' => $locale
            ]);
        }
        $trans->title = Purify::clean($request->get('title'));
        if (!empty($trans->title)) {
            $trans->save();
        }

        $faqs = $request->get('faq');
        foreach ($faqs as $id => $values) {
            $faq = FaqTranslation::faqID($id)->locale($locale)->first();
            if (empty($faq)) {
                $faq = FaqTranslation::create([
                    'faq_id' => $id,
                    'locale' => $locale
                ]);
            }
            $faq->question = Purify::clean($values['question']);
            $faq->answer = Purify::clean($values['answer']);
            if (!empty($faq->question) && !empty($faq->answer)) {
                $faq->save();
            }
        }

        return response()->json([
            'success' => true,
            'message' => ' <span class="success">(Saved <i class="fas fa-check-circle"></i>)</span>'
        ]);
    }
}
