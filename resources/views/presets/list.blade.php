@if (!$presets->isEmpty())
    <div class="grid grid-cols-4 gap-2 mb-2">
        @foreach ($presets as $preset)
            <div class="preset p-2">
                <a href="{{ route('preset_types.presets.edit', [$presetType, $preset, 'from' => $from]) }}" class="pull-right preset-edit px-1">
                    <i class="fa-solid fa-pencil" aria-hidden="true"></i>
                </a>

                <span role="button" class="preset-use cursor-pointer" data-url="{{ route('preset_types.presets.show', [$presetType, $preset]) }}">
                    <i class="fa-solid fa-spin fa-spinner" style="display: none" aria-hidden="true"></i>
                    {{ $preset->name }}
                </span>

            </div>
        @endforeach
    </div>
@else
    <div class="alert alert-warning">
        {!! __('presets.lists.empty') !!}
    </div>
@endif
