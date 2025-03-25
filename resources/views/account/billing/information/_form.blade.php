<x-grid type="1/1">
    <x-helper>{{ __('settings.billing.placeholder') }}</x-helper>

    <textarea name="profile[billing]" placeholder="" class="w-full rounded border p-2 mb-2" rows="5" maxlength="1024">{!! old('profile[billing]', \Illuminate\Support\Arr::get($user->profile, 'billing')) !!}</textarea>
</x-grid>
