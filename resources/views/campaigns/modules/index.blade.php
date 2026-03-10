@extends('layouts.app', [
    'title' => __('campaigns/categories.tab') . ' - ' . $campaign->name,
    'breadcrumbs' => [
        __('campaigns/categories.tab')
    ],
    'canonical' => true,
    'mainTitle' => false,
    'sidebar' => 'campaign',
    'centered' => true,
])

@section('content')
    @include('ads.top')
    @include('partials.errors')
    <div class="grow flex flex-col gap-5" id="campaign-modules">

        <div class="flex gap-2 items-center justify-between">
            <h1 class="inline-block text-2xl">
                {{ __('campaigns/categories.tab') }}
            </h1>
            <div class="flex gap-1">
                <x-learn-more url="features/campaigns/modules.html" />
                @can('update', $campaign)
                @if ($canReset)
                    <a href="#" class="btn2 btn-sm" data-toggle="dialog" data-target="reset-confirm">
                        <x-icon class="fa-regular fa-eraser" />
                        {{ __('crud.actions.reset') }}
                    </a>
                @endif
                @endcan
            </div>
        </div>

        <p>
            {{ __('campaigns/modules.helpers.tutorial') }}
        </p>

        @includeWhen(config('entities.custom'), 'campaigns.modules._custom')
        @include('campaigns.modules._default')
        @include('campaigns.modules._features')
    </div>
@endsection

@section('modals')
    @parent
    <x-dialog id="rename-dialog" :loading="true"></x-dialog>

    <x-dialog id="reset-confirm" :title="__('campaigns/modules.reset.title')">
        <x-helper>
            <p>{{ __('campaigns/modules.reset.warning') }}</p>
            <p>{{ __('campaigns/modules.reset.default') }}</p>
        </x-helper>

        <div class="grid grid-cols-2 gap-2 w-full">
            <x-buttons.confirm type="ghost" full="true" dismiss="dialog">
                {{ __('crud.cancel') }}
            </x-buttons.confirm>

            <x-form method="DELETE" :action="['modules.reset', $campaign]">
            <x-buttons.confirm type="danger" full="true" outline="true">
                {{ __('crud.actions.confirm') }}
            </x-buttons.confirm>
            </x-form>
        </div>
    </x-dialog>
@endsection
