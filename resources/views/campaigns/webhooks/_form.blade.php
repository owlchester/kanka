{{ csrf_field() }}
<x-grid type="1/1">
<x-forms.field
    field="action"
    :required="true"
    :label="__('campaigns/webhooks.fields.event')"
    >
    {!! Form::select('action', [1 => __('campaigns/webhooks.fields.events.new'), 2 => __('campaigns/webhooks.fields.events.edited'), 3 => __('campaigns/webhooks.fields.events.deleted')]) !!}
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
        >
        {!! Form::text('message', null, ['placeholder' => __('campaigns/webhooks.placeholders.message'), 'class' => '', 'maxlength' => 400, 'required' => false]) !!}
    </x-forms.field>
</div>

<x-forms.field
    field="status"
    :label="__('campaigns/webhooks.fields.active')">
    {!! Form::hidden('status', 1) !!}
    <x-checkbox :text="__('campaigns/webhooks.helper.active')">
        {!! Form::checkbox('status', 1, isset($webhook) ? $webhook->status : 1) !!}
    </x-checkbox>
</x-forms.field>

@include('cruds.fields.tags', ['enableNew' => false, 'model' => isset($webhook) ? $webhook : ''])

</x-grid>

