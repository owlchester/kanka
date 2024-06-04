{{ csrf_field() }}
<x-grid type="1/1">
<x-forms.field
    field="action"
    :required="true"
    :label="__('campaigns/webhooks.fields.event')"
    >
    {!! Form::select('action', [
    \App\Enums\WebhookAction::CREATED->value => __('campaigns/webhooks.fields.events.new'),
    \App\Enums\WebhookAction::EDITED->value => __('campaigns/webhooks.fields.events.edited'),
    \App\Enums\WebhookAction::DELETED->value => __('campaigns/webhooks.fields.events.deleted')]) !!}
</x-forms.field>

<x-forms.field
    field="url"
    :required="true"
    :label="__('campaigns/webhooks.fields.url')"
    >
    {!! Form::text('url', null, ['placeholder' => __('campaigns/webhooks.placeholders.url'), 'class' => '', 'maxlength' => 191, 'required']) !!}
</x-forms.field>

<x-forms.field field="target" :label="__('campaigns/webhooks.fields.type')">
    <select name="type" class="" id="webhook-selector">
        <option value="1" @if(isset($webhook) && $webhook->type == 1) selected="selected" @endif data-target="#webhook-custom">
            {{ __('campaigns/webhooks.fields.types.custom') }}
        </option>
        <option value="2" @if(isset($webhook) && $webhook->type == 2) selected="selected" @endif>
            {{ __('campaigns/webhooks.fields.types.payload') }}
        </option>

    </select>
</x-forms.field>

<div class="webhook-subform @if(isset($webhook) && $webhook->type == 2)) hidden @endif" id="webhook-custom">
    <x-forms.field
        field="message"
        :required="true"
        :label="__('campaigns/webhooks.fields.message')"
        :tooltip="true"
        :helper="__('campaigns/webhooks.helper.message')"
        link="https://docs.kanka.io/en/latest/features/campaigns/webhooks.html#mappings"
        >

        <textarea name="message" class="w-full" rows="4" placeholder="{{ __('campaigns/webhooks.placeholders.message') }}" maxlength="400">{!! old('message', $webhook->message ?? null) !!}</textarea>
    </x-forms.field>
</div>

<x-forms.field
    field="status"
    :label="__('campaigns/webhooks.fields.enabled')">
    <input type="hidden" name="status" value="0" />
    <x-checkbox :text="__('campaigns/webhooks.helper.active')">
        <input type="checkbox" name="status" value="1" @if (old('status', $webhook->status ?? true)) checked="checked" @endif />
    </x-checkbox>
</x-forms.field>

<x-forms.field field="tags">
    <input type="hidden" name="save-tags" value="1" />

    <x-forms.tags
        :campaign="$campaign"
        :model="$webhook ?? null"
        allowClear="false"
        :dropdownParent="$dropdownParent ?? null"
    ></x-forms.tags>
</x-forms.field>

</x-grid>

