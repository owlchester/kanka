@extends('layouts.app', [
    'title' => __('settings/security.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'centered' => true,
])

@section('content')
    <x-hero>
        <x-slot name="title">{{ __('settings/security.title') }}</x-slot>
        <x-slot name="subtitle">{{ __('settings/security.helper') }}</x-slot>
    </x-hero>

    <x-box>
        <x-slot name="title">{{ __('settings/security.devices.title') }}</x-slot>

        @if ($devices->isEmpty())
            <p>{{ __('settings/security.devices.empty') }}</p>
        @else
            <div class="table-responsive">
                <table class="table table-default table-borderless table-hover">
                    <thead>
                        <tr>
                            <th>{{ __('crud.fields.name') }}</th>
                            <th>{{ __('settings/security.devices.ip_address') }}</th>
                            <th>{{ __('settings/security.devices.last_active') }}</th>
                            <th class="text-right">{{ __('crud.actions.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($devices as $device)
                            <tr>
                                <td class="align-middle">
                                    {{ $device['name'] ?: __('settings/security.devices.unknown') }}
                                    @if ($device['is_current'])
                                        <span class="badge badge-success ms-2">{{ __('settings/security.devices.current') }}</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    {{ $device['ip_address'] ?? '—' }}
                                </td>
                                <td class="align-middle">
                                    {{ $device['last_active_at'] ? $device['last_active_at']->diffForHumans() : '—' }}
                                </td>
                                <td class="align-middle text-right">
                                    @if (!$device['is_current'])
                                        <x-buttons.confirm-delete :route="route('settings.security.revoke', $device['id'])" />
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($devices->filter(fn ($d) => !$d['is_current'])->isNotEmpty())
                <div class="flex justify-end mt-4">
                    <x-form :action="route('settings.security.revoke-others')" method="DELETE">
                        <x-buttons.confirm type="danger" outline size="sm">
                            {{ __('settings/security.devices.revoke_others') }}
                        </x-buttons.confirm>
                    </x-form>
                </div>
            @endif
        @endif
    </x-box>
@endsection
