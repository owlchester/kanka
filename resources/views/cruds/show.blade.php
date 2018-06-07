@extends('layouts.app', [
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

    <!-- Permissions Modal -->
    <div class="modal fade" id="entity-modal" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content"></div>
        </div>
    </div>
@endsection
