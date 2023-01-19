<?php /** @var \Laravel\Cashier\Invoice $invoice */?>
@extends('layouts.app', [
    'title' => __('billing/invoices.title'),
    'description' => '',
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'noads' => true,
])

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-lg-6">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ __('billing/invoices.title') }}</h3>
                </div>
                <div class="box-body">
                    <p class="help-block">
                        {!! __('billing/invoices.description') !!}
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
                                        <i class="fa-solid fa-download"></i> {{  __('billing/invoices.actions.download') }}
                                    </a>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
