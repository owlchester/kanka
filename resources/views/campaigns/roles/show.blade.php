<?php
/**
 * @var \App\Models\CampaignRole $role
 */
?>
@extends('layouts.app', [
    'title' => __('campaigns/roles.show.title', ['role' => $role->name, 'campaign' => $model->name]),
    'breadcrumbs' => [
        ['url' => route('overview', $campaign), 'label' => __('entities.campaign')],
        ['url' => route('campaign_roles.index', $campaign), 'label' => __('campaigns.show.tabs.roles')],
        $role->name,
    ],
    'mainTitle' => false,
])

@section('content')
    @include('partials.errors')
    @inject('permission', 'App\Services\PermissionService')

    @if ($role->isPublic())
        @include('campaigns.roles._public')
    @else
    <div class="flex gap-2 lg:gap-5 flex-col lg:flex-row max-w-7xl">
        <div class="lg:flex-none lg:w-60">
        @include('campaigns.roles._members')
        </div>
        <div class="grow">
            <div class="flex gap-2 items-center mb-5">
                <h3 class="m-0 grow">{{ __('crud.permissions.title') }}</h3>
                <button class="btn2 btn-sm btn-ghost" data-target="permission-modal" data-toggle="dialog">
                    <x-icon class="question"></x-icon> {{ __('crud.actions.help') }}
                </button>
            </div>
            @if (!$role->isAdmin())
                <x-alert type="info">
                    <p>{!! __('campaigns.roles.hints.role_permissions', ['name' => '<code>' . $role->name . '</code>']) !!}</p>
                </x-alert>
            @else
                <x-alert type="info">
                    <p>{!! __('campaigns.roles.hints.role_admin', ['name' => '<code>' . $role->name . '</code>']) !!} </p>
                </x-alert>
            @endif
            <x-box>
                @can('permission', $role)
                {{ Form::open(['route' => ['campaign_roles.savePermissions', $campaign, 'campaign_role' => $role], 'data-shortcut' => '1']) }}
                        <div class="w-full overflow-y-auto">
                    @include('campaigns.roles._pretty')
                        </div>
                @endif
                @can('permission', $role)
                <div class="text-right mt-5">
                    <button class="btn2 btn-primary">
                        <x-icon class="save"></x-icon>
                        {{ __('crud.save') }}
                    </button>
                </div>
                    {{ Form::close() }}
                @endif
            </x-box>
        </div>
    </div>
    @endif
@endsection

@section('modals')
    <x-dialog id="permission-modal" :title="__('campaigns.roles.modals.details.title')">
        <p>
            {!! __('campaigns.roles.modals.details.entities') !!}
        </p>

        <ul>
            <li>
                <code>{{ __('campaigns.roles.permissions.actions.read') }}</code>:
                {{ __('campaigns.roles.permissions.helpers.read') }}
            </li>
            <li>
                <code>{{ __('campaigns.roles.permissions.actions.edit') }}</code>:
                {{ __('campaigns.roles.permissions.helpers.edit') }}
            </li>
            <li>
                <code>{{ __('campaigns.roles.permissions.actions.add') }}</code>:
                {{ __('campaigns.roles.permissions.helpers.add') }}
            </li>
            <li>
                <code>{{ __('campaigns.roles.permissions.actions.delete') }}</code>:
                {{ __('campaigns.roles.permissions.helpers.delete') }}
            </li>
            <li>
                <code>{{ __('entities.posts') }}</code>:
                {{ __('campaigns.roles.permissions.helpers.entity_note') }}
            </li>
            <li>
                <code>{{ __('campaigns.roles.permissions.actions.permission') }}</code>:
                {{ __('campaigns.roles.permissions.helpers.permission') }}
            </li>
        </ul>

        <p>
            {!! __('campaigns.roles.modals.details.campaign') !!}
        </p>


        <ul>
            <li>
                <code>{{ __('campaigns.roles.permissions.actions.manage') }}</code>:
                {{ __('campaigns.roles.permissions.helpers.manage') }}
            </li>
            <li>
                <code>{{ __('campaigns.roles.permissions.actions.dashboard') }}</code>:
                {{ __('campaigns.roles.permissions.helpers.dashboard') }}
            </li>
            <li>
                <code>{{ __('campaigns.roles.permissions.actions.members') }}</code>:
                {{ __('campaigns.roles.permissions.helpers.members') }}
            </li>
            <li>
                <code>{{ __('campaigns.roles.permissions.actions.gallery') }}</code>:
                {{ __('campaigns.roles.permissions.helpers.gallery') }}
            </li>
        </ul>

        <p>
            <a href="https://www.youtube.com/watch?v=ikNPzNgjYmg" target="_blank" class="inline-block py-5">
                {{ __('campaigns.roles.modals.details.more') }}
            </a>
        </p>
    </x-dialog>
@endsection

@section('styles')
    <!-- Needed to show the icons instead of the checkbox input fields -->
    <link href="/vendor/pretty-checkbox/pretty-checkbox.min.css" rel="stylesheet">
@endsection
