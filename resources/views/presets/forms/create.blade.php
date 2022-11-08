@extends('layouts.app', [
    'title' => __('presets.create.title'),
])

@inject('campaignService', 'App\Services\CampaignService')

@section('content')

    <form method="POST" action="{{ route('presets.store', $presetType) }}">
        <div class="panel">
            @include('presets.forms._' . $presetType->code)
            <div class="panel-footer">
                @include('partials.footer_cancel')

                <button type="submit" class="btn btn-success pull-right">
                    {!! __('crud.save') !!}
                </button>
            </div>
        </div>

        <input type="hidden" name="from" value="{{ $from }}" />
        @csrf
    </form>

@endsection
