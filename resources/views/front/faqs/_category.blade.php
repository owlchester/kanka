<?php
/**
 * @var \App\Models\FaqCategory $model
 */
?>
<div class="card mb-3">
    <div class="card-body">
        <h3 class="card-title mb-1">
            {{ $model->title }}
        </h3>
        <div class="card-text">

            @foreach($model->sortedFaqs() as $faq)
                <a href="{{ route('front.faqs.show', [$faq, 'slug' => \Illuminate\Support\Str::slug($faq->question)]) }}">
                    {{ $faq->question }}
                </a>
                <br />
            @endforeach
        </div>
    </div>
</div>
