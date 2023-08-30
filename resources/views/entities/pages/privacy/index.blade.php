<?php /** @var \App\Models\Entity $entity
 */?>
@extends('layouts.ajax', [
    'title' => __('entities/permissions.quick.title', ['name' => $entity->name]),
    'breadcrumbs' => false,
    'canonical' => true,
    'mainTitle' => false,
    'miscModel' => $model,
])

@section('content')
    <header>
        <h4 id="privacyDialogTitle">
            {!! __('entities/permissions.quick.title', ['name' => $entity->name]) !!}
        </h4>
        <button type="button" class="rounded-full" onclick="this.closest('dialog').close('close')">
            <i class="fa-solid fa-times" aria-hidden="true"></i>
            <span class="sr-only">{{ __('crud.delete_modal.close') }}</span>
        </button>
    </header>
    <article>
        <div>
            <x-forms.field field="visibility" :label="__('entities/permissions.quick.field')">
                <select name="privacy" id="quick-privacy-select" class="" data-url="{{ route('entities.quick-privacy.toggle', [$campaign, $entity]) }}">
                    <option value="0">{{ __('entities/permissions.quick.options.visible') }}</option>
                    <option value="1" @if ($entity->is_private) selected="selected" @endif>{{ __('entities/permissions.quick.options.private') }}</option>
                </select>
            </x-forms.field>

            <hr />

            <p class="font-extrabold mb-2">
                {{ __('entities/permissions.quick.viewable-by') }}
            </p>
            @if (!empty($visibility['roles']) || !empty($visibility['users']))
            <div class="mb-5 @if ($entity->is_private) line-through text-slate-400 @endif">
                @foreach ($visibility['roles'] as $element)<span class="mr-1"><i class="fa-solid fa-user-group" aria-hidden="true"></i> {!! $element !!}</span>@endforeach
                @if (!empty($visibility['roles']))<br />@endif
                @foreach ($visibility['users'] as $element)<span class="mr-1"><i class="fa-solid fa-user" aria-hidden="true"></i> {!! $element !!}</span>@endforeach
            </div>
            @else
            <p class="help-block">
                {{ __('entities/permissions.quick.empty-permissions') }}
            </p>
            @endif

            <button class="btn2 btn-outline btn-sm btn-block btn-manage-perm" data-target="#entity-permissions-link">
                <i class="fa-solid fa-wrench" aria-hidden="true"></i> {{ __('entities/permissions.quick.manage') }}
            </button>
        </div>
    </article>
@endsection
