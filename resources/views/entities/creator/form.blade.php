<?php $enableNew = true; ?>

<form method="post" id="entity-creator-form" action="{{ route('entity-creator.store', [$campaign, 'type' => $type]) }}" autocomplete="off" class="entity-creator-form-{{ $type }} w-full">
    @csrf

@if (isset($origin))
    <x-dialog.header>
        <div class="sm:w-80 text-left">{{ __('entities.creator.modes.default') }}</div>
    </x-dialog.header>
    <article>
@endif

<div class="entity-creator-body-{{ $type }} flex flex-col gap-5 w-full">
    @if (!isset($origin))
        @include('entities.creator.header.header')
    @endif
    <div class="quick-creator-body flex flex-col gap-5">

        @includeWhen(!empty($success), 'entities.creator._created')

        <x-forms.field
            field="name"
            :required="true"
            :label="__('crud.fields.name')">
            @if ($mode === 'bulk')
                <textarea name="name"
                          autocomplete="off"
                          class="w-full"
                          id="qq-name-field"
                          rows="4"
                          data-live="{{ route('search.live', $campaign) }}"
                          data-type="{{ $singularType }}"
                          placeholder="{{ __('entities.creator.bulk_names') }}"></textarea>
            @else

                <input type="text" name="name" placeholder="{{ $type === 'posts' ? __('posts.placeholders.name') : __('crud.placeholders.name') }}" autocomplete="off" value="{!! old('name') !!}" maxlength="191" required data-live="{{ route('search.live', $campaign) }}" data-type="{{ $singularType }}" data-bulk="true" id="{{ $type === 'posts' ? 'qq-post-name-field' : 'qq-name-field' }}" data-1p-ignore="true" />
            @endif
            <x-alert type="warning" class=" my-1 duplicate-entity-warning" :hidden="true">
                {{ __('entities.creator.duplicate') }}<br />
                <span class="duplicate-entities"></span>
            </x-alert>
        </x-forms.field>

        <a href="#" class="qq-action-more text-uppercase cursor-pointer text-sm {{ $singularType === 'post' ? 'hidden' : null }}">
            <x-icon class="fa-solid fa-caret-down" />
            {{ __('entities.creator.actions.more') }}
        </a>
        <div class="qq-more-fields flex flex-col gap-5 {{ $singularType !== 'post' ? 'hidden' : null }}">
            @php $allowNew = false; $dropdownParent = '#primary-dialog';@endphp
            @include('entities.creator.forms.' . $singularType)

            @if (!in_array($type, ['posts', 'attribute_templates']))
                <div id="quick-creator-tags-field">
                    @include('cruds.fields.tags', ['dropdownParent' => '#quick-creator-tags-field'])
                </div>
            @endif

            @if ($type !== 'posts' && auth()->user()->isAdmin())
                @include('cruds.fields.privacy_callout')
            @endif
        </div>
    </div>
    @if (empty($origin))
    <div class="quick-creator-footer">

            <div class="join mr-4">
                <button type="submit" class="join-item btn2 btn-primary btn-sm quick-creator-submit" data-entity-type="{{ $singularType }}" title="{{ __('entities.creator.tooltips.create') }}" name="next">
                    <span>
                        {!! __('entities.creator.actions.create', ['type' => $singular ?? $entityType]) !!}
                    </span>
                </button>
                <button type="submit" class="join-item btn2 btn-primary btn-sm quick-creator-submit" name="next" data-entity-type="{{ $singularType }}" value="more" title="{{ __('entities.creator.tooltips.create_more') }}">
                    <span>
                        <x-icon class="fa-solid fa-plus-square" />
                    </span>
                </button>
            </div>

            @if ($mode !== 'bulk')
                <button type="submit" class="btn2 btn-sm quick-creator-submit" data-entity-type="{{ $singularType }}" title="{{ __('entities.creator.tooltips.edit') }}" name="next" value="edit">
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
        <button class="btn2 btn-primary quick-creator-submit" data-entity-type="{{ $singularType }}">
            <span>
                <x-icon class="plus" /> {{ __('entities.creator.actions.create', ['type' => $entityType]) }}
            </span>
        </button>
    </footer>
@endif
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
