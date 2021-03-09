@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => trans('campaigns/plugins.info.title', ['plugin' => $plugin->name]),
    'breadcrumbs' => [
        ['url' => route('campaigns.index'), 'label' => trans('campaigns.index.title')],
        ['url' => route('campaign_plugins.index'), 'label' => trans('campaigns.show.tabs.plugins')],
        trans('campaigns/plugins.info.title', ['plugin' => $plugin->name]),
    ],
    'canonical' => true,
])


@section('content')

    <div class="box box-solid">
        <div class="box-body">
            <h2 class="page-header with-border">
                {!! $plugin->name !!}
            </h2>

            {!! $plugin->entry !!}
        </div>
    </div>

    <div class="box box-solid">
        <div class="box-header">
            <div class="box-title">
                {{ __('campaigns/plugins.info.updates') }}
            </div>

            @if($plugin->hasUpdate())
                <div class="box-tools">
                    {!! Form::open(['route' => ['campaign_plugins.update', $plugin], 'method' => 'POST']) !!}
                    <button type="submit" class="btn btn-primary">{{ __('campaigns/plugins.actions.update') }}</button>
                    {!! Form::close() !!}
                </div>
            @endif
        </div>
        <div class="box-body">
            <p class="text-muted">{{ __('campaigns/plugins.info.helper') }}</p>

            @foreach ($versions as $version)
                <div class="row margin-bottom">
                    <div class="col-sm-10 col-sm-offset-1 ">
                        <hr />

                        <h5 class="box-title">{{ $version->version }}
                            @if($version->id == $plugin->pivot->plugin_version_id)
                                <span class="label label-info pull-right">{{ __('campaigns/plugins.info.your_version') }}</span>
                            @endif
                            @if ($version->status_id == 1)
                                <span class="label label-warning pull-right">
                                   DRAFT
                                </span>
                            @endif
                        </h5>
                        <div class="pull-right">
                            <small>{{ $version->updated_at->diffForHumans() }}</small>
                        </div>

                        {!! $version->entry !!}
                    </div>
                </div>
            @endforeach

            {!! $versions->links() !!}
        </div>
    </div>
@endsection
