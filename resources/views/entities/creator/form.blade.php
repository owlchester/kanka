<?php $enableNew = false; ?>
@inject('formService', 'App\Services\FormService')
@inject('campaign', 'App\Services\CampaignService')

<div class="panel-heading">
    <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
    <h4>{{ trans($type . '.create.title') }}</h4>
</div>
<div class="panel-body">
    <form method="post" id="entity-creator-form" action="{{ route('entity-creator.store', ['type' => $type]) }}" autocomplete="off">
        <div class="form-group required">
            <label>{{ __($type . '.fields.name') }}</label>
            {!! Form::text('name', old('name'), [
                'placeholder' => __($type . '.placeholders.name'),
                'autocomplete' => 'off',
                'class' => 'form-control',
                'maxlength' => 191,
                'data-live' => route('search.live'),
                'data-type' => $singularType
            ]) !!}
            <p class="text-yellow duplicate-entity-warning" style="display: none">{{ __('entities.creator.duplicate') }}</p>
        </div>

        @include('entities.creator.forms.' . $singularType)

        @include('cruds.fields.tags')

        @include('cruds.fields.private')

        <p class="alert alert-danger entity-creator-error" style="display: none">{{ __('entities.creator.error') }}</p>
        <button class="btn btn-success" id="form-submit-main">{{ trans('crud.save') }}</button>

        <input type="hidden" name="entity" value="{{ $type }}" />
    </form>

    <p class="alert alert-success entity-creator-success" style="display: none"></p>
</div>