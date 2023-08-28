@extends('layouts.app', [
    'title' => __('presets.create.title'),
])


@section('content')

    <form method="POST" action="{{ route('presets.store', [$campaign, $presetType]) }}" class="max-w-7xl mx-auto">
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
