@extends('layouts.front', [
    'menus' => [
        'faq',
    ],
    'menu_js' => false
])
@section('content')
    <section class="features" id="faq">
        <div class="container">
            <div class="section-heading text-center">
                <h2>{{ trans('front.faq.title') }}</h2>
                <p class="text-muted">{{ trans('front.faq.description') }}</p>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-5">
                        <?php $count = 0 ?>
                        @foreach ($faqs as $faq)
                            <h4>{{ $faq->question }}</h4>
                            <p class="text-muted">{!! nl2br($faq->answer) !!}</p>
                            <hr>
                            <?php $count++; ?>
                            @if($count == ceil(count($faqs) / 2))
                    </div><div class="col-md-5 offset-md-2">
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection