@extends('layouts.app', [
    'title' => trans($name . '.index.title', ['name' => CampaignLocalization::getCampaign()->name]),
    'description' => trans($name . '.index.description',  ['name' => CampaignLocalization::getCampaign()->name]),
    'breadcrumbs' => [
        ['url' => route($name . '.index'), 'label' => trans($name . '.index.title')]
    ]
])
@inject('campaign', 'App\Services\CampaignService')


@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-3">
            @can('create', $model)
                <a href="{{ route('conversations.create') }}" class="btn btn-block btn-primary margin-bottom" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('conversations.create') }}">
                    <i class="fa fa-plus"></i> {{ trans('conversations.index.action.add') }}
                </a>
            @endcan
            <div class="box">
                <div class="box-header with-border">
                    <h5>{{ trans('conversations.index.conversations') }}</h5>
                </div>
                <div class="box-body no-padding">
                    <ul class="nav nav-pills nav-stacked">
                        @foreach ($models as $model)
                            <li>
                                <a href="{{ route('conversations.show', $model) }}" data-toggle="conversation">
                                    {{ $model->name }}
                                    <span class="label label-default pull-right" title="{{ trans('conversations.fields.participants') }}">
                                        <i class="fa fa-user"></i> {{ $model->participants->count() }}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9" id="conversation_box">

        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ mix('js/conversation.js') }}" defer></script>
@endsection
