<div class="tab-pane" id="form-dashboard">
    <p class="help-block">{{ __('campaigns.helpers.dashboard') }}</p>

    <div class="form-group">
        <label>
            {{ __('campaigns.fields.excerpt') }}
            <i class="fa-solid fa-question-circle hidden-xs hidden-sm" title="{{ __('campaigns.helpers.excerpt') }}" data-toggle="tooltip"></i>
        </label>
        {!! Form::textarea('excerptForEdition', null, ['class' => 'form-control html-editor', 'id' => 'excerpt', 'name' => 'excerpt']) !!}
        <p class="help-block visible-xs visible-sm">{{ __('campaigns.helpers.excerpt') }}</p>
    </div>

    <div class="form-group">
        <label for="header_image">
            {{ __('campaigns.fields.header_image') }}
            <i class="fa-solid fa-question-circle hidden-xs hidden-sm" title="{{ __('campaigns.helpers.header_image') }}" data-toggle="tooltip"></i>
        </label>
        <p class="help-block visible-xs visible-sm">{{ __('campaigns.helpers.header_image') }}</p>
        {!! Form::hidden('remove-header_image') !!}
        <div class="row">
            <div class="col-md-10">
                <div class="form-group">
                    {!! Form::file('header_image', ['class' => 'image form-control', 'id' => 'header_image']) !!}
                </div>
                <div class="form-group">
                    {!! Form::text('header_image_url', null, ['placeholder' => __('crud.placeholders.image_url'), 'class' => 'form-control']) !!}
                </div>

                <p class="help-block">
                    {{ __('crud.hints.image_limitations', ['formats' => 'PNG, JPG, GIF, WebP', 'size' => auth()->user()->maxUploadSize(true)]) }}
                    {{ __('crud.hints.image_recommendation', ['width' => '1200', 'height' => '400']) }}
                    @php $currentCampaign = \App\Facades\CampaignLocalization::getCampaign(false); @endphp
                    @subscriber()
                        @if ($currentCampaign && !$currentCampaign->boosted())
                            <p>
                                <a href="{{ route('settings.boost', ['campaign' => $currentCampaign]) }}">
                                    <i class="fa-solid fa-rocket" aria-hidden="true"></i>
                                    {!! __('callouts.subscribe.share-booster', ['campaign' => $currentCampaign->name]) !!}
                                </a>
                            </p>
                        @endif
                    @else
                        <a href="{{ route('front.pricing') }}">{{ __('callouts.subscribe.pitch-image', ['max' => 25]) }}</a>
                    @endif
                </p>
            </div>
            <div class="col-md-2">
                @if (!empty($model->header_image))
                    <div class="preview-v2">
                        <div class="image" style="background-image: url('{{ $model->thumbnail(200, 160, 'header_image') }}')" title="{{ $model->name }}">
                            <a href="#" class="img-delete" data-target="remove-header_image" title="{{ __('crud.remove') }}">
                                <i class="fa-solid fa-trash"></i> {{ __('crud.remove') }}
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
