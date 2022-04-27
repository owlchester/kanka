<?php
$actions = [
        'allow' => __('crud.permissions.actions.bulk_entity.allow'),
        'ignore' => __('crud.permissions.actions.bulk.ignore'),
        'deny' => __('crud.permissions.actions.bulk_entity.deny'),
        'inherit' => __('crud.permissions.actions.bulk_entity.inherit'),
];
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.click_modal.close') }}"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="clickModalLabel">{{ __('crud.bulk.permissions.title') }}</h4>
</div>
<div class="modal-body">
    <table id="crud_permissions" class="table table-hover">
        <tbody>
        <tr>
            <th>{{ __('crud.permissions.fields.role') }}</th>
            <th>{{ __('crud.permissions.actions.read') }}</th>
            <th>{{ __('crud.permissions.actions.edit') }}</th>
            <th>{{ __('crud.permissions.actions.delete') }}</th>
            <th>{{ __('crud.permissions.actions.entity_note') }}</th>
        </tr>
        <?php /** @var \App\Models\CampaignRole $role */ ?>
        @foreach ($campaign->roles()->withoutAdmin()->get() as $role)
            <tr>
                <td>{{ $role->name }}</td>
                <td>
                    {!! Form::select(
                    'role[' . $role->id . '][' . \App\Models\CampaignPermission::ACTION_READ . ']',
                    $actions,
                    'ignore',
                    ['class' => 'form-control']) !!}
                </td>
                @if (!$role->is_public)
                    <td>
                        {!! Form::select(
                        'role[' . $role->id . '][' . \App\Models\CampaignPermission::ACTION_EDIT . ']',
                        $actions,
                        'ignore',
                        ['class' => 'form-control']) !!}
                    </td>
                    <td>

                        {!! Form::select(
                        'role[' . $role->id . '][' . \App\Models\CampaignPermission::ACTION_DELETE . ']',
                        $actions,
                        'ignore',
                        ['class' => 'form-control']) !!}
                    </td>
                    <td>
                        {!! Form::select(
                        'role[' . $role->id . '][' . \App\Models\CampaignPermission::ACTION_POSTS . ']',
                        $actions,
                        'ignore',
                        ['class' => 'form-control']) !!}
                    </td>
                @else
                    <td colspan="3"></td>
                @endif
            </tr>
        @endforeach
        <tr>
            <td colspan="5">&nbsp;</td>
        </tr>
        <tr>
            <th>{{ __('crud.permissions.fields.member') }}</th>
            <th>{{ __('crud.permissions.actions.read') }}</th>
            <th>{{ __('crud.permissions.actions.edit') }}</th>
            <th>{{ __('crud.permissions.actions.delete') }}</th>
            <th>{{ __('crud.permissions.actions.entity_note') }}</th>
        </tr>
        <?php /** @var \App\Models\CampaignUser $member */ ?>
        @foreach ($campaign->members()->with('user')->withoutAdmins()->get() as $member)

            <tr>
                <td>{{ $member->user->name }}</td>
                <td>
                    {!! Form::select(
                    'user[' . $member->user_id . '][' . \App\Models\CampaignPermission::ACTION_READ . ']',
                    $actions,
                    'ignore',
                    ['class' => 'form-control']) !!}
                </td>
                <td>
                    {!! Form::select(
                    'user[' . $member->user_id . '][' . \App\Models\CampaignPermission::ACTION_EDIT . ']',
                    $actions,
                    'ignore',
                    ['class' => 'form-control']) !!}
                </td>
                <td>
                    {!! Form::select(
                    'user[' . $member->user_id . '][' . \App\Models\CampaignPermission::ACTION_DELETE . ']',
                    $actions,
                    'ignore',
                    ['class' => 'form-control']) !!}
                </td>
                <td>
                    {!! Form::select(
                    'user[' . $member->user_id . '][' . \App\Models\CampaignPermission::ACTION_POSTS . ']',
                    $actions,
                    'ignore',
                    ['class' => 'form-control']) !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="modal-footer">
    <a href="#" class="pull-left" data-dismiss="modal">{{ __('crud.cancel') }}</a>
    <button class="btn btn-primary" type="submit" name="datagrid-action" value="permissions">{{ __('crud.click_modal.confirm') }}</button>
</div>
