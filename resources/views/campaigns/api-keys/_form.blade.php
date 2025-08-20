<x-grid type="1/1">
    <x-forms.field
        field="provider"
        required
        :label="__('campaigns/api-keys.fields.provider')"
        >
        @php
            $options= [Prism\Prism\Enums\Provider::OpenAI->value => config('askbragi.providers.' . Prism\Prism\Enums\Provider::OpenAI->value),
            ];
        @endphp
        <x-forms.select name="provider" :options="$options" :selected="$apiKey->provider ?? null" />
    </x-forms.field>

    <x-forms.field
        field="model"
        required
        :label="__('campaigns/api-keys.fields.model')"
        >
        @php
            $options= [
                config('askbragi.openai'),
            ];
        @endphp
        <x-forms.select name="model" :options="$options" :selected="$apiKey->model ?? null" />
    </x-forms.field>

    <x-forms.field
        field="api_key"
        required
        :label="__('campaigns/api-keys.fields.api-key')"
        >
        <input type="text" name="api_key" value="{{ old('api_key', $apiKey->api_key ?? null) }}" maxlength="191" required class="w-full" placeholder="{{ __('campaigns/api-keys.placeholders.api-key') }}"/>
    </x-forms.field>

    <x-forms.field
        field="is_enabled"
        :label="__('campaigns/webhooks.fields.enabled')">
        <input type="hidden" name="is_enabled" value="0" />
        <x-checkbox :text="__('campaigns/api-keys.helper.active')">
            <input type="checkbox" name="is_enabled" value="1" @if (old('is_enabled', $apiKey->status ?? true)) checked="checked" @endif />
        </x-checkbox>
    </x-forms.field>
</x-grid>

