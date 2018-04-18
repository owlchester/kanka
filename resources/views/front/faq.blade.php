@extends('layouts.front', [
    'title' => trans('front.menu.faq'),
    'menus' => [
        'faq',
    ],
])
@section('content')
    <header class="masthead">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-12 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-5">{{ trans('front.faq.title') }}</h1>
                        <p class="mb-5">{{ trans('front.faq.description') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="features" id="faq">
        <div class="container">
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