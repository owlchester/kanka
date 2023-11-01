<x-grid type="1/1">
    <x-forms.field field="visibility" :label="__('entities/permissions.quick.field')">
        <select name="privacy" id="quick-privacy-select" class="" data-url="{{ route('entities.quick-privacy.toggle', [$campaign, $entity]) }}">
            <option value="0">{{ __('entities/permissions.quick.options.visible') }}</option>
            <option value="1" @if ($entity->is_private) selected="selected" @endif>{{ __('entities/permissions.quick.options.private') }}</option>
        </select>
    </x-forms.field>

    <hr class="m-0" />

    <p class="font-extrabold m-0">
        {{ __('entities/permissions.quick.viewable-by') }}
    </p>
    @if (!empty($visibility['roles']) || !empty($visibility['users']))
        <div class="@if ($entity->is_private) line-through text-slate-400 @endif">
            @foreach ($visibility['roles'] as $element)<span class="mr-1"><i class="fa-solid fa-user-group" aria-hidden="true"></i> {!! $element !!}</span>@endforeach
            @if (!empty($visibility['roles']))<br />@endif
            @foreach ($visibility['users'] as $element)<span class="mr-1"><i class="fa-solid fa-user" aria-hidden="true"></i> {!! $element !!}</span>@endforeach
        </div>
    @else
        <p class="text-neutral-content m-0">
            {{ __('entities/permissions.quick.empty-permissions') }}
        </p>
    @endif
</x-grid>
