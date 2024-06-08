<?php
/**
 * @var \App\Models\Attribute $attribute
 * @var \App\Models\Entity $entity
 */
$isAdmin = auth()->user()->isAdmin();
?>
@extends('layouts.app', [
    'title' => __('entities/attributes.index.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::entity($entity)->list(),
        Breadcrumb::show(),
        __('crud.tabs.attributes'),
    ],
    'mainTitle' => false,
    'centered' => true,
])

@section('content')
    <x-form
        :action="['entities.attributes.save', $campaign, $entity]"
        :extra="['data-max-fields' => ini_get('max_input_vars'),]"
        unload
        class="entity-form"
    >
    <x-box>
        <div id="entity-attributes-all">
            <div class="entity-attributes sortable-elements"  data-handle=".sortable-handler" id="add_attribute_target">
                @foreach ($r = $entity->attributes()->ordered()->get() as $attribute)
                    @if (!$attribute->is_hidden)
                        @include('cruds.forms.attributes._attribute')
                    @endif
                @endforeach
            </div>
        </div>

        @include('cruds.forms.attributes._blocks', ['existing' => $r->count()])
        @include('cruds.forms.attributes._buttons', ['model' => $entity->child, 'existing' => $r->count()])

        <div class="flex gap-2 items-center">
            <a href="{{ url()->previous() }}" class="btn2 btn-ghost">
                {{ __('crud.cancel') }}
            </a>
            <div class="grow text-right">
                <button class="btn2 btn-primary">
                    {{ __('crud.save') }}
                </button>
            </div>
        </div>

    </x-box>
    </x-form>
@endsection
@section('scripts')
    @vite('resources/js/attributes.js')
@endsection
