@extends('layouts.app', [
    'title' => __('campaigns/import.title') . ' - ' . $campaign->name,
    'breadcrumbs' => [
        __('campaigns.show.tabs.import')
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
                {{ __('campaigns/import.title') }}
            </h3>
            <x-learn-more url="features/campaigns/import.html" />
        </div>

        <p class="max-w-2xl">{{ __('campaigns/import.description') }}</p>

        @can('import', $campaign)
            @if (empty($token))
                <div class="flex gap-2 items-center rounded bg-base-100 text-base-content p-4">
                    <p class="grow">
                    {!! __('Include with all subscription levels to Kanka.') !!}
                    </p>
                    <a href="{{ route('settings.subscription') }}" class="btn2 btn-primary btn-sm">{{ __('upgrade') }}</a>
                </div>
            @else
                @if($token->isPrepared())
                    <form id="campaign-import-form" method="post" action="{{ \App\Facades\Domain::importer() }}">
                        <x-box>
                        {{ csrf_field() }}
                            <x-grid type="1/1">
                                <h4>{{ __('campaigns/import.form') }}</h4>

                                <div class="field field-entities flex flex-col gap-1">
                                    <label>{{ __('campaigns/import.fields.file') }}</label>

                                    <input type="file" name="file" class="w-full" id="export-files" accept=".zip" />
                                    <x-helper>{{ __('campaigns/import.limitation', ['size' => '512 MiB']) }}</x-helper>
                                </div>

                                <button type="submit" class="btn2 btn-primary">
                                    {{ __('campaigns/import.actions.import') }}
                                </button>

                                <input type="hidden" name="campaign" value="{{ $campaign->id }}" />
                                <input type="hidden" name="token" value="{{ $token->id }}" />
                            </x-grid>
                        </x-box>
                    </form>

                    <div class="progress w-full bg-gray hidden">
                        <div class="text-center text-2xl py-4">
                            <x-icon class="load" />
                            <p class="progress-uploading">
                                {{ __('campaigns/import.progress.uploading') }} <span class="progress-percent">0</span>%
                            </p>
                            <p class="progress-validating hidden">
                                {{ __('campaigns/import.progress.validating') }}
                            </p>
                        </div>
                        <div class="h-0.5 bg-aqua" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                            <span class="sr-only"></span>
                        </div>
                    </div>
                @endif

                <div id="datagrid-parent" class="table-responsive">
                    @include('layouts.datagrid._table')
                </div>
            @endif
        @else
        <x-box>
            <p class="text-2xl">Limited access</p>
            <p class="">To access this feature, upgrade to a <a href="{{ route('settings.subscription') }}">Wyvern or Elemental subscription</a>.</p>
        </x-box>
        @endif
    </div>
@endsection

@section('modals')

@endsection

@section('scripts')
    @parent
    @vite('resources/js/campaigns/import.js')
@endsection
