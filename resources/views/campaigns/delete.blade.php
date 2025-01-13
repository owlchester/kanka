@extends('layouts.app', [
    'title' => __('campaigns/delete.title') . ' - ' . $campaign->name,
    'breadcrumbs' => [
        __('campaigns.show.tabs.deletion')
    ],
    'canonical' => true,
    'mainTitle' => false,
    'sidebar' => 'campaign',
    'centered' => true,
])

@section('content')
    <div class="flex gap-5 flex-col">
        @include('ads.top')
        @include('partials.errors')

        <div class="flex gap-2 items-center">
            <h3 class="grow">
                {{ __('campaigns/delete.title') }}
            </h3>

        </div>

        <p class="">{!! __('campaigns/delete.helper', [
    'backup' => '<a href="' . route('campaign.export', $campaign) . '">'. __('campaigns/delete.backup'). ' </a>'
]) !!}</p>

        <x-box>
            @cannot('delete', $campaign)
                <p class="mb-2">{{ __('campaigns/delete.issue') }}</p>

                <a href="{{ route('campaign_users.index', $campaign) }}">
                    <x-icon class="fa-solid fa-circle-xmark" />
                    {{ __('campaigns/delete.members') }}

                </a>
            @else
                <x-form method="DELETE" :action="['campaigns.destroy', $campaign]">
                    <x-grid type="1/1">
                        <p class="">
                            {!! __('campaigns/delete.confirm', [
                                'campaign' => '<strong>' . $campaign->name . '</strong>',
                                'code' => '<code>delete</code>'
                            ]) !!}
                        </p>

                        <div class="required field flex gap-2 flex-wrap">
                            <input type="text" name="delete" @if (app()->isLocal()) value="delete" @endif autofocus maxlength="10" required id="campaign-delete-form" class="w-full" />

                            <x-buttons.confirm type="danger" full="true">
                                <x-icon class="trash" />
                                {!! __('campaigns/delete.confirm-button', [
                                    'name' => $campaign->name]) !!}
                            </x-buttons.confirm>
                        </div>

                    </x-grid>
                </x-form>
            @endcannot
        </x-box>
    </div>
@endsection

@section('modals')

@endsection
