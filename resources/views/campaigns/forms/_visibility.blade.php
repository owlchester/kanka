<?php
/**
 * @var \App\Models\Campaign $campaign
 */
use App\Enums\CampaignVisibility;
?>

<x-forms.field
    field="public"
    :label="__('campaigns.fields.public')"
>

    <div class="flex flex-col gap-2">
        <div class="rounded-xl border border-base-300 p-2 flex gap-2 items-start cursor-pointer hover:shadow-sm">
            <input type="radio" name="visibility_id" id="visibility-private" value="{{ CampaignVisibility::private->value }}" class="mt-1" @if (!$campaign || $campaign->isPrivate()) checked="checked" @endif>
            <div class="flex flex-col gap-0 w-full">
                <label for="visibility-private" class="w-full cursor-pointer">
                    {{ __('campaigns/visibilities.titles.private') }}

                    <p class="text-xs text-neutral-content">
                        {{ __('campaigns/visibilities.helpers.private') }}
                    </p>
                </label>
            </div>
        </div>

        <div class="rounded-xl border border-base-300 p-2 flex gap-2 items-start cursor-pointer hover:shadow-sm">
            <input type="radio" name="visibility_id" id="visibility-public" value="{{ CampaignVisibility::public->value }}" class="mt-1" @if ($campaign && $campaign->isPublic()) checked="checked" @endif>
            <div class="flex flex-col gap-0 w-full">
                <label for="visibility-public" class="w-full cursor-pointer">
                    {{ __('campaigns/visibilities.titles.public') }}
                    <p class="text-xs text-neutral-content">
                        {{ __('campaigns/visibilities.helpers.public') }}<br />
                        {{ __('campaigns/visibilities.directory.public') }}
                    </p>
                </label>
            </div>
        </div>

        @if ($campaign && $campaign->premium())
            <div class="rounded-xl border border-base-300 p-2 flex gap-2 items-start cursor-pointer hover:shadow-sm">
                <input type="radio" name="visibility_id" id="visibility-unlisted" value="{{ CampaignVisibility::unlisted->value }}" class="mt-1" @if ($campaign->isUnlisted()) checked="checked" @endif">
                <div class="flex flex-col gap-0 w-full">
                    <label for="visibility-unlisted" class="w-full cursor-pointer">
                        {{ __('campaigns/visibilities.titles.unlisted') }}
                        <p class="text-xs text-neutral-content">
                            {{ __('campaigns/visibilities.helpers.public') }}<br />
                            {{ __('campaigns/visibilities.directory.unlisted') }}
                        </p>
                    </label>
                </div>
            </div>
        @else
            <div class="rounded-xl border border-base-300 p-2 flex gap-2 items-start cursor-not-allowed hover:shadow-sm">
                <input type="radio" name="visibility" id="visibility-unlisted" value="unlisted" class="mt-1" disabled="disabled" />
                <div class="flex flex-col gap-0 w-full">
                    <label for="visibility-unlisted" class="w-full cursor-not-allowed">
                        <x-icon class="premium" /> {{ __('campaigns/visibilities.titles.unlisted') }}
                        <p class="text-xs text-neutral-content">
                            {{ __('campaigns/visibilities.helpers.public') }}<br />
                            {{ __('campaigns/visibilities.directory.unlisted') }}<br />
                        </p>
                        <p>
                            {{ __('campaigns/visibilities.helpers.premium') }}
                        </p>
                    </label>
                </div>
            </div>
        @endif
    </div>

    @if (isset($campaign))
        <x-helper>
            <p>
                <x-icon class="fa-regular fa-circle-info" />
                {!! __('campaigns/public.helpers.permissions', ['public' => '<a href="' . route('campaigns.campaign_roles.public', $campaign). '">' .  __('campaigns.members.roles.public') . '</a>']) !!}
                <a href="https://www.youtube.com/watch?v=VpY_D2PAguM" target="_blank">
                    {{ __('general.tutorial') }} <x-icon class="link" />
                </a>
            </p>
        </x-helper>
    @endif
</x-forms.field>
