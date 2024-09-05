
@if (!empty($label))
    <label>{{ \App\Facades\Module::plural(config('entities.ids.tag'), __('entities.tags')) }}
        @if(!empty($helper))
            <x-helpers.tooltip :title="$helper" />
        @endif
    </label>
@endif

<select multiple="multiple" name="tags[]" id="{{ $id }}"
        class="form-tags"
        style="width: 100%"
        data-url="{{ $model instanceof App\Models\Tag ? route('tags.find', [$campaign, 'exclude' => $model->id] ) : route('tags.find', $campaign) }}"
        data-allow-new="{{ $allowNew ? 'true' : 'false' }}"
        data-placeholder="{{ __('crud.placeholders.multiple') }}"
        @if ($allowClear) data-allow-clear="true" @endif
        data-new-tag="{{ __('tags.create.title') }}"
        @if (!empty($dropdownParent)) data-dropdown-parent="{{ $dropdownParent }}" @endif
>
    <?php /** @var \App\Models\Tag $tag */?>
    @foreach ($tags as $key => $tag)
        <option value="{{ $key }}" data-colour="{{ $tag->colourClass() }}" selected="selected">{{ $tag->name }} </option>
    @endforeach
</select>
