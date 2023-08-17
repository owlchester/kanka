
<div class="field-tag">
    @if (!empty($label))
        <label>{{ \App\Facades\Module::plural(config('entities.ids.tag'), __('entities.tags')) }}
            @if(!empty($helper))
                <i class="fa-solid fa-question-circle hidden-xs hidden-sm" data-toggle="tooltip" data-title="{{ $helper }}" aria-hidden="true"></i>
            @endif
        </label>
    @endif

    <select multiple="multiple" name="tags[]" id="{{ $id }}"
            class="form-control form-tags"
            style="width: 100%"
            data-url="{{ route('tags.find', $campaign) }}"
            data-allow-new="{{ $allowNew ? 'true' : 'false' }}"
            data-placeholder=""
            @if ($allowClear) data-allow-clear="true" @endif
            data-new-tag="{{ __('tags.create.title') }}"
            @if (!empty($dropdownParent)) data-dropdown-parent="{{ $dropdownParent }}" @endif
    >
        <?php /** @var \App\Models\Tag $tag */?>
        @foreach ($tags as $key => $tag)
            <option value="{{ $key }}" data-colour="{{ $tag->colourClass() }}" selected="selected">{{ $tag->name }}</option>
        @endforeach
    </select>
</div>
