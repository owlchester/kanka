<?php $enableNew = false; ?>
@inject('campaign', 'App\Services\CampaignService')

<form method="post" id="entity-creator-form" action="{{ route('entity-creator.store', ['type' => $type]) }}" autocomplete="off" class="entity-creator-form-{{ $type }}">

<div class="modal-body entity-creator-body-{{ $type }}">
    <div class="text-center">
        @include('partials.modals.close')
        <h4 class="modal-title" id="myModalLabel">
            {{ __($type . '.create.title') }}
        </h4>
    </div>
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
                    <span class="fa-solid fa-plus"></span>
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

    @includeWhen(auth()->user()->isAdmin(), 'cruds.fields.privacy_callout')


    <div class="row my-5">
        @if (empty($origin))
        <div class="col-md-6 text-right">
            <a href="#" id="entity-creator-back" data-url="{{ route('entity-creator.selection') }}" data-target="#entity-modal" class="btn btn-default rounded-full px-8">
                <i class="fa-solid fa-chevron-left"></i>
                {{ __('entities.creator.back') }}
            </a>
        </div>
        <div class="col-md-6">

            <button class="btn btn-success rounded-full px-8 quick-creator-submit" id="quick-creator-submit-btn" data-text="{{ __('crud.create') }}" data-entity-type="{{ strtolower($entityType) }}">
                <span>
                    <i class="fa-solid fa-plus" aria-hidden="true"></i> {{ __('entities.creator.actions.create', ['type' => $entityType]) }}
                </span>
                <i class="fa-solid fa-spinner fa-spin" style="display: none"></i>
            </button>
        </div>
        @else
            <div class="text-center">
            <button class="btn btn-success rounded-full px-8 quick-creator-submit" id="quick-creator-submit-btn" data-text="{{ __('crud.create') }}" data-entity-type="{{ strtolower($entityType) }}">
                <span>
                    <i class="fa-solid fa-plus" aria-hidden="true"></i> {{ __('entities.creator.actions.create', ['type' => $entityType]) }}
                </span>
                <i class="fa-solid fa-spinner fa-spin" style="display: none"></i>
            </button>
            </div>
        @endif
    </div>
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
                    <span class="fa-solid fa-times"></span>
                </a>
            </div>
        </div>
        <p class="text-yellow duplicate-entity-warning" style="display: none">
            {{ __('entities.creator.duplicate') }}<br />
            <span class="duplicate-entities"></span>
        </p>
    </div>
</div>
