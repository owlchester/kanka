<?php
$actions = [
    'allow' => __('crud.permissions.actions.bulk_entity.allow'),
    'ignore' => __('crud.permissions.actions.bulk.ignore'),
    'deny' => __('crud.permissions.actions.bulk_entity.deny'),
    'inherit' => __('crud.permissions.actions.bulk_entity.inherit'),
];
?>
<table id="crud_permissions" class="table table-hover">
    <tbody>
    <tr>
        <th>{{ __('crud.permissions.fields.role') }}</th>
        <th>{{ __('crud.permissions.actions.read') }}</th>
        <th>{{ __('crud.permissions.actions.edit') }}</th>
        <th>{{ __('crud.permissions.actions.delete') }}</th>
        <th>{{ __('entities.posts') }}</th>
    </tr>
    <?php /** @var \App\Models\CampaignRole $role */ ?>
    @foreach ($campaign->roles()->withoutAdmin()->get() as $role)
        <tr>
            <td>{{ $role->name }}</td>
            <td class="field">
                {!! Form::select(
                'role[' . $role->id . '][' . \App\Models\CampaignPermission::ACTION_READ . ']',
                $actions,
                'ignore',
                ['class' => 'w-full']) !!}
            </td>
            @if (!$role->is_public)
                <td class="field">
                    {!! Form::select(
                    'role[' . $role->id . '][' . \App\Models\CampaignPermission::ACTION_EDIT . ']',
                    $actions,
                    'ignore',
                    ['class' => 'w-full']) !!}
                </td>
                <td class="field">
                    {!! Form::select(
                    'role[' . $role->id . '][' . \App\Models\CampaignPermission::ACTION_DELETE . ']',
                    $actions,
                    'ignore',
                    ['class' => 'w-full']) !!}
                </td>
                <td class="field">
                    {!! Form::select(
                    'role[' . $role->id . '][' . \App\Models\CampaignPermission::ACTION_POSTS . ']',
                    $actions,
                    'ignore',
                    ['class' => 'w-full']) !!}
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
        <th>{{ __('entities.posts') }}</th>
    </tr>
    <?php /** @var \App\Models\CampaignUser $member */ ?>
    @foreach ($campaign->members()->with('user')->withoutAdmins()->paginate(20) as $member)
        <tr>
            <td>{{ $member->user->name }}</td>
            <td class="field">
                {!! Form::select(
                'user[' . $member->user_id . '][' . \App\Models\CampaignPermission::ACTION_READ . ']',
                $actions,
                'ignore',
                ['class' => 'w-full']) !!}
            </td>
            <td class="field">
                {!! Form::select(
                'user[' . $member->user_id . '][' . \App\Models\CampaignPermission::ACTION_EDIT . ']',
                $actions,
                'ignore',
                ['class' => 'w-full']) !!}
            </td>
            <td class="field">
                {!! Form::select(
                'user[' . $member->user_id . '][' . \App\Models\CampaignPermission::ACTION_DELETE . ']',
                $actions,
                'ignore',
                ['class' => 'w-full']) !!}
            </td>
            <td class="field">
                {!! Form::select(
                'user[' . $member->user_id . '][' . \App\Models\CampaignPermission::ACTION_POSTS . ']',
                $actions,
                'ignore',
                ['class' => 'w-full']) !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
