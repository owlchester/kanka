<div id="{{ $field }}" class="flex flex-col gap-4">
    <label for="{{ $field }}" class="text-md @if ($errors->has($field)) text-red-400 @endif">
        {{ __('spotlights.questions.' . $field) }}
    </label>
    @if ($content?->isApproved() || $content?->isApplied())
        <span class="text-light">{!! \Illuminate\Support\Arr::get($content->content_json, $field) !!}</span>
    @else
        <textarea
            name="{{ $field }}"
            id="{{ $field }}"
            rows="5"
            class="rounded border border-dark w-full p-2 bg-white"
            placeholder="{{ __('spotlights.placeholders.' . $field) }}"
        >{!! old($field, \Illuminate\Support\Arr::get($content?->content_json, $field)) !!}</textarea>
        @error($field)
            <span class="text-red-400 text-xs">{{ $message }}
        @enderror
    @endif

    @if ($field === 'kanka')
        <div class="flex">
            <label>
                <input type="checkbox" @if (old('share', \Illuminate\Support\Arr::get($content?->content_json, 'share'))) checked="checked" @endif name="share">
                {{ __('spotlights.questions.share') }}
            </label>
        </div>
    @endif
</div>
