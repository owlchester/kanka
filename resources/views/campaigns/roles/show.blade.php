<?php
/**
 * @var \App\Models\CampaignRole $role
 */
?>
@extends('layouts.app', [
    'title' => __('campaigns/roles.show.title', ['role' => $role->name, 'campaign' => $model->name]),
    'breadcrumbs' => [
        ['url' => route('campaign'), 'label' => __('entities.campaign')],
        ['url' => route('campaign_roles.index'), 'label' => __('campaigns.show.tabs.roles')],
        $role->name,
    ],
    'mainTitle' => false,
])

@section('content')
    @include('partials.errors')
    @inject('permission', 'App\Services\PermissionService')

    @if ($role->is_public)
        @include('campaigns.roles._public')
    @else
    <div class="row">
        <div class="col-md-12 col-lg-3">
        @include('campaigns.roles._members')
        </div>
        <div class="col-md-12 col-lg-9">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ __('crud.permissions.title') }}</h3>

                    <div class="box-tools">
                        <button class="btn btn-box-tool" data-target="#permission-modal" data-toggle="modal">
                            <i class="fa-solid fa-question-circle"></i> {{ __('campaigns.members.actions.help') }}
                        </button>
                    </div>
                </div>
                <div class="box-body" style="overflow-y: auto">
                    @if (!$role->isAdmin())
                        <p class="help-block">{!! __('campaigns.roles.hints.role_permissions', ['name' => '<strong>' . $role->name . '</strong>']) !!}</p>
                    @else
                        <p class="help-block">{!! __('campaigns.roles.hints.role_admin', ['name' => '<strong>' . $role->name . '</strong>']) !!} </p>
                    @endif
                    @can('permission', $role)
                    {{ Form::open(['route' => ['campaign_roles.savePermissions', 'campaign_role' => $role], 'data-shortcut' => '1']) }}

                        @include('campaigns.roles._pretty')
                    @endif
                </div>
                <div class="box-footer text-right">
                    @can('permission', $role)
                        <button class="btn btn-success">
                            <i class="fa-solid fa-save" aria-hidden="true"></i>
                            {{ __('crud.save') }}
                        </button>
                        {{ Form::close() }}

                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection

@section('modals')

    <div class="modal fade" id="permission-modal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">
                        {{ __('campaigns.roles.modals.details.title') }}
                    </h4>
                </div>
                <div class="modal-body">
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
                            <code>{{ __('campaigns.roles.permissions.actions.entity-note') }}</code>:
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
                        <a href="https://www.youtube.com/watch?v=ikNPzNgjYmg" target="_blank">
                            {{ __('campaigns.roles.modals.details.more') }}
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <!-- Needed to show the icons instead of the checkbox input fields -->
    <link href="/vendor/pretty-checkbox/pretty-checkbox.min.css" rel="stylesheet">
@endsection
