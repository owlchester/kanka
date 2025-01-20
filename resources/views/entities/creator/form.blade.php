<?php $enableNew = true; ?>
@if (isset($entityType))
<form method="post" id="entity-creator-form" action="{{ route('entity-creator.store', [$campaign, 'entity_type' => $entityType]) }}" autocomplete="off" class="entity-creator-form-{{ $entityType->code }} w-full">
@else
        <form method="post" id="entity-creator-form" action="{{ route('entity-creator.post', [$campaign]) }}" autocomplete="off" class="entity-creator-form-post w-full">
@endif
    @csrf

@if (isset($origin))
    <x-dialog.header>
        <div class="sm:w-80 text-left">{{ __('entities.creator.modes.default') }}</div>
    </x-dialog.header>
    <article>
@endif

<div class="entity-creator-body-{{ $entityType->code ?? 'post' }} flex flex-col gap-5 w-full">
    @if (!isset($origin))
        @include('entities.creator.header.header')
    @endif
    <div class="quick-creator-body flex flex-col gap-5">

        @includeWhen(!empty($success), 'entities.creator._created')
        <?php
        $fieldID = $mode === 'bulk' ? 'qq-name-field' : (!isset($entityType) ? 'qq-post-name-field' : 'qq-name-field');
        ?>
        <x-forms.field
            field="name"
            required
            :label="__('crud.fields.name')"
            :id="$fieldID">
            @if ($mode === 'bulk')
                <textarea name="name"
                          autocomplete="off"
                          class="w-full"
                          id="qq-name-field"
                          rows="4"
                          @if (isset($entityType))
                          data-live="{{ route('search-list', [$campaign, $entityType]) }}"
                          @endif
                          placeholder="{{ __('entities.creator.bulk_names') }}"></textarea>
            @else

                <input type="text" name="name" placeholder="{{ !isset($entityType) ? __('posts.placeholders.name') : __('crud.placeholders.name') }}" autocomplete="off" value="{!! old('name') !!}" maxlength="191" required
                       @if (isset($entityType))
                           data-live="{{ route('search-list', [$campaign, $entityType]) }}"
                       @endif data-bulk="true" id="{{ !isset($entityType) ? 'qq-post-name-field' : 'qq-name-field' }}" data-1p-ignore="true" />
            @endif
            <x-alert type="warning" class=" my-1 duplicate-entity-warning" :hidden="true">
                {{ __('entities.creator.duplicate') }}<br />
                <span class="duplicate-entities"></span>
            </x-alert>
        </x-forms.field>

        <a href="#" class="qq-action-more text-uppercase cursor-pointer text-sm {{ !isset($entityType) ? 'hidden' : null }}">
            <x-icon class="fa-solid fa-caret-down" />
            {{ __('entities.creator.actions.more') }}
        </a>
        <div class="qq-more-fields flex flex-col gap-5 {{ isset($entityType) ? 'hidden' : null }}">
            @php $allowNew = false; $dropdownParent = '#primary-dialog';@endphp
            @if (isset($entityType))
                @if ($entityType->isSpecial())
                    @include('entities.creator.forms.custom')
                @else
                    @include('entities.creator.forms.' . $entityType->code)
                @endif
            @else
                @include('entities.creator.forms.post')
            @endif

            @if (!isset($entityType) || !in_array($entityType->id, [config('entities.ids.attribute_template')]))
                <div id="quick-creator-tags-field">
                    @include('cruds.fields.tags', ['dropdownParent' => '#quick-creator-tags-field'])
                </div>
            @endif

            @if (isset($entityType) && auth()->user()->isAdmin())
                @include('cruds.fields.privacy_callout')
            @endif
        </div>
    </div>
    @if (empty($origin))
    <div class="quick-creator-footer">

            <div class="join mr-4">
                <button type="submit" class="join-item btn2 btn-primary btn-sm quick-creator-submit" data-entity-type="{{ $entityType->code ?? 'post'}}" title="{{ __('entities.creator.tooltips.create') }}" name="next">
                    <span>
                        {!! __('entities.creator.actions.create', ['type' => isset($entityType) ? $entityType->name() : $singular]) !!}
                    </span>
                </button>
                <button type="submit" class="join-item btn2 btn-primary btn-sm quick-creator-submit" name="next" data-entity-type="{{ $entityType->code ?? 'post' }}" value="more" title="{{ __('entities.creator.tooltips.create_more') }}">
                    <span>
                        <x-icon class="fa-solid fa-plus-square" />
                    </span>
                </button>
            </div>

            @if ($mode !== 'bulk')
                <button type="submit" class="btn2 btn-sm quick-creator-submit" data-entity-type="{{ $entityType->code ?? 'post' }}" title="{{ __('entities.creator.tooltips.edit') }}" name="next" value="edit">
                    <span>
                        {{ __('crud.edit') }}
                    </span>
                </button>
            @endif

            <a role="button" class="btn2 btn-sm btn-ghost" onclick="this.closest('dialog').close('close')" aria-label="{{ __('crud.delete_modal.close') }}">
                {{ __('crud.cancel') }}
            </a>
    </div>
    @endif
    <div class="quick-creator-loading p-8 text-center text-lg hidden">
        <x-icon class="load" />
    </div>
</div>

@if (isset($origin))
    </article>
    <footer class="bg-base-200 flex flex-wrap gap-3 justify-center items-center p-3">
        <button class="btn2 btn-primary quick-creator-submit" data-entity-type="{{ $entityType->code }}">
            <span>
                <x-icon class="plus" /> {{ __('entities.creator.actions.create', ['type' => $entityType->name()]) }}
            </span>
        </button>
    </footer>
@endif
@if (!empty($target))
    <input type="hidden" name="_target" value="{{ $target }}" />
@endif
@if (!empty($multi))
    <input type="hidden" name="_multi" value="1" />
@endif
    <input type="hidden" name="action" value="" />
    <input type="hidden" name="quick-creator" value="1" />
</form>
