@extends('layouts.app', ['title' => __('Delete status'), 'mainTitle' => false, 'sidebar' => 'campaign'])

@section('content')
    <x-form :action="['entity_types.statuses.destroy', $campaign, $entityType, $status]" method="DELETE">
        <div class="bg-box rounded-xl p-6 flex flex-col gap-4 max-w-3xl">
            <h1 class="text-xl">{{ __('Delete status') }}: {{ $status->name() }}</h1>
            @include('partials.errors')
            <p>{{ __('This affects :count entries, including deleted entries.', ['count' => $count]) }}</p>
            <p>{{ __('Replacement also updates saved bookmark and widget filters. Clearing leaves affected filters nonmatching until edited; it never broadens a list.') }}</p>
            @if($status->is_default)
                <p>{{ __('This is the default status. Its replacement becomes the default; clearing removes the default.') }}</p>
            @endif
            <label class="flex flex-col gap-2">
                <span>{{ __('Replace with') }}</span>
                <select name="replacement_id">
                    <option value="">{{ __('No replacement') }}</option>
                    @foreach($statuses as $replacement)
                        <option value="{{ $replacement->id }}" @selected((string) old('replacement_id') === (string) $replacement->id)>{{ $replacement->name() }}</option>
                    @endforeach
                </select>
            </label>
            <label class="flex items-center gap-2"><input type="checkbox" name="clear" value="1" @checked(old('clear')) />{{ __('If no replacement is selected, clear assignments.') }}</label>
            <div class="flex gap-3">
                <a href="{{ route('entity_types.edit', [$campaign, $entityType]) }}" class="btn2">{{ __('crud.cancel') }}</a>
                <button type="submit" class="btn2 btn-error">{{ __('Delete status') }}</button>
            </div>
        </div>
    </x-form>
@endsection
