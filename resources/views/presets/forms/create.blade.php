@extends('layouts.app', [
    'title' => __('presets.create.title'),
])

@inject('campaignService', 'App\Services\CampaignService')

@section('content')

    <form method="POST" action="{{ route('presets.store', $presetType) }}">
        <x-box>
            @include('presets.forms._' . $presetType->code)
            <x-box.footer>
                @include('partials.footer_cancel')

                <button type="submit" class="btn btn-success pull-right">
                    {!! __('crud.save') !!}
                </button>
            </x-box.footer>
        </x-box>

        <input type="hidden" name="from" value="{{ $from }}" />
        @csrf
    </form>

@endsection
