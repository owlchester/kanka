<div class="">
    <table class="table table-sticky-td">
        <thead>
        <tr>
            <th></th>
            <th>{{ __('front.features.boosts.standard') }}</th>
            <th>{{ __('front.features.boosts.boosted') }}</th>
            <th>{{ __('front.features.superboosts.boosted') }}</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="text">{{ __('front/boosters.perks.entity-count') }}</td>
            <td>
                <i class="fa-solid fa-infinity" aria-hidden="true" aria-label="{{ __('Unlimited') }}"></i>
                <span class="fa-sr-only">{{ __('Unlimited') }}</span>
            </td>
            <td>
                <i class="fa-solid fa-infinity" aria-hidden="true" aria-label="{{ __('Unlimited') }}"></i>
                <span class="fa-sr-only">{{ __('Unlimited') }}</span>
            </td>
            <td>
                <i class="fa-solid fa-infinity" aria-hidden="true" aria-label="{{ __('Unlimited') }}"></i>
                <span class="fa-sr-only">{{ __('Unlimited') }}</span>
            </td>
        </tr>
        <tr>
            <td class="text">{{ __('front/boosters.perks.member-count') }}</td>
            <td>{{ config('limits.campaigns.members') }}</td>
            <td>
                <i class="fa-solid fa-infinity" aria-hidden="true" aria-label="{{ __('Unlimited') }}"></i>
                <span class="fa-sr-only">{{ __('Unlimited') }}</span>
            </td>
            <td>
                <i class="fa-solid fa-infinity" aria-hidden="true" aria-label="{{ __('Unlimited') }}"></i>
                <span class="fa-sr-only">{{ __('Unlimited') }}</span>
            </td>
        </tr>
        <tr>
            <td class="text">{{ __('front/boosters.perks.role-count') }}</td>
            <td>{{ config('limits.campaigns.roles') }}</td>
            <td>
                <i class="fa-solid fa-infinity" aria-hidden="true" aria-label="{{ __('Unlimited') }}"></i>
                <span class="fa-sr-only">{{ __('Unlimited') }}</span>
            </td>
            <td>
                <i class="fa-solid fa-infinity" aria-hidden="true" aria-label="{{ __('Unlimited') }}"></i>
                <span class="fa-sr-only">{{ __('Unlimited') }}</span>
            </td>
        </tr>
        <tr>
            <td class="text">
                {{ __('front/boosters.perks.quick-links') }}
                <a href="https://docs.kanka.io/en/latest/advanced/quick-links.html" target="_blank">
                    <i class="fa-solid fa-question-circle" title="{{ __('front.features.patreon.click-me') }}" data-toggle="tooltip"></i>
                </a>
            </td>
            <td>{{ config('limits.campaigns.quick-links') }}</td>
            <td>
                <i class="fa-solid fa-infinity" aria-hidden="true" aria-label="{{ __('Unlimited') }}"></i>
                <span class="fa-sr-only">{{ __('Unlimited') }}</span>
            </td>
            <td>
                <i class="fa-solid fa-infinity" aria-hidden="true" aria-label="{{ __('Unlimited') }}"></i>
                <span class="fa-sr-only">{{ __('Unlimited') }}</span>
            </td>
        </tr>
        <tr>
            <td class="text">{{ __('front.features.boosts.upload') }}</td>
            <td>1 MB</td>
            <td>8 MB</td>
            <td>8 MB</td>
        </tr>
        <tr>
            <td class="text">
                {{ __('front.features.boosts.no_ads') }}
                <a href="https://docs.kanka.io/en/latest/articles/ads.html" target="_blank">
                    <i class="fa-solid fa-question-circle" title="{{ __('front.features.patreon.click-me') }}" data-toggle="tooltip"></i>
                </a>
            </td>
            <td></td>
            <td>
                <i class="fa-solid fa-check-circle" aria-hidden="true" aria-label="{{ __('general.yes') }}"></i>
                <span class="fa-sr-only">{{ __('general.yes') }}</span>
            </td>
            <td>
                <i class="fa-solid fa-check-circle" aria-hidden="true" aria-label="{{ __('general.yes') }}"></i>
                <span class="fa-sr-only">{{ __('general.yes') }}</span>
            </td>
        </tr>
        <tr>
            <td class="text">{!! __('front.features.boosts.marketplace', ['marketplace' => link_to('https://marketplace.kanka.io', __('front.menu.marketplace'), ['target' => '_blank'])]) !!}</td>
            <td></td>
            <td>
                <i class="fa-solid fa-check-circle" aria-hidden="true" aria-label="{{ __('general.yes') }}"></i>
                <span class="fa-sr-only">{{ __('general.yes') }}</span>
            </td>
            <td>
                <i class="fa-solid fa-check-circle" aria-hidden="true" aria-label="{{ __('general.yes') }}"></i>
                <span class="fa-sr-only">{{ __('general.yes') }}</span>
            </td>
        </tr>
        <tr>
            <td class="text">{{ __('front.features.boosts.theme') }}</td>
            <td></td>
            <td>
                <i class="fa-solid fa-check-circle" aria-hidden="true" aria-label="{{ __('general.yes') }}"></i>
                <span class="fa-sr-only">{{ __('general.yes') }}</span>
            </td>
            <td>
                <i class="fa-solid fa-check-circle" aria-hidden="true" aria-label="{{ __('general.yes') }}"></i>
                <span class="fa-sr-only">{{ __('general.yes') }}</span>
            </td>
        </tr>
        <tr>
            <td class="text">
                {{ __('front.features.boosts.css') }}
                <a href="https://docs.kanka.io/en/latest/features/campaigns/theming.html" target="_blank">
                    <i class="fa-solid fa-question-circle" title="{{ __('front.features.patreon.click-me') }}" data-toggle="tooltip"></i>
                </a>
            </td>
            <td></td>
            <td>
                <i class="fa-solid fa-check-circle" aria-hidden="true" aria-label="{{ __('general.yes') }}"></i>
                <span class="fa-sr-only">{{ __('general.yes') }}</span>
            </td>
            <td>
                <i class="fa-solid fa-check-circle" aria-hidden="true" aria-label="{{ __('general.yes') }}"></i>
                <span class="fa-sr-only">{{ __('general.yes') }}</span>
            </td>
        </tr>
        <tr>
            <td class="text">{{ __('front.features.boosts.tooltip') }}</td>
            <td></td>
            <td>
                <i class="fa-solid fa-check-circle" aria-hidden="true" aria-label="{{ __('general.yes') }}"></i>
                <span class="fa-sr-only">{{ __('general.yes') }}</span>
            </td>
            <td>
                <i class="fa-solid fa-check-circle" aria-hidden="true" aria-label="{{ __('general.yes') }}"></i>
                <span class="fa-sr-only">{{ __('general.yes') }}</span>
            </td>
        </tr>
        <tr>
            <td class="text">{{ __('front.features.boosts.header_image') }}</td>
            <td></td>
            <td>
                <i class="fa-solid fa-check-circle" aria-hidden="true" aria-label="{{ __('general.yes') }}"></i>
                <span class="fa-sr-only">{{ __('general.yes') }}</span>
            </td>
            <td>
                <i class="fa-solid fa-check-circle" aria-hidden="true" aria-label="{{ __('general.yes') }}"></i>
                <span class="fa-sr-only">{{ __('general.yes') }}</span>
            </td>
        </tr>
        <tr>
            <td class="text">
                {!! link_to_route('front.features.dashboards', __('front.features.boosts.dashboards'), [], ['target' => '_blank']) !!}
            </td>
            <td></td>
            <td>
                <i class="fa-solid fa-check-circle" aria-hidden="true" aria-label="{{ __('general.yes') }}"></i>
                <span class="fa-sr-only">{{ __('general.yes') }}</span>
            </td>
            <td>
                <i class="fa-solid fa-check-circle" aria-hidden="true" aria-label="{{ __('general.yes') }}"></i>
                <span class="fa-sr-only">{{ __('general.yes') }}</span>
            </td>
        </tr>
        <tr>
            <td class="text">{{ __('front.features.boosts.images') }}</td>
            <td></td>
            <td>
                <i class="fa-solid fa-check-circle" aria-hidden="true" aria-label="{{ __('general.yes') }}"></i>
                <span class="fa-sr-only">{{ __('general.yes') }}</span>
            </td>
            <td>
                <i class="fa-solid fa-check-circle" aria-hidden="true" aria-label="{{ __('general.yes') }}"></i>
                <span class="fa-sr-only">{{ __('general.yes') }}</span>
            </td>
        </tr>
        <tr>
            <td class="text">{{ __('front.features.boosts.entity_links') }}</td>
            <td></td>
            <td>
                <i class="fa-solid fa-check-circle" aria-hidden="true" aria-label="{{ __('general.yes') }}"></i>
                <span class="fa-sr-only">{{ __('general.yes') }}</span>
            </td>
            <td>
                <i class="fa-solid fa-check-circle" aria-hidden="true" aria-label="{{ __('general.yes') }}"></i>
                <span class="fa-sr-only">{{ __('general.yes') }}</span>
            </td>
        </tr>
        <tr>
            <td class="text">
                {{ __('front.features.boosts.entity-aliases') }}
                <a href="https://docs.kanka.io/en/latest/features/aliases.html" target="_blank">
                    <i class="fa-solid fa-question-circle" title="{{ __('front.features.patreon.click-me') }}" data-toggle="tooltip"></i>
                </a>
            </td>
            <td></td>
            <td>
                <i class="fa-solid fa-check-circle" aria-hidden="true" aria-label="{{ __('general.yes') }}"></i>
                <span class="fa-sr-only">{{ __('general.yes') }}</span>
            </td>
            <td>
                <i class="fa-solid fa-check-circle" aria-hidden="true" aria-label="{{ __('general.yes') }}"></i>
                <span class="fa-sr-only">{{ __('general.yes') }}</span>
            </td>
        </tr>
        <tr>
            <td class="text">{{ __('front.features.boosts.map_markers') }}</td>
            <td></td>
            <td>
                <i class="fa-solid fa-check-circle" aria-hidden="true" aria-label="{{ __('general.yes') }}"></i>
                <span class="fa-sr-only">{{ __('general.yes') }}</span>
            </td>
            <td>
                <i class="fa-solid fa-check-circle" aria-hidden="true" aria-label="{{ __('general.yes') }}"></i>
                <span class="fa-sr-only">{{ __('general.yes') }}</span>
            </td>
        </tr>
        <tr>
            <td class="text">{{ __('front.features.boosts.timeline_elements') }}</td>
            <td></td>
            <td>
                <i class="fa-solid fa-check-circle" aria-hidden="true" aria-label="{{ __('general.yes') }}"></i>
                <span class="fa-sr-only">{{ __('general.yes') }}</span>
            </td>
            <td>
                <i class="fa-solid fa-check-circle" aria-hidden="true" aria-label="{{ __('general.yes') }}"></i>
                <span class="fa-sr-only">{{ __('general.yes') }}</span>
            </td>
        </tr>
        <tr>
            <td class="text">
                {{ __('front.features.boosts.recovery', ['amount' => config('entities.hard_delete')]) }}
                <a href="https://docs.kanka.io/en/latest/features/campaigns/recovery.html" target="_blank">
                    <i class="fa-solid fa-question-circle" title="{{ __('front.features.patreon.click-me') }}" data-toggle="tooltip"></i>
                </a>
            </td>
            <td></td>
            <td>
                <i class="fa-solid fa-check-circle" aria-hidden="true" aria-label="{{ __('general.yes') }}"></i>
                <span class="fa-sr-only">{{ __('general.yes') }}</span>
            </td>
            <td>
                <i class="fa-solid fa-check-circle" aria-hidden="true" aria-label="{{ __('general.yes') }}"></i>
                <span class="fa-sr-only">{{ __('general.yes') }}</span>
            </td>
        </tr>
        <tr>
            <td class="text">
                {!! link_to_route('front.features.relations', __('front.features.boosts.relation-visualiser'), [], ['target' => '_blank']) !!}
            </td>
            <td></td>
            <td>
                <i class="fa-solid fa-check-circle" aria-hidden="true" aria-label="{{ __('general.yes') }}"></i>
                <span class="fa-sr-only">{{ __('general.yes') }}</span>
            </td>
            <td>
                <i class="fa-solid fa-check-circle" aria-hidden="true" aria-label="{{ __('general.yes') }}"></i>
                <span class="fa-sr-only">{{ __('general.yes') }}</span>
            </td>
        </tr>
        <tr class="d-none">
            <td class="text">{{ __('front.features.boosts.beta') }}</td>
            <td></td>
            <td>
                <i class="fa-solid fa-check-circle" aria-hidden="true" aria-label="{{ __('general.yes') }}"></i>
                <span class="fa-sr-only">{{ __('general.yes') }}</span>
            </td>
            <td>
                <i class="fa-solid fa-check-circle" aria-hidden="true" aria-label="{{ __('general.yes') }}"></i>
                <span class="fa-sr-only">{{ __('general.yes') }}</span>
            </td>
        </tr>
        <tr>
            <td class="text">
                {{ __('front.features.boosts.sidebar') }}
                <a href="https://docs.kanka.io/en/latest/features/campaigns/sidebar.html" target="_blank">
                    <i class="fa-solid fa-question-circle" title="{{ __('front.features.patreon.click-me') }}" data-toggle="tooltip"></i>
                </a>
            </td>
            <td></td>
            <td>
                <i class="fa-solid fa-check-circle" aria-hidden="true" aria-label="{{ __('general.yes') }}"></i>
                <span class="fa-sr-only">{{ __('general.yes') }}</span>
            </td>
            <td>
                <i class="fa-solid fa-check-circle" aria-hidden="true" aria-label="{{ __('general.yes') }}"></i>
                <span class="fa-sr-only">{{ __('general.yes') }}</span>
            </td>
        </tr>
        <tr id="superboost">
            <td class="text">
                {{ __('front.features.superboosts.gallery') }}
            </td>
            <td></td>
            <td></td>
            <td>
                <i class="fa-solid fa-check-circle" aria-hidden="true" aria-label="{{ __('general.yes') }}"></i>
                <span class="fa-sr-only">{{ __('general.yes') }}</span>
            </td>
        </tr>
        <tr>
            <td class="text">
                {{ __('front.features.superboosts.logs', ['amount' => config('entities.logs')]) }}
                <a href="https://docs.kanka.io/en/latest/features/history.html" target="_blank">
                    <i class="fa-solid fa-question-circle" title="{{ __('front.features.patreon.click-me') }}" data-toggle="tooltip"></i>
                </a>
            </td>
            <td></td>
            <td></td>
            <td>
                <i class="fa-solid fa-check-circle" aria-hidden="true" aria-label="{{ __('general.yes') }}"></i>
                <span class="fa-sr-only">{{ __('general.yes') }}</span>
            </td>
        </tr>
        <tr>
            <td class="text">
                {{ __('front.features.superboosts.stats') }}
                <a href="https://docs.kanka.io/en/latest/features/campaigns/achievements.html" target="_blank">
                    <i class="fa-solid fa-question-circle" title="{{ __('front.features.patreon.click-me') }}" data-toggle="tooltip"></i>
                </a>
            </td>
            <td></td>
            <td></td>
            <td>
                <i class="fa-solid fa-check-circle" aria-hidden="true" aria-label="{{ __('general.yes') }}"></i>
                <span class="fa-sr-only">{{ __('general.yes') }}</span>
            </td>
        </tr>
        <tr>
            <td class="text">{{ __('front.features.boosts.entity_files_v2') }}</td>
            <td>3</td>
            <td>5</td>
            <td>10</td>
        </tr>
        </tbody>
    </table>
</div>
