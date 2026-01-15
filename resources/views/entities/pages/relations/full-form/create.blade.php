@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __($langKey . '.create.new_title'),
    'breadcrumbs' => [
        ['url' => Breadcrumb::campaign($campaign)->index($name), 'label' => __('entities.relations')],
        __('crud.create'),
    ],
    'centered' => true,
])


@section('content')

    @include('cruds.forms._errors')
    <x-form files :action="['relations.store', $campaign]" class="entity-form" id="entity-form" unload>
        <div class="nav-tabs-custom bg-base-100 p-4 rounded-xl flex flex-col gap-6">
            <div class="flex gap-2 items-center justify-between ">
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

