@extends('layouts.partner', [
    'title' => 'Partner Referrals',
])

<?php /** @var \App\Models\Referral $referral */?>
@section('content')
    <p class="help-block">Your referral codes are displayed in this interface.</p>
    <x-box :padding="0">
        <table class="table table-hover table-borderless">
            <thead>
            <tr>
                <th>Referral code</th>
                <th>Users</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($referrals as $referral)
                <tr>
                    <td><a href="{{ route('home', ['ref' => $referral->code]) }}" target="_blank">{{ $referral->code }}</a></td>
                    <td>
                        {{ $referral->users()->count() }}
                    </td>
                    <td>
                        @if($referral->is_valid) active @else disabled @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </x-box>
@endsection
