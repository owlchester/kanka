<?php $enableNew = false; ?>
@inject('campaignService', 'App\Services\CampaignService')

<form method="post" id="entity-creator-form" action="{{ route('entity-creator.store', ['type' => $type]) }}" autocomplete="off" class="entity-creator-form-{{ $type }}">
    @csrf

<div class="modal-body entity-creator-body-{{ $type }}">
    @include('partials.modals.close')

    @include('entities.creator.header.header')
    <div class="quick-creator-body">

        @includeWhen(!empty($success), 'entities.creator._created')

        <div class="form-group required">
            <label>{{ __('crud.fields.name') }}</label>

            @if ($mode === 'bulk')
            {!! Form::textarea('name', null, [
                'placeholder' => __('entities.creator.bulk_names'),
                'autocomplete' => 'off',
                'class' => 'form-control',
                'rows' => 4,
                'data-live' => route('search.live'),
                'data-type' => $singularType,
                'id' => 'qq-name-field'
            ]) !!}
            @else
                {!! Form::text('name', null, [
                    'placeholder' => __($type . '.placeholders.name'),
                    'autocomplete' => 'off',
                    'class' => 'form-control',
                    'maxlength' => 191,
                    'data-live' => route('search.live'),
                    'data-type' => $singularType,
                    'data-bulk' => true,
                    'id' => 'qq-name-field'
                ]) !!}
            @endif
            <p class=" my-1 alert alert-warning duplicate-entity-warning" style="display: none">
                {{ __('entities.creator.duplicate') }}<br />
                <span class="duplicate-entities"></span>
            </p>
        </div>

        <a href="#" class="qq-action-more text-uppercase pointer text-sm" style="{{ $singularType === 'post' ? 'display: none' : null }}">
            <i class="fa-solid fa-caret-down" aria-hidden="true"></i>
            {{ __('entities.creator.actions.more') }}
        </a>
        <div class="qq-more-fields" style="{{ $singularType !== 'post' ? 'display: none' : null }}">
            @include('entities.creator.forms.' . $singularType)

            @if (!in_array($type, ['tags', 'posts', 'attribute_templates']))
                <div id="quick-creator-tags-field">
                    @include('cruds.fields.tags', ['dropdownParent' => '#quick-creator-tags-field'])
                </div>
            @endif

            @if ($type !== 'posts' && auth()->user()->isAdmin())
                @include('cruds.fields.privacy_callout')
            @endif
        </div>
    </div>
    <div class="quick-creator-footer mt-4">

        @if (empty($origin))

            <div class="btn-group mr-4">
                <button type="submit" class="btn btn-success quick-creator-submit px-5" data-entity-type="{{ $singularType }}">
                    <span>
                        {{ __('entities.creator.actions.create', ['type' => $entityType]) }}
                    </span>
                    <i class="fa-solid fa-spinner fa-spin" style="display: none"></i>
                </button>
                <button type="submit" class="btn btn-success quick-creator-submit" data-entity-type="{{ $singularType }}" data-action="more">
                    <span>
                        <i class="fa-solid fa-plus-square" aria-hidden="true"></i>
                    </span>
                    <i class="fa-solid fa-spinner fa-spin" style="display: none"></i>
                </button>
            </div>

            @if ($mode !== 'bulk')
                <button type="submit" class="btn btn-default quick-creator-submit mr-4 px-5" data-entity-type="{{ $singularType }}" data-action="edit">
                    <span>
                        {{ __('crud.edit') }}
                    </span>
                    <i class="fa-solid fa-spinner fa-spin" style="display: none"></i>
                </button>
            @endif

            <!--<a href="#" id="entity-creator-back" data-url="{{ route('entity-creator.selection') }}" data-target="#entity-modal" class="btn btn-default">
                <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
                {{ __('entities.creator.back') }}
            </a>-->

            <a role="button" class="text-uppercase" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}">
                {{ __('crud.cancel') }}
            </a>

        @else
            <div class="text-center">
            <button class="btn btn-success px-5 quick-creator-submit" data-entity-type="{{ $singularType }}">
                <span>
                    <i class="fa-solid fa-plus" aria-hidden="true"></i> {{ __('entities.creator.actions.create', ['type' => $entityType]) }}
                </span>
                <i class="fa-solid fa-spinner fa-spin" style="display: none"></i>
            </button>
            </div>
        @endif
    </div>
    <div class="quick-creator-loading p-8 text-center" style="display: none">
        <i class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i>
    </div>
</div>

    <input type="hidden" name="entity" value="{{ $type }}" />
@if (!empty($target))
    <input type="hidden" name="_target" value="{{ $target }}" />
@endif
@if (!empty($multi))
    <input type="hidden" name="_multi" value="1" />
@endif
    <input type="hidden" name="action" value="" />
    <input type="hidden" name="quick-creator" value="1" />
</form>
