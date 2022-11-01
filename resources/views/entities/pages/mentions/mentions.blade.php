<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\EntityMention $mention */?>
@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => trans('entities/mentions.show.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => $entity->url('index'), 'label' => __('entities.' . $entity->pluralType())],
        ['url' => $entity->url('show'), 'label' => $entity->name]
    ]
])
@section('content')
    @if (!$ajax) <div class="box box-default">@endif
    <div class="pagination-ajax-body">
        @if ($ajax)
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">
                {{ $entity->name }}
            </h4>
        </div>
        @endif
        <div class="modal-body">
            <div class="loading text-center" style="display: none">
                <i class="fa-solid fa-spinner fa-spin fa-4x"></i>
            </div>
            <div class="pagination-ajax-content">
                <p class="help-block">
                    {{ __('entities/mentions.helper') }}
                </p>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>{{ __('entities/mentions.fields.element') }}</th>
                        <th>{{ __('entities/mentions.fields.type') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($mentions as $mention)
                        @if ($mention->isCampaign())
                            <tr>
                                <td>
                                    <a href="{{ route('campaigns.show', $mention->campaign_id) }}">
                                        {{ $mention->campaign->name }}
                                    </a>
                                </td>
                                <td>
                                    {{ __('entities.campaign') }}
                                </td>
                            </tr>
                        @elseif ($mention->isEntityNote() && $mention->entityNote)
                            @if($mention->entityNote->entity)
                            <tr>
                                <td>
                                    <a href="{{ $mention->entityNote->entity->url('show', ['#post-' . $mention->entityNote->id]) }}">
                                        {{ $mention->entityNote->entity->name }}
                                    </a>
                                </td>
                                <td>
                                    {{ __('entities.post') }}
                                </td>
                            </tr>
                            @endif
                        @elseif ($mention->entity)
                            <tr>
                                <td>
                                    <a href="{{ $mention->entity->url() }}">{{ $mention->entity->name }}</a>
                                </td>
                                <td>
                                    {{ __('entities.' . $mention->entity->type()) }}
                                </td>
                            </tr>
                        @endif
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
    @if (!$ajax) </div>@endif
@endsection
