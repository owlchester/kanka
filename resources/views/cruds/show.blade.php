@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => trans($name . '.show.title', ['name' => $model->name]),
    'description' => trans($name . '.show.description'),
    'breadcrumbs' => [
        ['url' => route($name . '.index'), 'label' => trans($name . '.index.title')],
        $model->name,
    ]
])
@inject('campaign', 'App\Services\CampaignService')

@section('content')
    @include($name . '.show')
@endsection


@section('scripts')
    <script src="{{ mix('js/entity.js') }}" defer></script>
    <script src="{{ mix('js/jquery.fileupload.js') }}" defer></script>
    <script src="{{ mix('js/jquery.iframe-transport.js') }}" defer></script>
    <script src="{{ mix('js/vendor/jquery.ui.widget.js') }}" defer></script>
@endsection
