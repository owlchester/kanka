<?php /** @var \App\Models\MiscModel $model */

// If the user activated nested views by default, go back to it.
$entityIndexRoute = route($name . '.index');
if (auth()->check() && auth()->user()->defaultNested) {
    if (\Illuminate\Support\Facades\Route::has($name . '.tree')) {
        $entityIndexRoute = route($name . '.tree');
    }
}
?>
@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => trans($name . '.show.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => $entityIndexRoute, 'label' => trans($name . '.index.title')],
        $model->name,
    ]
])
@inject('campaign', 'App\Services\CampaignService')

@section('og')
    <meta property="og:description" content="{{ $model->tooltip() ?: trans($name . '.show.title', ['name' => $model->name]) }}" />
    @if ($model->image)<meta property="og:image" content="{{ Storage::url($model->image)  }}" />@endif

    <meta property="og:url" content="{{ $model->getLink()  }}" />
@endsection

@section('content')
    @include($name . '.show')

    @if ($model->entity)
    @admin
    <div class="panel panel-default hidden">
        <div class="panel-heading">
            <h4>Admin</h4>
        </div>
        <div class="panel-body">
            <dl class="dl-horizontal">
                <dt>Entity ID</dt>
                <dd>{{ $model->entity->id }}</dd>
                <dt>Entity Type</dt>
                <dd>{{ $model->entity->type }}</dd>
            </dl>
        </div>
    </div>
    @endadmin
    @endif
@endsection


@section('scripts')
    <script src="{{ mix('js/entity.js') }}" defer></script>
    <script src="{{ mix('js/jquery.fileupload.js') }}" defer></script>
    <script src="{{ mix('js/jquery.iframe-transport.js') }}" defer></script>
    <script src="{{ mix('js/vendor/jquery.ui.widget.js') }}" defer></script>
@endsection
