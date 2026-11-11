@extends('layouts.app', ['title' => __('campaigns/modules.create.title'), 'mainTitle' => false, 'sidebar' => 'campaign'])

@section('content')
    <div class="bg-box rounded-xl p-6 flex flex-col gap-4">
        @include($reason)
        <a href="{{ route('campaign.modules', $campaign) }}" class="text-link">{{ __('Back to categories') }}</a>
    </div>
@endsection
