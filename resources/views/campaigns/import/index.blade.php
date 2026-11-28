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

@php
    $maxZipMb = (int) config('imports.max_size_zip_mb', 512);
    $maxCsvMb = (int) config('imports.max_size_csv_mb', 50);
@endphp

@section('content')
    <div class="flex gap-5 flex-col">
        @include('ads.top')
        @include('partials.errors')

        <x-campaigns.page-header
            :title="__('campaigns/import.title')"
            learn-more-url="features/campaigns/import.html"
            :lead="$canImportZip ? __('campaigns/import.description_v2') : __('campaigns/import.description_csv')"
        />

        @if($token->isPrepared())
            <form id="campaign-import-form"
                  class="p-4 rounded-xl bg-base-100"
                  data-presign-url="{{ route('campaign.import.presign', [$campaign, $token]) }}"
                  data-confirm-url="{{ route('campaign.import.confirm', [$campaign, $token]) }}"
                  data-allowed-extensions="{{ $canImportZip ? 'zip,csv' : 'csv' }}"
                  data-max-zip-size="{{ $maxZipMb * 1024 * 1024 }}"
                  data-max-csv-size="{{ $maxCsvMb * 1024 * 1024 }}"
                  data-error-type="{{ $canImportZip ? __('campaigns/import.errors.file_type_all') : __('campaigns/import.errors.file_type_csv') }}"
                  data-error-size-zip="{{ __('campaigns/import.errors.file_size', ['size' => $maxZipMb . ' MiB']) }}"
                  data-error-size-csv="{{ __('campaigns/import.errors.file_size', ['size' => $maxCsvMb . ' MiB']) }}">
                {{ csrf_field() }}
                    <x-grid type="1/1">
                        <h2 class="text-lg font-light">{{ __('campaigns/import.form') }}</h2>

                        <div class="field field-entities flex flex-col gap-1">
                            <label>{{ $canImportZip ? __('campaigns/import.fields.file_v2') : __('campaigns/import.fields.file_csv') }}</label>

                            <input type="file" name="file" class="w-full" id="export-files" accept="{{ $canImportZip ? '.zip, .csv' : '.csv' }}" />
                            <x-helper>
                                @if ($canImportZip)
                                    <p>{{ __('campaigns/import.limitation_v2', ['size' => $maxZipMb . ' MiB', 'csv_size' => $maxCsvMb . ' MiB']) }}</p>
                                @else
                                    <p>{{ __('campaigns/import.limitation_csv', ['size' => $maxCsvMb . ' MiB']) }}</p>
                                @endif
                            </x-helper>
                        </div>

                        <button type="submit" class="btn2 btn-primary">
                            {{ $canImportZip ? __('campaigns/import.actions.upload') : __('campaigns/import.actions.upload_csv') }}
                        </button>

                        <input type="hidden" name="campaign" value="{{ $campaign->id }}" />
                        <input type="hidden" name="token" value="{{ $token->id }}" />
                    </x-grid>
            </form>

            <div class="progress w-full bg-gray hidden">
                <div class="text-center text-2xl py-4">
                    <x-icon class="load" />
                    <p class="progress-uploading">
                        {{ __('campaigns/import.progress.uploading') }} <span class="progress-percent">0</span>%
                    </p>
                    <p class="progress-validating hidden">
                        {{ __('campaigns/import.status.validating') }}
                    </p>
                </div>
                <div class="h-0.5 bg-aqua" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                    <span class="sr-only"></span>
                </div>
            </div>
        @endif

        @if (! $canImportZip)
            <x-box class="flex flex-col gap-3">

                <h2 class="text-lg font-light">
                    {{ __('campaigns/import.subscription.title') }}
                </h2>
                <p>
                    {!! __('campaigns/import.subscription.pitch', ['wyvern' => '<strong>Wyvern</strong>', 'elemental' => '<strong>Elemental</strong>']) !!}
                </p>
                <div>
                    <a href="{{ route('settings.subscription', ['f' => 'cta', 'w' => $campaign->id]) }}" class="btn2 btn-primary btn-sm">
                        {{ __('callouts.actions.subscription') }}
                    </a>
                </div>
            </x-box>
        @endif

        <div id="datagrid-parent" class="table-responsive">
            @include('layouts.datagrid._table')
        </div>
    </div>
@endsection

@section('modals')

@endsection

@section('scripts')
    @parent
    @vite('resources/js/campaigns/import.js')
@endsection
