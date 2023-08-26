<?php $enableNew = true; ?>

<form method="post" id="entity-creator-form" action="{{ route('entity-creator.store', [$campaign, 'type' => $type]) }}" autocomplete="off" class="entity-creator-form-{{ $type }}">
    @csrf

<div class="modal-body entity-creator-body-{{ $type }}">
    @include('partials.modals.close')

    @include('entities.creator.header.header')
    <div class="quick-creator-body flex flex-col gap-5">

        @includeWhen(!empty($success), 'entities.creator._created')

        <x-forms.field
            field="name"
            :required="true"
            :label="__('crud.fields.name')">
            @if ($mode === 'bulk')
            {!! Form::textarea('name', null, [
                'placeholder' => __('entities.creator.bulk_names'),
                'autocomplete' => 'off',
                'class' => 'form-control',
                'rows' => 4,
                'data-live' => route('search.live', $campaign),
                'data-type' => $singularType,
                'id' => 'qq-name-field'
            ]) !!}
            @else
                {!! Form::text('name', null, [
                    'placeholder' => $type === 'posts' ? __('posts.placeholders.name') : __('crud.placeholders.name'),
                    'autocomplete' => 'off',
                    'class' => 'form-control',
                    'maxlength' => 191,
                    'data-live' => route('search.live', $campaign),
                    'data-type' => $singularType,
                    'data-bulk' => true,
                    'id' => $type === 'posts' ? 'qq-post-name-field' : 'qq-name-field'
                ]) !!}
            @endif
            <x-alert type="warning" class=" my-1 duplicate-entity-warning" :hidden="true">
                {{ __('entities.creator.duplicate') }}<br />
                <span class="duplicate-entities"></span>
            </x-alert>
        </x-forms.field>

        <a href="#" class="qq-action-more text-uppercase cursor-pointer text-sm" style="{{ $singularType === 'post' ? 'display: none' : null }}">
            <i class="fa-solid fa-caret-down" aria-hidden="true"></i>
            {{ __('entities.creator.actions.more') }}
        </a>
        <div class="qq-more-fields flex flex-col gap-5" style="{{ $singularType !== 'post' ? 'display: none' : null }}">
            @php $allowNew = false; $dropdownParent = '#entity-modal';@endphp
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

            <div class="join mr-4">
                <button type="submit" class="join-item btn2 btn-primary btn-sm quick-creator-submit" data-entity-type="{{ $singularType }}" title="{{ __('entities.creator.tooltips.create') }}">
                    <span>
                        {!! __('entities.creator.actions.create', ['type' => $singular ?? $entityType]) !!}
                    </span>
                    <i class="fa-solid fa-spinner fa-spin" style="display: none"></i>
                </button>
                <button type="submit" class="join-item btn2 btn-primary btn-sm quick-creator-submit" data-entity-type="{{ $singularType }}" data-action="more" title="{{ __('entities.creator.tooltips.create_more') }}">
                    <span>
                        <i class="fa-solid fa-plus-square" aria-hidden="true"></i>
                    </span>
                    <i class="fa-solid fa-spinner fa-spin" style="display: none"></i>
                </button>
            </div>

            @if ($mode !== 'bulk')
                <button type="submit" class="btn2 btn-sm quick-creator-submit" data-entity-type="{{ $singularType }}" data-action="edit" title="{{ __('entities.creator.tooltips.edit') }}">
                    <span>
                        {{ __('crud.edit') }}
                    </span>
                    <i class="fa-solid fa-spinner fa-spin" style="display: none"></i>
                </button>
            @endif

            <a role="button" class="btn2 btn-sm btn-ghost" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}">
                {{ __('crud.cancel') }}
            </a>

        @else
            <div class="text-center">
            <button class="btn2 btn-primary quick-creator-submit" data-entity-type="{{ $singularType }}">
                <span>
                    <x-icon class="plus"></x-icon> {{ __('entities.creator.actions.create', ['type' => $entityType]) }}
                </span>
                <i class="fa-solid fa-spinner fa-spin" style="display: none"></i>
            </button>
            </div>
        @endif
    </div>
    <div class="quick-creator-loading p-8 text-center text-lg" style="display: none">
        <x-icon class="load" />
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
