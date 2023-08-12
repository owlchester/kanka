<?php /** @var \App\Models\Campaign[] $campaigns */ ?>

<section id="featured" class="team-featured-campaigns">
    <div class="container">
        <div class="section-heading text-center">
            <h2>{{ __('front.featured_campaigns.title') }}</h2>
            <p class="">{{ __('front.featured_campaigns.description') }}</p>
        </div>
        <div class="mt-5 featured-campaigns">
            <div class="row">
            @foreach ($campaigns as $campaign)
                <div class="col-lg-6 col-12">
                    <div class="campaign-container campaign-boosted">
                        <a class="campaign featured-campaign" href="{{ route('dashboard', $campaign) }}" title="{!! $campaign->name !!}">
                            <div class="campaign-image campaign-placeholder"  @if ($campaign->image) style="background-image: url('{{ $campaign->thumbnail(900, 200) }}')" @endif>

                            </div>
                            <div class="bottom">
                                <h3 class="campaign-title">
                                    {!! $campaign->name !!}
                                </h3>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
        <div class="mt-3 text-center">
            {!! __('front.featured_campaigns.more', ['public-campaigns' => link_to_route('front.public_campaigns', __('front.menu.campaigns'))]) !!}
        </div>
    </div>
</section>
