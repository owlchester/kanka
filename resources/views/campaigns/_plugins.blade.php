<?php /** @var \App\Models\Campaign $campaign
 * @var \App\Models\Plugin $plugin
 */?>
<div class="box box-solid">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ __('campaigns.show.tabs.plugins') }}
        </h2>

        <p class="help-block">{{ trans('campaigns/plugins.helper')}}</p>

        <p class="text-center">
            <a href="{{ config('marketplace.url') }}" target="_blank" class="btn btn-large btn-primary">
                {{ __('campaigns/plugins.actions.go_to_marketplace') }} <i class="fa fa-external-link-alt"></i>
            </a>
        </p>

        @if($campaign->boosted())

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
            <tr>
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
                        {{ __('campaigns/plugins.status.enabled') }}
                    @else
                        {{ __('campaigns/plugins.status.disabled') }}
                    @endif
                </td>
                <td class="text-right">
                    @if($plugin->type_id == 1)
                        @if($plugin->pivot->is_active)
                            <a href="{{ route('campaign_plugins.disable', $plugin) }}" class="btn btn-default">
                                {{ __('campaigns/plugins.actions.disable') }}
                            </a>
                        @else
                            <a href="{{ route('campaign_plugins.enable', $plugin) }}" class="btn btn-default">
                                {{ __('campaigns/plugins.actions.enable') }}
                            </a>

                        @endif
                    @endif

                    <button class="btn btn-danger delete-confirm" title="{{ __('crud.remove') }}"
                            data-toggle="modal" data-name="{{ $plugin->name }}"
                            data-target="#delete-confirm" data-delete-target="campaign-plugin-{{ $plugin->id }}"
                    >
                        <i class="fa fa-trash" aria-hidden="true"></i> {{ __('campaigns/plugins.actions.remove') }}
                    </button>
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

        {!! $plugins->links() !!}

        @endif
    </div>
</div>
