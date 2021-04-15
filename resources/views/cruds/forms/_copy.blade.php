<p class="help-block">{{ __('crud.helpers.copy_options') }}</p>
<div class="form-group">
    {!! Form::hidden('copy_source_notes', null) !!}
    <label>{!! Form::checkbox('copy_source_notes', 1, request()->filled('template')) !!}
        {{ __('crud.fields.copy_notes') }}
    </label>
</div>
@if ($campaign->campaign()->boosted())
<div class="form-group">
    {!! Form::hidden('copy_source_links', null) !!}
    <label>{!! Form::checkbox('copy_source_links', 1, request()->filled('template')) !!}
        {{ __('crud.fields.copy_links') }}
    </label>
</div>
@endif
<div class="form-group">
    {!! Form::hidden('copy_source_abilities', null) !!}
    <label>{!! Form::checkbox('copy_source_abilities', 1, request()->filled('template')) !!}
        {{ __('crud.fields.copy_abilities') }}
    </label>
</div>
<div class="form-group">
    {!! Form::hidden('copy_source_inventory', null) !!}
    <label>{!! Form::checkbox('copy_source_inventory', 1, request()->filled('template')) !!}
        {{ __('crud.fields.copy_inventory') }}
    </label>
</div>

@if(view()->exists($name . '.form._copy'))
    @include($name . '.form._copy')
@endif
<input type="hidden" name="copy_source_id" value="{{ !empty($source) ? (!empty($source->entity) ? $source->entity->id : $source->id) : old('copy_source_id') }}">
