<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\EntityLog $log */?>
@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __('entities/logs.show.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => $entity->url('index'), 'label' => __('entities.' . $entity->pluralType())],
        ['url' => $entity->url('show'), 'label' => $entity->name]
    ]
])
@section('content')
    @if ($ajax)
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">
                {{ $entity->name }}
            </h4>
        </div>
    @endif
    <div class="pagination-ajax-body">
        <div class="modal-body no-padding">
            <div class="loading text-center" style="display: none">
                <i class="fa-solid fa-spinner fa-spin fa-4x"></i>
            </div>
            <div class="pagination-ajax-content">
                <table class="table table-hover break-all">
                    <thead>
                        <tr>
                            <th>{{ __('entities/logs.fields.action') }}</th>
                            <th>{{ __('campaigns.members.fields.name') }}</th>
                            <th>{{ __('entities/logs.fields.date') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($logs as $log)
                        @if ($log->action < 7 || $log->post)
                            <tr>
                                <td>
                                    {{ __('entities/logs.actions.' . $log->actionCode(), ['post' => $log->post?->name]) }}
                                </td>
                                <td>@if ($log->user)
                                        {!! link_to_route('users.profile', $log->user->name, $log->user, ['target' => '_blank']) !!}
                                    @else
                                        {{  __('crud.history.unknown') }}
                                    @endif

                                    @if ($log->impersonator)
                                        ({{ __('entities/logs.impersonated', ['name' => $log->impersonator->name]) }})
                                    @endif
                                </td>
                                <td>
                                    <span title="{{ $log->created_at }} UTC" data-toggle="tooltip">
                                        {{ $log->created_at->diffForHumans() }}
                                    </span>
                                </td>
                                <td class="text-right">
                                    @if ($campaign->superboosted())
                                        @if(!empty($log->changes))
                                            <a href="#log-{{ $log->id }}" data-toggle="collapse">
                                                <i class="fa-solid fa-scroll" aria-hidden="true"></i>
                                                <span class="hidden-xs">{{ __('entities/logs.actions.view') }}</span>
                                            </a>
                                        @endif
                                    @else
                                    <a href="#log-cta" data-toggle="collapse">
                                        <i class="fa-solid fa-scroll" aria-hidden="true"></i>
                                        <span class="hidden-xs">{{ __('entities/logs.actions.view') }}</span>
                                    </a>
                                    @endif
                                </td>
                            </tr>
                        @endif
                        @if ($campaign->superboosted() && !empty($log->changes))
                        <tr id="log-{{ $log->id }}" class="collapse">
                            <td colspan="4">
                                <dl class="dl-horizontal">
                                    @foreach ($log->changes as $attribute => $value)
                                        @if (is_array($value)) @continue @endif
                                        <dt>{!! $log->attributeKey($transKey, $attribute) !!}</dt>
                                        <dd class="text-break">{{ $value }}</dd>
                                    @endforeach
                                </dl>
                            </td>
                        </tr>
                        @endif
                    @endforeach
                    @if (!$campaign->superboosted())
                    <tr id="log-cta" class="collapse">
                        <td colspan="4">
                                <p class="help-block">{!! __('entities/logs.call-to-action', [
'amount' => config('entities.logs'),
]) !!}</p>
                                @subscriber()
                                <a href="{{ route('settings.boost', ['campaign' => $campaign, 'superboost' => true]) }}" class="btn bg-maroon">
                                    {!! __('callouts.booster.actions.superboost', ['campaign' => $campaign->name]) !!}
                                </a>
                            @else
                                <a href="{{ route('front.boosters') }}" target="_blank" class="btn bg-maroon">
                                    {!! __('callouts.booster.learn-more') !!}
                                </a>
                            @endif
                        </td>
                    </tr>
                    @endif
                    </tbody>
                </table>

                @if (!$ajax)
                    {{ $logs->links() }}
                @endif
            </div>
        </div>

        @if ($ajax && $logs->hasPages())
            <div class="modal-footer pagination-ajax-links">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
@endsection
