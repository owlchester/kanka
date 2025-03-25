<?php

namespace App\Services\Api;

use App\Models\Faq;
use App\Models\FaqCategory;

class KbService
{
    public function api(): array
    {
        $data = [];

        $categories = FaqCategory::visible()->ordered()->with(['faqs'])->get();
        /** @var FaqCategory $category */
        foreach ($categories as $category) {
            $questions = [];

            /** @var Faq $faq */
            foreach ($category->sortedFaqs() as $faq) {
                $questions[] = [
                    'id' => $faq->id,
                    'q' => $faq->question(),
                    'a' => $faq->answer(),
                    'slug' => $faq->slug(),
                ];
            }

            if (empty($questions)) {
                continue;
            }

            $data[] = [
                'id' => $category->id,
                'name' => $category->title,
                'questions' => $questions,
            ];
        }

        return $data;
    }
}
