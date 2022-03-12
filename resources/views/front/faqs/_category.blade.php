<?php
/**
 * @var \App\Models\FaqCategory $model
 */
?>
<div class="card mb-3">
    <div class="card-body">
        <h3 class="card-title mb-1">
            {{ $model->title() }}
        </h3>
        <div class="card-text">

            @foreach($model->sortedFaqs() as $faq)
                <div id="{{ $faq->slug() }}" class="faq-block">
                    <a href="#{{ $faq->slug() }}"><i class="fas fa-hashtag faq-dynamic" data-target="#{{ $faq->slug() }}-answer"></i></a>
                    <a href="#" class="question-title" data-toggle="collapse" data-target="#{{ $faq->slug() }}-answer">
                        {{ $faq->question() }}
                    </a>
                    <div id="{{ $faq->slug() }}-answer" class="faq-answer collapse in">
                        {!! $faq->answer() !!}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
