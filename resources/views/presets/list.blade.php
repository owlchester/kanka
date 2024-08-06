@if (!$presets->isEmpty())
    <div class="grid grid-cols-4 gap-2">
        @foreach ($presets as $preset)
            <div class="preset p-2 bg-base-300 hover:shadow-md flex gap-2  rounded">
                <span role="button" class="preset-use cursor-pointer hover:underline grow" data-url="{{ route('preset_types.presets.show', [$campaign, $presetType, $preset]) }}">
                    <i class="fa-solid fa-spin fa-spinner" style="display: none" aria-hidden="true"></i>
                    {{ $preset->name }}
                </span>
                <a href="{{ route('preset_types.presets.edit', [$campaign, $presetType, $preset, 'from' => $from]) }}" class="preset-edit px-1">
                    <x-icon class="pencil" />
                </a>
            </div>
        @endforeach
    </div>
@else
    <x-alert type="warning">
        {!! __('presets.lists.empty') !!}
    </x-alert>
@endif
