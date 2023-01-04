<?php /** @var \App\Models\BragiLog $log */?>
@extends('layouts.app', [
    'title' => __('settings.bragi.title'),
    'description' => '',
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'noads' => true,
])

@section('content')
    @include('partials.errors')
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">
                DEBUG BRAGI LOGS
            </h3>
        </div>
        <div class="box-body">
            <div class="alert alert-info">
                <p><strong>Tokens</strong> {{ auth()->user()->availableTokens() }} / {{ auth()->user()->maxTokens() }}</p>
                <p>Your tokens refill on <strong>{{ auth()->user()->tokenRenewalDate() }}</strong>.</p>
            </div>

            <div class="overflow-y">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <td>Prompt</td>
                        <td>Result</td>
                        <td>Time</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($logs as $log)
                        <tr>
                            <td>{{ $log->prompt }}</td>
                            <td class="text-break">{!! $log->result !!}</td>
                            <td>{{ $log->created_at->diffForHumans() }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if ($logs->hasPages())
            <div class="box-footer text-right">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
@endsection
