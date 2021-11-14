<div class="form-group">
    <label>
        {{ __('fields.tooltip.name') }}
        <i class="fas fa-rocket" title="{{ __('crud.tooltips.boosted_feature') }}" data-toggle="tooltip"></i>
    </label>

    @if($campaign->campaign()->boosted())
    <p class="help-block">
        {{ __('fields.tooltip.description') }}
    </p>

        {!! Form::textarea('entity_tooltip', FormCopy::entity()->field('tooltip')->string(), ['class' => 'form-control', 'id' => 'tooltip', 'rows' => 3, 'placeholder' => __('fields.tooltip.description')]) !!}
    @else
        @include('cruds.fields.helpers.boosted', ['key' => 'fields.tooltip.boosted-description'])
    @endif

</div>


<div class="form-group">
    <label>
        {{ __('fields.header-image.title') }}
        <i class="fas fa-rocket" title="{{ __('crud.tooltips.boosted_feature') }}" data-toggle="tooltip"></i>

    </label>

    @if($campaign->campaign()->boosted())
        <div class="row">
            <div class="col-lg-6">
            <p class="help-block">{{ __('fields.header-image.description') }}</p>

            {!! Form::hidden('remove-header_image') !!}

            <div class="row">
                <div class="col-md-10">
                    <div class="form-group">
                        {!! Form::file('header_image', array('class' => 'image form-control')) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::text('header_image_url', null, ['placeholder' => __('crud.placeholders.image_url'), 'class' => 'form-control']) !!}

                        <p class="help-block">
                            {{ __('crud.hints.image_limitations', ['formats' => 'PNG, JPG, GIF, WebP', 'size' => auth()->user()->maxUploadSize(true)]) }}
                            @if (!auth()->user()->hasRole('patreon'))
                                <a href="{{ route('settings.patreon') }}">{{ __('crud.hints.image_patreon') }}</a>
                            @endif
                        </p>
                    </div>

                </div>
                <div class="col-md-2">
                    @if (!empty($model->entity) && !empty($model->entity->header_image))
                        <div class="preview-v2">
                            <div class="image" style="background-image: url('{{ $model->entity->getImageUrl(80, null) }}')" title="{{ $model->name }}">
                                <a href="#" class="img-delete" data-target="remove-header_image" title="{{ __('crud.remove') }}">
                                    <i class="fa fa-trash"></i> {{ __('crud.remove') }}
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            </div>
            <div class="col-lg-6">
                @include('cruds.fields.entity_header')
            </div>
        </div>
    @else
        @include('cruds.fields.helpers.boosted', ['key' => 'fields.header-image.boosted-description'])
    @endif
</div>

@include('cruds.fields.entity_image')

