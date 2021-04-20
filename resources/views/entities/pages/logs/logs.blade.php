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
                    <table class="table table-hover" style="word-break: break-all;">
                        <thead>
                        <tr>
                            <th>{{ __('entities/logs.fields.action') }}</th>
                            <th>{{ __('campaigns.members.fields.name') }}</th>
                            <th>{{ __('entities/logs.fields.date') }}</th>
                            @if ($campaign->boosted(true))<th></th>@endif
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

                                    @if ($log->impersonator)
                                        ({{ __('entities/logs.impersonated', ['name' => $log->impersonator->name]) }})
                                    @endif
                                </td>
                                <td>
                                    {{ $log->created_at->diffForHumans() }}
                                </td>
                                @if ($campaign->boosted(true))
                                    <td>
                                        @if(!empty($log->changes))
                                            <a href="#log-{{ $log->id }}" data-toggle="collapse">
                                                <i class="far fa-eye"></i> <span class="hidden-xs">{{ __('crud.view') }}</span>
                                            </a>
                                        @endif
                                    </td>
                                @endif
                            </tr>

                            @if ($campaign->boosted(true) && !empty($log->changes))
                            <tr id="log-{{ $log->id }}" class="collapse">
                                <td colspan="4">
                                    <dl class="dl-horizontal">
                                        @foreach ($log->changes as $attribute => $value)
                                            <dt>{{ $log->attributeKey($transKey, $attribute) }}</dt>
                                            <dd class="text-break">{{ $value }}</dd>
                                        @endforeach
                                    </dl>
                                </td>
                            </tr>
                            @endif
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

                    <p class="help-block">{!! __('entities/logs.superboosted', [
    'superboosted-campaigns' => link_to_route('front.features', __('crud.superboosted_campaigns'), ['#superboost'], ['target' => '_blank']),
    'amount' => config('entities.logs'),
]) !!}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
