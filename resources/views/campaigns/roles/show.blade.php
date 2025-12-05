<?php
/**
 * @var \App\Models\CampaignRole $role
 */
?>
@extends('layouts.app', [
    'title' => $role->name . ' - ' . $model->name,
    'breadcrumbs' => [
        ['url' => route('campaign_roles.index', $campaign), 'label' => __('campaigns.show.tabs.roles')],
        $role->name,
    ],
    'mainTitle' => false,
    'sidebar' => 'campaign',
    'centered' => true,
])

@section('content')
    @include('partials.errors')

    @if ($role->isPublic())
        @include('campaigns.roles._public')
    @else
    <div class="flex flex-col gap-5 relative">
        @include('campaigns.roles._members')

        <div class="flex gap-2 items-center justify-between">
            <h1 class="text-2xl">{{ __('crud.permissions.title') }}</h1>
            <button class="btn2 btn-sm btn-ghost" data-target="permission-modal" data-toggle="dialog">
                <x-icon class="question" />
                {{ __('general.learn-more') }}
            </button>
        </div>
        @if (!$role->isAdmin())
            <p>{!! __('campaigns.roles.hints.role_permissions', ['name' => '<span class="font-semibold">' . $role->name . '</span>']) !!}</p>
        @else
            <p>{!! __('campaigns.roles.hints.role_admin', ['name' => '<span class="font-semibold">' . $role->name . '</span>']) !!} </p>
        @endif
        @if (!$role->isAdmin())
            @can('permission', $role)
                <x-form :action="['campaign_roles.savePermissions', $campaign, 'campaign_role' => $role]">
                    <div class="w-full flex flex-col gap-4">
                        @include('campaigns.roles._pretty')

                        <div class="sticky bottom-4 ml-auto z-50">
                            <button class="btn2 btn-primary">
                                <x-icon class="save" />
                                {{ __('crud.save') }}
                            </button>
                        </div>
                    </div>
                </x-form>
            @endif
        @endif
    </div>
    @endif
@endsection

@section('modals')
    <x-dialog id="permission-modal" :title="__('campaigns.roles.modals.details.title')">
        <p class="m-0">
            {!! __('campaigns.roles.modals.details.entities') !!}
        </p>
        <ul>
            <li>
                <code>{{ __('campaigns.roles.permissions.actions.read') }}</code>
                {{ __('campaigns.roles.permissions.helpers.read') }}
            </li>
            <li>
                <code>{{ __('campaigns.roles.permissions.actions.edit') }}</code>
                {{ __('campaigns.roles.permissions.helpers.edit') }}
            </li>
            <li>
                <code>{{ __('campaigns.roles.permissions.actions.add') }}</code>
                {{ __('campaigns.roles.permissions.helpers.add') }}
            </li>
            <li>
                <code>{{ __('campaigns.roles.permissions.actions.delete') }}</code>
                {{ __('campaigns.roles.permissions.helpers.delete') }}
            </li>
            <li>
                <code>{{ __('entities.posts') }}</code>
                {{ __('campaigns.roles.permissions.helpers.entity_note') }}
            </li>
            <li>
                <code>{{ __('campaigns.roles.permissions.actions.permission') }}</code>
                {{ __('campaigns.roles.permissions.helpers.permission') }}
            </li>
        </ul>

        <p class="m-0">
            {!! __('campaigns.roles.modals.details.campaign') !!}
        </p>

        <ul>
            <li>
                <code>{{ __('campaigns.roles.permissions.actions.manage') }}</code>
                {{ __('campaigns.roles.permissions.helpers.manage') }}
            </li>
            <li>
                <code>{{ __('campaigns.roles.permissions.actions.dashboard') }}</code>
                {{ __('campaigns.roles.permissions.helpers.dashboard') }}
            </li>
            <li>
                <code>{{ __('campaigns.roles.permissions.actions.members') }}</code>
                {{ __('campaigns.roles.permissions.helpers.members') }}
            </li>
        </ul>


        <p class="m-0">
            {!! __('sidebar.gallery') !!}
        </p>

        <ul>
            <li>
                <code>{{ __('campaigns.roles.permissions.actions.gallery.manage') }}</code>
                {{ __('campaigns.roles.permissions.helpers.gallery.manage') }}
            </li>
            <li>
                <code>{{ __('campaigns.roles.permissions.actions.gallery.browse') }}</code>
                {{ __('campaigns.roles.permissions.helpers.gallery.browse') }}
            </li>
            <li>
                <code>{{ __('campaigns.roles.permissions.actions.gallery.upload') }}</code>
                {{ __('campaigns.roles.permissions.helpers.gallery.upload') }}
            </li>
        </ul>

        <p class="m-0">
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
