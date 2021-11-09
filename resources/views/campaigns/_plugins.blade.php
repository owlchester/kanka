<?php /** @var \App\Models\Campaign $campaign
 * @var \App\Models\Plugin $plugin
 */?>
<div class="box box-solid">
    <div class="box-header with-border">
        <h4 class="box-title">
            <i class="fa fa-gift"></i> {{ __('campaigns.show.tabs.plugins') }}
        </h4>
    </div>
    <div class="box-body">

        <p class="help-block">{{ __('campaigns/plugins.helper')}}</p>

        <p class="text-center">
            <a href="{{ config('marketplace.url') }}" target="_blank" class="btn btn-large btn-primary">
                {{ __('campaigns/plugins.actions.go_to_marketplace') }} <i class="fa fa-external-link-alt"></i>
            </a>
        </p>
    </div>
</div>


@if($campaign->boosted())
<div class="box box-solid">
    <div class="box-body no-padding">
        <div class="table-responsive">
            <table class="table table-hover margin-top">
                <thead>
                <tr>
                    <th>{{ __('campaigns/plugins.fields.name') }}</th>
                    <th>{{ __('campaigns/plugins.fields.type') }}</th>
                    <th>{{ __('campaigns/plugins.fields.status') }}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse ($plugins as $plugin)
                    <tr @if($plugin->uuid === $highlight) class="warning" @endif>
                        <td>
                            <a href="{{ config('marketplace.url') }}/plugins/{{ $plugin->uuid }}" target="_blank">
                                {{ $plugin->name }}
                            </a><br />
                            @if($plugin->hasUpdate())
                                <a href="{{ route('campaign_plugins.update-info', $plugin) }}" class="btn btn-xs btn-info"
                                   data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('campaign_plugins.update-info', $plugin) }}">
                                    {{ __('campaigns/plugins.actions.update_available') }}
                                </a>
                            @endif
                        </td>
                        <td>
                            {{ __('campaigns/plugins.types.' . $plugin->type()) }}
                        </td>
                        <td>
                            @if($plugin->pivot->is_active)
                                <span class="hidden-xs hidden-sm">{{ __('campaigns/plugins.status.enabled') }}</span>
                                <span class="hidden-md hidden-lg">
                                <i class="fas fa-check-circle"></i>
                            </span>
                            @else
                                <span class="hidden-xs hidden-sm">{{ __('campaigns/plugins.status.disabled') }}</span>
                                <span class="hidden-md hidden-lg">
                                <i class="fas fa-times-circle"></i>
                            </span>
                            @endif
                        </td>
                        <td class="text-right">
                            <div class="dropdown">
                                <a class="dropdown-toggle btn btn-sm btn-default" data-toggle="dropdown" aria-expanded="false" data-placement="right" href="#">
                                    <i class="fa fa-ellipsis-h" data-tree="escape"></i>
                                    <span class="sr-only">{{ __('crud.actions.actions') }}</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                    @if($plugin->hasUpdate())
                                        <li>
                                            <a href="{{ route('campaign_plugins.update-info', $plugin) }}"
                                               data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('campaign_plugins.update-info', $plugin) }}">
                                                <i class="fas fa-download"></i> {{ __('campaigns/plugins.actions.update') }}
                                            </a>
                                        </li>
                                    @endif
                                    @if($plugin->isTheme())
                                        @if($plugin->pivot->is_active)
                                            <li>
                                                <a href="{{ route('campaign_plugins.disable', $plugin) }}">
                                                    <i class="fa fa-times-circle"></i> {{ __('campaigns/plugins.actions.disable') }}
                                                </a>
                                            </li>
                                        @else
                                            <li>
                                                <a href="{{ route('campaign_plugins.enable', $plugin) }}">
                                                    <i class="fa fa-check-circle"></i> {{ __('campaigns/plugins.actions.enable') }}
                                                </a>
                                            </li>
                                        @endif
                                    @elseif($plugin->isContentPack())
                                        <li>
                                            <a href="{{ route('campaign_plugins.import', $plugin, ) }}">
                                                <i class="fa fa-refresh"></i> {{ __('campaigns/plugins.actions.import') }}
                                            </a>
                                        </li>
                                    @endif

                                    <li>
                                        <a href="#" class="text-red delete-confirm" title="{{ __('crud.remove') }}"
                                           data-toggle="modal" data-name="{{ $plugin->name }}"
                                           data-target="#delete-confirm" data-delete-target="campaign-plugin-{{ $plugin->id }}"
                                        >
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                            {{ __('campaigns/plugins.actions.remove') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>


                            {!! Form::open([
                                'method' => 'DELETE',
                                'route' => ['campaign_plugins.destroy', 'plugin' => $plugin],
                                'style' => 'display:inline',
                                'id' => 'campaign-plugin-' . $plugin->id,
                            ]) !!}

                            {!! Form::close() !!}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">
                            <p class="help-block">{{ __('campaigns/plugins.empty_list') }}</p>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($plugins->hasPages())
    <div class="box-footer text-right">
        {!! $plugins->links() !!}
    </div>
    @endif
</div>
@endif
