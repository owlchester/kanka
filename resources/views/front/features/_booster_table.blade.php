<div class="table-responsive">
    <table class="table">
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
            <td>{{ config('kanka.campaigns.entity_limit') }}</td>
            <td><i class="fa-solid fa-infinity"></i></td>
            <td><i class="fa-solid fa-infinity"></i></td>
        </tr>
        <tr>
            <td class="text">{{ __('front/boosters.perks.member-count') }}</td>
            <td>{{ config('kanka.campaigns.member_limit') }}</td>
            <td><i class="fa-solid fa-infinity"></i></td>
            <td><i class="fa-solid fa-infinity"></i></td>
        </tr>
        <tr>
            <td class="text">{{ __('front/boosters.perks.role-count') }}</td>
            <td>{{ config('kanka.campaigns.role_limit') }}</td>
            <td><i class="fa-solid fa-infinity"></i></td>
            <td><i class="fa-solid fa-infinity"></i></td>
        </tr>
        <tr>
            <td class="text">{{ __('front/boosters.perks.quick-links') }}</td>
            <td>{{ config('kanka.campaigns.quick_link_limit') }}</td>
            <td><i class="fa-solid fa-infinity"></i></td>
            <td><i class="fa-solid fa-infinity"></i></td>
        </tr>
        <tr>
            <td class="text">{{ __('front.features.boosts.upload') }}</td>
            <td>1 MB</td>
            <td>8 MB</td>
            <td>8 MB</td>
        </tr>
        <tr>
            <td class="text">{{ __('front.features.boosts.no_ads') }}</td>
            <td></td>
            <td><i class="fa-solid fa-check-circle"></i></td>
            <td><i class="fa-solid fa-check-circle"></i></td>
        </tr>
        <tr>
            <td class="text">{!! __('front.features.boosts.marketplace', ['marketplace' => link_to('https://marketplace.kanka.io', __('front.menu.marketplace'), ['target' => '_blank'])]) !!}</td>
            <td></td>
            <td><i class="fa-solid fa-check-circle"></i></td>
            <td><i class="fa-solid fa-check-circle"></i></td>
        </tr>
        <tr>
            <td class="text">{{ __('front.features.boosts.theme') }}</td>
            <td></td>
            <td><i class="fa-solid fa-check-circle"></i></td>
            <td><i class="fa-solid fa-check-circle"></i></td>
        </tr>
        <tr>
            <td class="text">
                {!! link_to('https://kanka.io/' . app()->getLocale() . '/campaign/20000/notes/151346#entity-note-body-149581', __('front.features.boosts.css'), ['target' => '_blank']) !!}
            </td>
            <td></td>
            <td><i class="fa-solid fa-check-circle"></i></td>
            <td><i class="fa-solid fa-check-circle"></i></td>
        </tr>
        <tr>
            <td class="text">{{ __('front.features.boosts.tooltip') }}</td>
            <td></td>
            <td><i class="fa-solid fa-check-circle"></i></td>
            <td><i class="fa-solid fa-check-circle"></i></td>
        </tr>
        <tr>
            <td class="text">{{ __('front.features.boosts.header_image') }}</td>
            <td></td>
            <td><i class="fa-solid fa-check-circle"></i></td>
            <td><i class="fa-solid fa-check-circle"></i></td>
        </tr>
        <tr>
            <td class="text">
                {!! link_to_route('front.features.dashboards', __('front.features.boosts.dashboards'), [], ['target' => '_blank']) !!}
            </td>
            <td></td>
            <td><i class="fa-solid fa-check-circle"></i></td>
            <td><i class="fa-solid fa-check-circle"></i></td>
        </tr>
        <tr>
            <td class="text">{{ __('front.features.boosts.images') }}</td>
            <td></td>
            <td><i class="fa-solid fa-check-circle"></i></td>
            <td><i class="fa-solid fa-check-circle"></i></td>
        </tr>
        <tr>
            <td class="text">{{ __('front.features.boosts.entity_links') }}</td>
            <td></td>
            <td><i class="fa-solid fa-check-circle"></i></td>
            <td><i class="fa-solid fa-check-circle"></i></td>
        </tr>
        <tr>
            <td class="text">{{ __('front.features.boosts.entity-aliases') }}</td>
            <td></td>
            <td><i class="fa-solid fa-check-circle"></i></td>
            <td><i class="fa-solid fa-check-circle"></i></td>
        </tr>
        <tr>
            <td class="text">{{ __('front.features.boosts.map_markers') }}</td>
            <td></td>
            <td><i class="fa-solid fa-check-circle"></i></td>
            <td><i class="fa-solid fa-check-circle"></i></td>
        </tr>
        <tr>
            <td class="text">{{ __('front.features.boosts.timeline_elements') }}</td>
            <td></td>
            <td><i class="fa-solid fa-check-circle"></i></td>
            <td><i class="fa-solid fa-check-circle"></i></td>
        </tr>
        <tr>
            <td class="text">{{ __('front.features.boosts.recovery', ['amount' => config('entities.hard_delete')]) }}</td>
            <td></td>
            <td><i class="fa-solid fa-check-circle"></i></td>
            <td><i class="fa-solid fa-check-circle"></i></td>
        </tr>
        <tr>
            <td class="text">
                {!! link_to_route('front.features.relations', __('front.features.boosts.relation-visualiser'), ['target' => '_blank']) !!}
            </td>
            <td></td>
            <td><i class="fa-solid fa-check-circle"></i></td>
            <td><i class="fa-solid fa-check-circle"></i></td>
        </tr>
        <tr class="d-none">
            <td class="text">{{ __('front.features.boosts.beta') }}</td>
            <td></td>
            <td><i class="fa-solid fa-check-circle"></i></td>
            <td><i class="fa-solid fa-check-circle"></i></td>
        </tr>
        <tr>
            <td class="text">
                {!! link_to('https://kanka.io/' . app()->getLocale() . '/campaign/20000/notes/156620', __('front.features.boosts.sidebar'), ['target' => '_blank']) !!}
            </td>
            <td></td>
            <td><i class="fa-solid fa-check-circle"></i></td>
            <td><i class="fa-solid fa-check-circle"></i></td>
        </tr>
        <tr id="superboost">
            <td class="text">{{ __('front.features.superboosts.gallery') }}</td>
            <td></td>
            <td></td>
            <td><i class="fa-solid fa-check-circle"></i></td>
        </tr>
        <tr>
            <td class="text">{{ __('front.features.superboosts.logs', ['amount' => config('entities.logs')]) }}</td>
            <td></td>
            <td></td>
            <td><i class="fa-solid fa-check-circle"></i></td>
        </tr>
        <tr>
            <td class="text">{{ __('front.features.superboosts.stats') }}</td>
            <td></td>
            <td></td>
            <td><i class="fa-solid fa-check-circle"></i></td>
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
