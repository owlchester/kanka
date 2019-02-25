<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\EntityLog $log */?>
@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => trans('entities/logs.show.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => $entity->url('index'), 'label' => trans($entity->pluralType() . '.index.title')],
        ['url' => $entity->url('show'), 'label' => $entity->name]
    ]
])
@section('content')

    <div class="pagination-ajax-body">
        <div class="panel panel-default">
            @if ($ajax)
            <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4>
                    {{ $entity->name }}
                </h4>
            </div>
            @endif
            <div class="panel-body">
                <div class="loading text-center" style="display: none">
                    <i class="fa fa-spinner fa-spin fa-4x"></i>
                </div>
                <div class="pagination-ajax-content">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>{{ __('entities/logs.fields.action') }}</th>
                            <th>{{ __('campaigns.members.fields.name') }}</th>
                            <th>{{ __('entities/logs.fields.date') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($logs as $log)
                            <tr>
                                <td>
                                    {{ __('entities/logs.actions.' . $log->actionCode()) }}
                                </td>
                                <td>@if ($log->user)
                                        {{ $log->user->name }}
                                    @else
                                        {{  __('crud.history.unknown') }}
                                    @endif
                                </td>
                                <td>
                                    {{ $log->created_at->diffForHumans() }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    @if ($ajax)
                        <div class="pagination-ajax-links">
                            {{ $logs->links() }}
                        </div>
                    @else
                        {{ $logs->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection