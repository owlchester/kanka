<x-forms.field
    field="name"
    required
    :label="__('campaigns/styles.fields.name')">
    <input type="text" name="name" placeholder="{{ __('campaigns/styles.placeholders.name') }}" maxlength="191" required value="{!! htmlspecialchars(old('name', $style->name ?? null)) !!}" />
</x-forms.field>

<x-forms.field
    field="content"
    required
    :label="__('campaigns/styles.fields.content')"
    :helper="__('campaigns.helpers.css')">
    <textarea name="content" id="css" class="codemirror" spellcheck="false">{!! old('content', $style->content ?? null) !!}</textarea>
</x-forms.field>

<x-forms.field field="enabled" :label=" __('campaigns/styles.fields.is_enabled')">
    <input type="hidden" name="is_enabled" value="0" />
    <x-checkbox :text="__('campaigns/styles.helpers.is_enabled')">
        <input type="checkbox" name="is_enabled" value="1" @if (old('is_enabled', $style->is_enabled ?? true)) checked="checked" @endif />
    </x-checkbox>
</x-forms.field>
