@extends('layouts.app', [
    'title' => __('crud.titles.editing', ['name' => $model->name]),
    'breadcrumbs' => [
        ['url' => route('overview', $campaign), 'label' => __('entities.campaign')],
        __('crud.edit')
    ],
    'canonical' => true,
    'sidebar' => 'campaign',
    'centered' => true,
])


@section('content')
    @include('partials.errors')

    <x-form
        method="PATCH"
        :action="['campaigns.update', $campaign]"
        files
        unload
        class="entity-form"
    >
        @include('campaigns.forms.standard')

        @if(!empty($model) && $campaign->hasEditingWarning())
            <input type="hidden" id="editing-keep-alive" data-url="{{ route('campaigns.keep-alive', $campaign) }}" />
        @endif
    </x-form>
@endsection


@include('editors.editor')

@section('modals')
    @parent
    @includeWhen(!empty($editingUsers) && !empty($model), 'cruds.forms.edit_warning', ['model' => $model])
@endsection
