<?php
/**
 * @var \App\Models\CampaignRole $role
 */
?>
@extends('layouts.app', [
    'title' => __('campaigns.roles.show.title', ['role' => $role->name, 'campaign' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route('campaign'), 'label' => __('campaigns.index.title')],
        ['url' => route('campaign_roles.index'), 'label' => __('campaigns.show.tabs.roles')],
        $role->name,
    ],
    'mainTitle' => false,
])

@section('content')
    @include('partials.errors')
    @inject('permission', 'App\Services\PermissionService')

    <div class="row">
        @includeWhen(!$role->is_public, 'campaigns.roles._members')

        <div class="col-md-12 col-lg-9">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ __('crud.permissions.title') }}</h3>

                    <div class="box-tools">
                        <button class="btn btn-sm btn-secondary" data-target="#permission-modal" data-toggle="modal">
                            <i class="fa fa-question-circle"></i> {{ __('campaigns.roles.modals.details.button') }}
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <p class="help-block">{{ __('campaigns.roles.hints.role_permissions', ['name' => $role->name]) }}</p>
                    @if ($role->is_public)
                        <p class="help-block">{!! __('campaigns.roles.hints.public', ['more' => '']) !!}<br />
                            <a href="https://www.youtube.com/watch?v=VpY_D2PAguM" target="_blank"><i class="fas fa-external-link-alt"></i> {{ __('helpers.public') }}</a>
                        </p>
                    @endif

                    @can('permission', $role)
                    {{ Form::open(['route' => ['campaign_roles.savePermissions', 'campaign_role' => $role], 'data-shortcut' => '1']) }}

                        @include('campaigns.roles._pretty')
                    @endif
                </div>
                <div class="box-footer">
                    @can('permission', $role)
                        <div class="form-group">
                            <button class="btn btn-success pull-right">{{ __('crud.save') }}</button>
                        </div>
                        {{ Form::close() }}
                    @else
                        <p>{{ __('campaigns.roles.permissions.hint') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
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
