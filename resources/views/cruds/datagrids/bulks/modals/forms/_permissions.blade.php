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
        <th>{{ __('crud.permissions.actions.view') }}</th>
        <th>{{ __('crud.permissions.actions.edit') }}</th>
        <th>{{ __('crud.permissions.actions.delete') }}</th>
        <th>{{ __('entities.posts') }}</th>
    </tr>
    <?php /** @var \App\Models\CampaignRole $role */ ?>
    @foreach ($campaign->roles()->withoutAdmin()->get() as $role)
        <tr>
            <td>{{ $role->name }}</td>
            <td class="field">
                <x-forms.select name="role[{{ $role->id }}][{{ \App\Enums\Permission::View->value }}]" :options="$actions" selected="ignore" />
            </td>
            @if (!$role->is_public)
                <td class="field">
                    <x-forms.select name="role[{{ $role->id }}][{{ \App\Enums\Permission::Update->value }}]" :options="$actions" selected="ignore" />
                </td>
                <td class="field">
                    <x-forms.select name="role[{{ $role->id }}][{{ \App\Enums\Permission::Delete->value }}]" :options="$actions" selected="ignore" />
                </td>
                <td class="field">
                    <x-forms.select name="role[{{ $role->id }}][{{ \App\Enums\Permission::Posts->value }}]" :options="$actions" selected="ignore" />
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
        <th>{{ __('crud.permissions.actions.view') }}</th>
        <th>{{ __('crud.permissions.actions.edit') }}</th>
        <th>{{ __('crud.permissions.actions.delete') }}</th>
        <th>{{ __('entities.posts') }}</th>
    </tr>
    <?php /** @var \App\Models\CampaignUser $member */ ?>
    @foreach ($campaign->members()->with('user')->withoutAdmins()->paginate(20) as $member)
        <tr>
            <td>{{ $member->user->name }}</td>
            <td class="field">
                <x-forms.select name="user[{{ $member->user_id }}][{{ \App\Enums\Permission::View->value }}]" :options="$actions" selected="ignore" />
            </td>
            <td class="field">
                <x-forms.select name="user[{{ $member->user_id }}][{{ \App\Enums\Permission::Update->value }}]" :options="$actions" selected="ignore" />
            </td>
            <td class="field">
                <x-forms.select name="user[{{ $member->user_id }}][{{ \App\Enums\Permission::Delete->value }}]" :options="$actions" selected="ignore" />
            </td>
            <td class="field">
                <x-forms.select name="user[{{ $member->user_id }}][{{ \App\Enums\Permission::Posts->value }}]" :options="$actions" selected="ignore" />
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
