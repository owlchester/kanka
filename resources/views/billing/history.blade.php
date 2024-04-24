<?php /** @var \Laravel\Cashier\Invoice $invoice */?>
@extends('layouts.app', [
    'title' => __('billing/invoices.title'),
    'description' => '',
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'centered' => true,
])

@section('content')
    <x-grid type="1/1">
        <h1 class="">
            {{ __('billing/invoices.title') }}
        </h1>
        <p class="text-lg">
            {{ __('billing/invoices.description') }}
        </p>

        <table class="table table-default table-borderless table-hover">
            <thead>
            <tr>
                <th>{{ __('billing/invoices.fields.date') }}</th>
                <th>{{ __('billing/invoices.fields.amount') }}</th>
                <th>{{ __('billing/invoices.fields.status') }}</th>
                <th>{{ __('billing/invoices.fields.invoice') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->date()->toFormattedDateString() }}</td>
                    <td>{{ $invoice->total() }}</td>
                    <td>{{ $invoice->paid ? __('billing/invoices.status.paid') : __('billing/invoices.status.pending') }}</td>
                    <td>
                        <a href="{{ route('billing.history.download', ['invoice' => $invoice->id]) }}">
                            <x-icon class="fa-solid fa-download" /> {{  __('billing/invoices.actions.download') }}
                        </a>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </x-grid>
@endsection
