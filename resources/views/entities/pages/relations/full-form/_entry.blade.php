{{ csrf_field() }}

<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.owner', ['owner' => !empty($relation) ? $relation->owner : null])
    </div>
    <div class="col-md-6">
        @include('cruds.fields.target', ['target' => !empty($relation) ? $relation->target : null])
    </div>
</div>
@include('cruds.fields.relation')

<div class="row">
    <div class="col-sm-4">
        @include('cruds.fields.colour_picker')
    </div>
    <div class="col-sm-8">
        @include('cruds.fields.attitude')
    </div>
</div>

@include('cruds.fields.visibility', ['model' => isset($relation) ? $relation : null])

@if(empty($relation) && (!isset($mirror) || $mirror == true))
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>
                    {!! Form::checkbox('two_way') !!}
                    {{ __('entities/relations.fields.two_way') }}
                    <i class="fa-solid fa-question-circle hidden-xs hidden-sm" title="{{ __('entities/relations.hints.two_way') }}" data-toggle="tooltip"></i>
                </label>
                <p class="help-block visible-xs visible-sm">{{ __('entities/relations.hints.two_way') }}</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group" style="display:none" id="two-way-relation">
                <label>
                    {!! __('entities/relations.fields.target_relation') !!}
                    <i class="fa-solid fa-question-circle hidden-xs hidden-sm" title="{{ __('entities/relations.hints.target_relation') }}" data-toggle="tooltip"></i>
                </label>
                {!! Form::text('target_relation', null, ['class' => 'form-control', 'maxlength' => 191]) !!}
                <p class="help-block visible-xs visible-sm">{{ __('entities/relations.hints.target_relation') }}</p>
            </div>
        </div>
    </div>
@endif

@include('cruds.fields.pinned')

@if (!empty($relation) && !empty($relation->mirrored()))
    <div class="callout callout-info">
        <h4><i class="fa-solid fa-sync-alt"></i> {{ __('entities/relations.hints.mirrored.title') }}</h4>
        <p>{!! __('entities/relations.hints.mirrored.text', [
        'link' => '<a href="' . $relation->target->url() . '" data-toggle="tooltip-ajax" data-id="' . $relation->target_id . '" data-url="' . route('entities.tooltip', $relation->target->id) . "\">" . $relation->target->name . '</a>'
        ]) !!}</p>
    </div>
@endif

@if (!empty($mode))
    <input type="hidden" name="mode" value="{{ $mode }}" />
@endif
