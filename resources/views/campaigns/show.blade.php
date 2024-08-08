<?php /** @var \App\Models\Campaign $campaign */?>
@extends('layouts.app', [
    'title' => __('campaigns.show.title', ['name' => $campaign->name]),
    'breadcrumbs' => false,
    'canonical' => true,
    'mainTitle' => false,
    'sidebar' => 'campaign',
    'centered' => true,
])

@section('og')
    <meta property="og:description" content="{{ $campaign->preview() }}" />
    @if ($campaign->image)<meta property="og:image" content="{{ Img::crop(280, 280)->url($campaign->image)  }}" />
    <meta property="og:image:width" content="280" />
    <meta property="og:image:height" content="280" />@endif
    <meta property="og:url" content="{{ route('overview', $campaign)  }}" />
@endsection

@section('content')
    @include('partials.errors')
    @include('partials.ads.top')

    <div class="flex gap-5 flex-col">
            @can('update', $campaign)
                @if($campaign->isPublic() && $campaign->publicHasNoVisibility())
                    <x-alert type="warning">
                        <p>{!! __('campaigns.helpers.public_no_visibility', [
    'fix' => '<a href="' . route('campaigns.campaign_roles.public', $campaign) . '">' . __('crud.fix-this-issue') . '</a>'
]) !!}</p>
                    </x-alert>
                @endif
            @endcan

            @include('campaigns._overview')

            <div class="flex gap-2 items-center">
                <h3 class="inline-block grow">
                    {!! $campaign->name !!}
                </h3>
                <div class="flex-none flex gap-1">
                    @if (auth()->check() && $campaign->userIsMember())
                        <button type="button" class="btn2 btn-sm" data-toggle="dialog-ajax" data-target="leave-confirm" data-url="{{ route('campaign.leave', $campaign) }}">
                            <x-icon class="fa-solid fa-sign-out-alt" />
                            {{ __('campaigns.show.actions.leave') }}
                        </button>
                    @endif
                    @if (auth()->check() && auth()->user()->can('roles', $campaign))
                        <button type="button" class="btn2 btn-error btn-sm" data-toggle="dialog" data-target="campaign-delete-confirm" data-focus="#campaign-delete-form">
                            <x-icon class="trash" />
                            {{ __('campaigns.destroy.action') }}
                        </button>
                    @endif

                    @can('update', $campaign)
                        <a href="{{ route('campaigns.edit', $campaign) }}" class="btn2 btn-primary btn-sm" title="{{ __('campaigns.show.actions.edit') }}">
                            <x-icon class="edit" />
                            {{ __('campaigns.show.actions.edit') }}
                        </a>
                    @endcan
                </div>
            </div>
            <div class="flex flex-col">
                <x-box>
                    @if (auth()->check() && auth()->user()->can('update', $campaign) && empty($campaign->entry))
                        <a href="{{ route('campaigns.edit', $campaign) }}">
                            {{ __('campaigns.helpers.no_entry') }}
                        </a>
                    @else
                    <div class="entity-content">
                        {!! $campaign->parsedEntry() !!}
                    </div>
                    @endif
                </x-box>

                <div class="entity-modification-history">
                    <div class="help-block text-right italic text-xs">
                        @if (!empty($campaign->created_at) && !empty($campaign->updated_at))
                        {!! __('crud.history.created_date_clean', [
                            'date' => '<span data-toggle="tooltip" data-title="' . $campaign->created_at . ' UTC' . '">' . $campaign->created_at->diffForHumans() . '</span>'
                        ]) !!}. {!! __('crud.history.updated_date_clean', [
                            'date' => '<span data-toggle="tooltip" data-title="' . $campaign->updated_at . ' UTC' . '">' . $campaign->updated_at->diffForHumans() . '</span>'
                        ]) !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
@endsection


@section('modals')
    @parent

    <x-dialog id="leave-confirm" :loading="true" />

    @if (auth()->check() && auth()->user()->can('roles', $campaign))
        <x-dialog id="campaign-delete-confirm" :title="__('campaigns.destroy.title')">
            @if (auth()->user()->can('delete', $campaign))
                <x-form method="DELETE" :action="['campaigns.destroy', $campaign]">
                    <x-grid type="1/1">
                        <p class="">{!! __('campaigns.destroy.confirm', ['campaign' => '<strong>' . $campaign->name . '</strong>']) !!}
                        <p class="text-neutral-content"> {!! __('campaigns.destroy.hint', ['code' => '<code>delete</code>']) !!} </p>

                        <div class="required field">
                            <input type="text" name="delete" value="" maxlength="10" required id="campaign-delete-form" class="w-full" />
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <x-buttons.confirm type="ghost" full="true" dismiss="dialog">
                                {{ __('crud.cancel') }}
                            </x-buttons.confirm>
                            <x-buttons.confirm type="danger" outline="true" full="true">
                                <x-icon class="fa-solid fa-sign-out-alt" />
                                {{ __('campaigns.destroy.confirm-button') }}
                            </x-buttons.confirm>
                        </div>
                    </x-grid>
                </x-form>
            @else
                <p class="">{{ __('campaigns.destroy.helper-v2') }}</p>
                <a href="{{ route('campaign_users.index', $campaign) }}" class="btn2 btn-sm">
                    {{ __('campaigns.leave.fix') }}
                </a>
            @endif
        </x-dialog>
    @endif
@endsection
