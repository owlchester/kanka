<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\EntityMention $mention */?>
@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => trans('entities/mentions.show.title', ['name' => $entity->name]),
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
                    <p class="help-block">{{ __('entities/mentions.helper') }}</p>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>{{ __('entities/mentions.fields.entity') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($mentions as $mention)
                            <tr>
                                <td>
                                    @if ($mention->isCampaign())
                                        <a href="{{ route('campaigns.show', $mention->campaign_id) }}">
                                            {{ $mention->campaign->name }}
                                        </a>
                                    @elseif ($mention->isEntityNote())
                                        @if ($mention->entityNote)
                                            @viewentity($mention->entityNote->entity)
                                                <a href="{{ $mention->entityNote->entity->url('show', 'notes') }}">
                                                    {{ __('entities/mentions.entity_note', ['name' => $mention->entityNote->entity->name]) }}
                                                </a>
                                            @endif
                                        @else
                                            <i>{{ trans('crud.hidden') }}</i>
                                        @endviewentity
                                    @else
                                        @viewentity($mention->entity)
                                            <a href="{{ $mention->entity->url() }}">{{ $mention->entity->name }}</a>
                                        @else
                                            <i>{{ trans('crud.hidden') }}</i>
                                        @endviewentity
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    @if ($ajax)
                        <div class="pagination-ajax-links">
                            {{ $mentions->links() }}
                        </div>
                    @else
                        {{ $mentions->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection