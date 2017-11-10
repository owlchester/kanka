{{ csrf_field() }}
<div class="row">
    <div class="col-md-6">
        <div class="form-group required">
            <label>{{ trans('campaigns.fields.name') }}</label>
            {!! Form::text('name', null, ['placeholder' => trans('campaigns.placeholders.name'), 'class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-md-6">
        @if (session()->has('campaign_id'))
        <div class="form-group">
            <label>{{ trans('campaigns.fields.image') }}</label>
            {!! Form::hidden('remove-image') !!}
            {!! Form::file('image', array('class' => 'image')) !!}
            @if (!empty($campaign->image))
                <div class="preview">
                    <div class="image">
                        <img src="/storage/{{ $campaign->image }}"/>
                        <a href="#" class="img-delete" data-target="remove-image" title="{{ trans('crud.remove') }}">
                            <i class="fa fa-trash"></i> {{ trans('crud.remove') }}
                        </a>
                    </div>
                    <br class="clear">
                </div>
            @endif
        </div>
        @endif
    </div>
    @if (session()->has('campaign_id'))
    <!--<div class="col-md-6">
        <div class="form-group">
            <label>Locale:</label>
            {!! Form::text('locale', null, ['placeholder' => trans('campaigns.placeholders.locale'), 'class' => 'form-control']) !!}
        </div>
    </div>-->
    @endif
</div>
@if (session()->has('campaign_id'))
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label>{{ trans('campaigns.fields.description') }}</label>
            {!! Form::textarea('description', null, ['class' => 'form-control html-editor', 'id' => 'description']) !!}
        </div>
    </div>
</div>
@endif


<div class="form-group">
    <button class="btn btn-success">{{ trans('crud.save') }}</button>
    @if (session()->has('campaign_id'))
        {!! trans('crud.or_cancel', ['url' => url()->previous()]) !!}
    @endif
</div>
