<?php /** @var \App\Models\BragiLog $log */?>
@extends('layouts.app', [
    'title' => __('Bragi'),
    'description' => '',
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'noads' => true,
])

@section('content')
    @include('partials.errors')
    <h1 class="mb-3">
        Bragi Logs
    </h1>

    <div class="rounded p-2 bg-info text-slate-800 mb-5">
        <p><strong>Tokens</strong> {{ auth()->user()->availableTokens() }} / {{ auth()->user()->maxTokens() }}</p>
        <p class="mb-0">Your tokens refill on <strong>{{ auth()->user()->tokenRenewalDate() }}</strong>.</p>
    </div>

    @foreach ($logs as $log)
        <x-box>
            <div class="flex mb-1">
                <div class="flex-1 font-bold text-uppercase">{{ $log->prompt }}</div>
                <div class="text-right flex-none">
                    <span class="text-xs" data-toggle="tooltip" data-title="{{ $log->created_at }} UTC">{{ $log->created_at->diffForHumans() }}</span>
                </div>
            </div>
            <div class="col-span-2 break-all text-justify">{!! $log->result !!}</div>
            @if ($isAdmin)
                <div class="grid gap-2 grid-cols-{{ count($log->data) }} rounded p-3 bg-orange-100 text-slate-800">
                    @foreach($log->data as $key => $value)

                        <div class="text-center text-xs">
                            {{ $key }}: {{ $value }}
                        </div>
                    @endforeach
                </div>
            @endif
        </x-box>
    @endforeach
    @if ($logs->hasPages())
        <div class="text-right">
            {{ $logs->links() }}
        </div>
    @endif
@endsection
