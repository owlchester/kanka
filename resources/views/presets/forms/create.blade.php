@extends('layouts.app', [
    'title' => __('presets.create.title'),
])

@inject('campaignService', 'App\Services\CampaignService')

@section('content')

    <form method="POST" action="{{ route('presets.store', $presetType) }}">
        <x-box>
            @include('presets.forms._' . $presetType->code)
            <x-dialog.footer>
                <button type="submit" class="btn2 btn-primary">
                    {!! __('crud.save') !!}
                </button>
            </x-dialog.footer>
        </x-box>

        <input type="hidden" name="from" value="{{ $from }}" />
        @csrf
    </form>

@endsection
