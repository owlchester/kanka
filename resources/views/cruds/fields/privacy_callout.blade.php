@php
$isPrivate = old('is_private', $source->is_private ?? $model->is_private ?? $campaign->entity_visibility)
@endphp
<div
    class="privacy-callout rounded-xl p-4 border border-red-300"
    x-data="{ isPrivate: {{ $isPrivate ? 'true' : 'false' }} }"
    x-init="$watch('isPrivate', value => { $dispatch('entity-privacy-changed', value) })"
>
    <input type="hidden" name="is_private" value="0" />
    <label class="flex! items-start gap-2 cursor-pointer">
        <input type="checkbox" name="is_private" value="1" x-model="isPrivate" class="" />

        <div>
            <p class="font-semibold ">
                {{ __('crud.permissions.actions.private') }}
            </p>
            <x-helper>
                <p>{!! __('crud.fields.is_private_v3', [
        'admin-role' => '<a href=\'' . route('campaigns.campaign_roles.admin', $campaign) . '\' class="text-link">' . $campaign->adminRoleName() . '</a>'
        ]) !!}
                <br /><a href="https://docs.kanka.io/en/latest/features/permissions.html#entity-permissions" class="text-link">
                    <x-icon class="fa-regular fa-book" />
                    {{ __('general.documentation') }}
                </a></p>
            </x-helper>
        </div>
    </label>
</div>
