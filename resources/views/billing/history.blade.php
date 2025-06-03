<?php /** @var \Laravel\Cashier\Invoice $invoice */?>
@extends('layouts.app', [
    'title' => __('billing/invoices.title'),
    'description' => '',
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'centered' => true,
])

@section('content')
    <x-hero>
        <x-slot name="title">
            {{ __('billing/invoices.title') }}
        </x-slot>
        <x-slot name="subtitle">
            {{ __('billing/invoices.description') }}
            {{ __('billing/invoices.paypal') }}
        </x-slot>
    </x-hero>

    <x-grid type="1/1">
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
            @forelse ($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->date()->toFormattedDateString() }}</td>
                    <td>{{ $invoice->total() }}</td>
                    <td>{{ $invoice->paid ? __('billing/invoices.status.paid') : __('billing/invoices.status.pending') }}</td>
                    <td>
                        <a href="{{ route('billing.history.download', ['invoice' => $invoice->id]) }}">
                            <x-icon class="fa-regular fa-download" /> {{  __('billing/invoices.actions.download') }}
                        </a>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">
                    <em>No invoices found.</em>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </x-grid>
@endsection
