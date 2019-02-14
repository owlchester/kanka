@extends('layouts.front', [
    'title' => trans('faq.show.title', ['name' => __("faq.$key.question")]),
    'description' => '',
    'menus' => [
        'faq'
    ],
    'menu_js' => false,
])

@section('content')
    <section class="features" id="faqs">
        <div class="container">
            <h2>{{ __("faq.$key.question") }}</h2>

            {{--<p class="text-muted">--}}
                {{--{{ trans('faq.show.timestamp', ['date' => $model->updated_at->diffForHumans()]) }}--}}
            {{--</p>--}}

            <p>{!! nl2br(__("faq.$key.answer")) !!}</p>

            @if ($key == 'permissions')
                <iframe width="560" height="315" src="https://www.youtube.com/embed/ikNPzNgjYmg" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
            @elseif ($key == 'attribute-templates')
                <iframe width="560" height="315" src="https://www.youtube.com/embed/qKnTpuePqUA" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
            @endif

            <p><a href="{{ route('faq.index') }}">{{ trans('faq.show.return') }}</a></p>
        </div>
    </section>
@endsection
