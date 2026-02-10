<?php /** @var \App\Models\Relation $relation */?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __($langKey . '.update.title', [
        'source' => '<a href="' . $relation->owner->url() . '" class="text-link">' . $relation->owner->name . '</a>',
        'target' => '<a href="' . $relation->target->url() . '" class="text-link">' . $relation->target->name . '</a>',
        ]),
    'breadcrumbs' => [
        ['url' => Breadcrumb::campaign($campaign)->index($name), 'label' => __('entities.relations')],
        __('crud.update'),
    ],
    'centered' => true,
])

@section('content')
    @include('cruds.forms._errors')
    <x-form files method="PATCH" :action="['relations.update', $campaign, $relation]" class="entity-form" id="entity-form">
        <div class="nav-tabs-custom bg-base-100 p-4 rounded-xl flex flex-col gap-6 relative">
            <div class="flex gap-2 items-center justify-between sticky z-10 bg-base-100 top-12">
                <div class="overflow-x-auto">
                    <ul class="nav-tabs flex items-stretch w-full" role="tablist">
                        <x-tab.tab target="entry" :default="true" :title="__('crud.fields.entry')"></x-tab.tab>
                    </ul>
                </div>
                @include('cruds.fields.save', ['disableCancel' => true, 'target' => 'entity-form'])
            </div>
            <div class="tab-content">
                <div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }}" id="form-entry">
                    @include('entities.pages.relations.full-form._entry', ['source' => $source])
                </div>
            </div>
        </div>
    </x-form>
@endsection

@include('editors.editor')


