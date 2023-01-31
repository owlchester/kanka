@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __('campaigns/plugins.info.title', ['plugin' => $plugin->name]),
    'breadcrumbs' => [
        ['url' => route('campaign'), 'label' => __('entities.campaign')],
        ['url' => route('campaign_plugins.index'), 'label' => __('campaigns.show.tabs.plugins')],
        __('campaigns/plugins.info.title', ['plugin' => $plugin->name]),
    ],
    'canonical' => true,
])


@section('content')

    <div class="{{ $ajax ? '' : 'box' }}">
        <div class="{{ $ajax ? 'modal' : 'box' }}-header">
            <h5 class="{{ $ajax ? 'modal' : 'box' }}-title">
                {!! $plugin->name !!} - {{ __('campaigns/plugins.info.updates') }}
                @if ($ajax)
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                @endif
            </h5>
        </div>

        <div class="{{ $ajax ? 'modal' : 'box' }}-body">
            <div class="plugin-summary">
                @if (!empty($plugin->summary))
                    {!! $plugin->summary !!}
                @else
                    {!! \Illuminate\Support\Str::limit($plugin->entry, 300) !!}
                @endif
            </div>

            @if($plugin->hasUpdate())
                <div class="text-right">
                    {!! Form::open(['route' => ['campaign_plugins.update', $plugin], 'method' => 'POST']) !!}
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-download"></i>
                        {{ __('campaigns/plugins.actions.update') }}
                    </button>
                    {!! Form::close() !!}
                </div>
            @endif

                @foreach ($versions as $version)
                    <div class="plugin-box">
                        <hr class="my-5" />

                        <div class="plugin-head">
                            <i class="fa-solid fa-code-branch"></i>
                            <strong>{{ $version->version }}</strong>
                            <div class="pull-right">
                                <small>{{ $version->updated_at->diffForHumans() }}</small>
                                @if($version->id == $plugin->pivot->plugin_version_id)
                                    <span class="label label-info">{{ __('campaigns/plugins.info.your_version') }}</span>
                                @endif
                                @if ($version->status_id == 1)
                                    <span class="label label-warning">
                                       DRAFT
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="plugin-body text-justify p-3">
                            {!! $version->entry !!}
                        </div>
                    </div>
                @endforeach
        </div>
        @if ($versions->hasPages())
        <div class="{{ $ajax ? 'modal' : 'box' }}-footer">
            {!! $versions->links() !!}
        </div>
        @endif
    </div>
@endsection
