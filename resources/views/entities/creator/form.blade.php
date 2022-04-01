<?php $enableNew = false; ?>
@inject('campaign', 'App\Services\CampaignService')

<form method="post" id="entity-creator-form" action="{{ route('entity-creator.store', ['type' => $type]) }}" autocomplete="off" class="entity-creator-form-{{ $type }}">

<div class="modal-header entity-creator-heading-{{ $type }}">
    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">
        {{ __($type . '.create.title') }}
    </h4>
</div>
<div class="modal-body entity-creator-body-{{ $type }}">
    <div class="form-group required">
        <label>{{ __($type . '.fields.name') }}</label>

        <div class="input-group">
            {!! Form::text('names[]', null, [
                'placeholder' => __($type . '.placeholders.name'),
                'autocomplete' => 'off',
                'class' => 'form-control',
                'maxlength' => 191,
                'data-live' => route('search.live'),
                'data-type' => $singularType
            ]) !!}
            <div class="input-group-btn">
                <a class="btn btn-extra-name" style="" data-toggle="tooltip" title="{{ __('entities.creator.name.new') }}">
                    <span class="fas fa-plus"></span>
                </a>
            </div>
        </div>
        <p class="text-yellow duplicate-entity-warning" style="display: none">
            {{ __('entities.creator.duplicate') }}<br />
            <span class="duplicate-entities"></span>
        </p>
    </div>
    <div class="extra-name-fields"></div>

    @include('entities.creator.forms.' . $singularType)

    @if ($type !== 'tags')
        <div id="quick-creator-tags-field">
    @include('cruds.fields.tags', ['dropdownParent' => '#quick-creator-tags-field'])
        </div>
    @endif

    @include('cruds.fields.private2')
</div>
<div class="modal-footer">
    @if (empty($origin))
    <a href="#" id="entity-creator-back" data-url="{{ route('entity-creator.selection') }}" data-target="#entity-modal" class="btn btn-default pull-left">
        <i class="fa fa-chevron-left"></i>
        {{ __('entities.creator.back') }}
    </a>
    @endif

    <button class="btn btn-success" id="quick-creator-submit-btn" data-text="{{ __('crud.create') }}">
        {{ __('crud.create') }}
    </button>

</div>

    <input type="hidden" name="entity" value="{{ $type }}" />
@if (!empty($target))
    <input type="hidden" name="_target" value="{{ $target }}" />
@endif
</form>

<div class="hidden">
    <div class="name-block-template form-group">

        <div class="input-group">
            {!! Form::text('names[]', null, [
                'placeholder' => __($type . '.placeholders.name'),
                'autocomplete' => 'off',
                'class' => 'form-control',
                'maxlength' => 191,
                'data-live' => route('search.live'),
                'data-type' => $singularType
            ]) !!}
            <div class="input-group-btn">
                <a class="btn btn-extra-name-remove" style="" data-toggle="toggle-tooltip" title="{{ __('entities.creator.name.remove') }}">
                    <span class="fas fa-times"></span>
                </a>
            </div>
        </div>
        <p class="text-yellow duplicate-entity-warning" style="display: none">
            {{ __('entities.creator.duplicate') }}<br />
            <span class="duplicate-entities"></span>
        </p>
    </div>
</div>
