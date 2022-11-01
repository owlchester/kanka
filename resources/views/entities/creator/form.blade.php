<?php $enableNew = false; ?>
@inject('campaignService', 'App\Services\CampaignService')

<form method="post" id="entity-creator-form" action="{{ route('entity-creator.store', ['type' => $type]) }}" autocomplete="off" class="entity-creator-form-{{ $type }}">
    @csrf

<div class="modal-body entity-creator-body-{{ $type }}">
    @include('partials.modals.close')

    <div class="quick-creator-header">
        <div class="grid grid-cols-2 gap-1">
            <div>
                <div class="qq-mode">
                    @if ($mode === 'bulk')
                        {{ __('Bulk add') }}
                    @else
                        {{ __('Quick add') }}
                    @endif
                </div>
                @if (empty($target))
                <div class="dropdown">
                    <div role="button" class="qq-entity-type dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        {{ __($type . '.create.title') }}
                        <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
                    </div>
                    <ul class="dropdown-menu" role="menu">
                        @foreach ($entityTypes as $module => $name)
                            @includeWhen(isset($entities[$module]), 'entities.creator.header._dropdown', ['dropType' => $module, 'trans' => __('entities.' . $name)])
                        @endforeach

                        <li class="divider"></li>
                        <li>
                            <a href="#" class="" data-toggle="entity-creator" data-url="{{ route('entity-creator.selection') }}" data-entity-type="return">
                                <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
                                {{ __('entities.creator.back') }}
                            </a>
                        </li>
                    </ul>
                </div>
                @else
                <div>
                    <div class="qq-entity-type">
                        {{ __($type . '.create.title') }}
                    </div>
                </div>
                @endif
            </div>
            @if (empty($target))
            <div class="qq-toggles text-right">
                <div class="qq-mode-toggle @if (empty($mode)) active @endif" data-mode="single" data-url="{{ route('entity-creator.form', ['type' => $type]) }}">
                    <i class="fa-regular fa-user" aria-hidden="true"></i>
                </div>
                @if ($type !== 'posts')
                <div class="qq-mode-toggle @if ($mode == 'bulk') active @endif" data-mode="bulk" data-url="{{ route('entity-creator.form', ['type' => $type, 'mode' => 'bulk']) }}">
                    <i class="fa-solid fa-users" aria-hidden="true"></i>
                </div>
                <div class="qq-mode-toggle @if ($mode == 'templates') active @endif" data-mode="templates" data-url="{{ route('entity-creator.form', ['type' => $type, 'mode' => 'templates']) }}">
                    <i class="fa-solid fa-shield" aria-hidden="true"></i>
                </div>
                @endif
            </div>
            @endif
        </div>
    </div>
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

        <a href="#" class="qq-action-more">
            <i class="fa-solid fa-caret-down" aria-hidden="true"></i>
            {{ __('entities.creator.actions.more') }}
        </a>
        <div class="qq-more-fields" style="display: none">
        @include('entities.creator.forms.' . $singularType)

        @if (!in_array($type, ['tags', 'posts']))
            <div id="quick-creator-tags-field">
                @include('cruds.fields.tags', ['dropdownParent' => '#quick-creator-tags-field'])
            </div>
        @endif

        @if ($type !== 'posts' && auth()->user()->isAdmin())
            @include('cruds.fields.privacy_callout')
        @endif
        </div>
    </div>
    <div class="quick-creator-footer">

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

            <a role="button" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}">
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
    <div class="quick-creator-loading" style="display: none">
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
</form>
