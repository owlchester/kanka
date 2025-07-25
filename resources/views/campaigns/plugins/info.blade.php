<?php
/**
 * @var \App\Models\Plugin $plugin
 * @var \App\Models\PluginVersion $version
 *
 */
?>
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
        {!! $plugin->name !!}
    </x-dialog.header>
    <article class="text-left max-w-2xl p-4 md:px-6">
        <x-helper>
            <p>{!! __('campaigns/plugins.info.description', ['plugin' => $plugin->name]) !!}</p>
        </x-helper>
        <div class="formless flex flex-col gap-4 w-full">
            <div class="plugin-summary grow">
                @if (!empty($plugin->summary))
                    {!! $plugin->summary !!}
                @else
                    {!! \Illuminate\Support\Str::limit($plugin->entry, 300) !!}
                @endif
            </div>

            @if($plugin->hasUpdate($plugin->created_by === auth()->user()->id))
                <x-form :action="['campaign_plugins.update', $campaign, $plugin]" class="inline-block">
                    <button type="submit" class="btn2 btn-primary btn-sm">
                        <x-icon class="fa-regular fa-download" />
                        {{ __('campaigns/plugins.actions.update-to', ['version' => $plugin->updateVersionNumber()]) }}
                    </button>
                </x-form>
            @endif
            <div class="text-lg mt-6">
                {{ __('campaigns/plugins.info.versions') }}
            </div>

            @php $first = true; @endphp
            @foreach ($versions as $version)
                @if (!$first) <hr /> @endif
                <div class="plugin-box w-full">
                    <div class="plugin-head flex items-center gap-2 justify-between">
                        <div class="flex gap-2 items-center">
                            <x-icon class="fa-solid fa-code-branch" />
                            <strong>{{ $version->version }}</strong>
                            @if($version->id == $plugin->pivot->plugin_version_id)
                                <x-badge type="accent">
                                    <span class="text-xs">
                                        {{ __('campaigns/plugins.info.installed') }}
                                    </span>
                                </x-badge>
                            @elseif ($version->isDraft())
                                <x-badge>
                                    DRAFT
                                </x-badge>
                            @endif
                        </div>
                        <div class="">
                            <span class="text-xs text-neutral-content">{{ $version->updated_at->diffForHumans() }}</span>

                        </div>
                    </div>

                    <div class="plugin-body text-neutral-content text-sm">
                        {!! $version->entry !!}
                    </div>
                </div>
                @php $first = false; @endphp
            @endforeach

            @if ($versions->hasPages())
            <div class="">
                {!! $versions->onEachSide(0)->links() !!}
            </div>
            @endif
        </div>
    </article>
@endsection
