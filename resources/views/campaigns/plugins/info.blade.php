@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('campaigns/plugins.info.title', ['plugin' => $plugin->name]),
    'breadcrumbs' => [
        ['url' => route('overview', $campaign), 'label' => __('entities.campaign')],
        ['url' => route('campaign_plugins.index', $campaign), 'label' => __('campaigns.show.tabs.plugins')],
        __('campaigns/plugins.info.title', ['plugin' => $plugin->name]),
    ],
    'canonical' => true,
    'sidebar' => 'campaign',
])


@section('content')
    <x-dialog.header>
        {!! $plugin->name !!} - {{ __('campaigns/plugins.info.updates') }}
    </x-dialog.header>
    <article class="text-left max-w-2xl">
        <div class="formless">
            <div class="flex gap-2 w-full">
                <div class="plugin-summary grow">
                    @if (!empty($plugin->summary))
                        {!! $plugin->summary !!}
                    @else
                        {!! \Illuminate\Support\Str::limit($plugin->entry, 300) !!}
                    @endif
                </div>

                @if($plugin->hasUpdate())
                    <div>
                        <x-form :action="['campaign_plugins.update', $campaign, $plugin]" class="inline-block">
                            <button type="submit" class="btn2 btn-primary btn-sm">
                                <x-icon class="fa-solid fa-download" />
                                {{ __('campaigns/plugins.actions.update') }}
                            </button>
                        </x-form>
                    </div>
                @endif
            </div>

            @foreach ($versions as $version)
                <div class="plugin-box  w-full border-t pt-5">

                    <div class="plugin-head flex items-center gap-2">
                        <div class="grow">
                            <x-icon class="fa-solid fa-code-branch" />
                            <strong>{{ $version->version }}</strong>
                        </div>
                        <div class="">
                            <span class="text-xs">{{ $version->updated_at->diffForHumans() }}</span>
                            @if($version->id == $plugin->pivot->plugin_version_id)
                                <x-badge type="accent">
                                    {{ __('campaigns/plugins.info.your_version') }}
                                </x-badge>
                            @endif
                            @if ($version->status_id == 1)
                                <x-badge>
                                    DRAFT
                                </x-badge>
                            @endif
                        </div>
                    </div>

                    <div class="plugin-body text-justify p-2">
                        {!! $version->entry !!}
                    </div>
                </div>
            @endforeach

            @if ($versions->hasPages())
            <div class="">
                {!! $versions->onEachSide(0)->links() !!}
            </div>
            @endif
        </div>
    </article>
@endsection
