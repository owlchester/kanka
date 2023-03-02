<section class="minimal-padding" id="paid-features">
    <div class="container">
        <div class="my-auto">
            <div class="header-content mx-auto">
                <h2 class="">{{ __('front.features.patreon.title') }}</h2>
                <p class="my-3">{{ __('front.features.patreon.description', ['kanka' => config('app.name')]) }}</p>
            </div>
        </div>

        <div class="">
        <table class="table table-sticky-td">
            <thead>
            <tr>
                <th></th>
                <th>{{ __('front.features.patreon.free') }}</th>
                <th>Owlbear</th>
                <th>Wyvern</th>
                <th>Elemental</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="text">{{ __('front.features.patreon.upload_limit') }}</td>
                <td>1 MB</td>
                <td>8 MB</td>
                <td>15 MB</td>
                <td>25 MB</td>
            </tr>
            <tr>
                <td class="text">{{ __('front.features.patreon.upload_limit_map') }}</td>
                <td>3 MB</td>
                <td>10 MB</td>
                <td>20 MB</td>
                <td>50 MB</td>
            </tr>
            <tr>
                <td class="text">
                    <a href="{{ route('front.boosters') }}">
                    {{ __('front.features.patreon.boosts') }}
                    </a>
                </td>
                <td></td>
                <td>3</td>
                <td>6</td>
                <td>10</td>
            </tr>
            <tr>
                <td class="text">
                    {{ __('front.features.patreon.no_ads') }}
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
                <td>
                    <i class="fa-solid fa-check-circle" aria-hidden="true" aria-label="{{ __('general.yes') }}"></i>
                    <span class="fa-sr-only">{{ __('general.yes') }}</span>
                </td>
            </tr>
            <tr>
                <td class="text">
                    {!! __('front.features.patreon.discord', ['discord' => link_to(config('social.discord'), 'Discord', ['target' => '_blank'])]) !!}
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
                <td>
                    <i class="fa-solid fa-check-circle" aria-hidden="true" aria-label="{{ __('general.yes') }}"></i>
                    <span class="fa-sr-only">{{ __('general.yes') }}</span>
                </td>
            </tr>
            <tr>
                <td class="text">
                    <a href="{{ route('community-votes.index') }}">
                        {{ __('front.features.patreon.monthly_vote') }}
                    </a>
                    <a href="https://docs.kanka.io/en/latest/articles/community-vote.html" target="_blank">
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
                <td>
                    <i class="fa-solid fa-check-circle" aria-hidden="true" aria-label="{{ __('general.yes') }}"></i>
                    <span class="fa-sr-only">{{ __('general.yes') }}</span>
                </td>
            </tr>
            <tr>
                <td class="text">{{ __('front.features.patreon.default_image') }}</td>
                <td></td>
                <td>
                    <i class="fa-solid fa-check-circle" aria-hidden="true" aria-label="{{ __('general.yes') }}"></i>
                    <span class="fa-sr-only">{{ __('general.yes') }}</span>
                </td>
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
                <td class="text">{!! __('front.features.patreon.hall_of_fame', ['link' => link_to_route('front.hall-of-fame', __('front/hall-of-fame.title'))]) !!}</td>
                <td></td>
                <td>
                    <i class="fa-solid fa-check-circle" aria-hidden="true" aria-label="{{ __('general.yes') }}"></i>
                    <span class="fa-sr-only">{{ __('general.yes') }}</span>
                </td>
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
                <td class="text">{{ __('front.features.patreon.api_calls') }}</td>
                <td></td>
                <td>
                    <i class="fa-solid fa-check-circle" aria-hidden="true" aria-label="{{ __('general.yes') }}"></i>
                    <span class="fa-sr-only">{{ __('general.yes') }}</span>
                </td>
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
                    {{ __('front.features.patreon.pagination') }}
                    <i class="fa-solid fa-question-circle" title="{{ __('front.features.patreon.pagination_help') }}" data-toggle="tooltip"></i>
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
                <td>
                    <i class="fa-solid fa-check-circle" aria-hidden="true" aria-label="{{ __('general.yes') }}"></i>
                    <span class="fa-sr-only">{{ __('general.yes') }}</span>
                </td>
            </tr>
            <tr>
                <td class="text">
                    {{ __('front.features.patreon.2fa') }}
                    <a href="https://docs.kanka.io/en/latest/account/security/two-factor-authentication.html" target="_blank">
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
                <td>
                    <i class="fa-solid fa-check-circle" aria-hidden="true" aria-label="{{ __('general.yes') }}"></i>
                    <span class="fa-sr-only">{{ __('general.yes') }}</span>
                </td>
            </tr>
            <tr>
                <td class="text">
                    {{ __('front.features.patreon.bragi') }}
                    <a href="https://docs.kanka.io/en/latest/features/bragi.html" target="_blank">
                        <i class="fa-solid fa-question-circle" title="{{ __('front.features.patreon.click-me') }}" data-toggle="tooltip"></i>
                    </a>
                </td>
                <td></td>
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
                    {{ __('front.features.patreon.curation') }}
                    <a href="https://docs.kanka.io/en/latest/articles/community-vote.html" target="_blank">
                        <i class="fa-solid fa-question-circle" title="{{ __('front.features.patreon.click-me') }}" data-toggle="tooltip"></i>
                    </a>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td>
                    <i class="fa-solid fa-check-circle" aria-hidden="true" aria-label="{{ __('general.yes') }}"></i>
                    <span class="fa-sr-only">{{ __('general.yes') }}</span>
                </td>
            </tr>
            <tr>
                <td class="text">{{ __('front.features.patreon.impact') }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td>
                    <i class="fa-solid fa-check-circle" aria-hidden="true" aria-label="{{ __('general.yes') }}"></i>
                    <span class="fa-sr-only">{{ __('general.yes') }}</span>
                </td>
            </tr>
            </tbody>
        </table>
        </div>
    </div>
</section>

<section class="minimal-padding" id="boost" style="">
    <div class="container">
        <div class="header-content mx-auto">
            <h2>{{ __('front.features.boosts_v2.title') }}</h2>
            <p class="my-3">{{ __('front.features.boosts_v2.description') }} {!! __('front.features.boosts_v2.description-count', [
'boost-count' => '<strong>1</strong>', 'superboost-count' => '<strong>3</strong>',
]) !!} {{ __('front.features.boosts_v2.moving') }}
            </p>
        </div>

        @include('front.features._booster_table')
        @if (isset($campaign))
            <div class="my-2">

                <a href="{{ route('settings.boost', ['campaign' => $campaign->id]) }}" class="btn btn-block btn-success text-uppercase">
                    <i class="fa-solid fa-rocket"></i> {{ __('settings/boosters.actions.boost_name', ['name' => $campaign->name]) }}
                </a>
            </div>
        @endif
        <div class="row ab-testing-a">
            <div class="col-md-6 mx-auto mt-5">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="" data-src="https://www.youtube.com/embed/eSyHGSq4SbE" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>

</section>
