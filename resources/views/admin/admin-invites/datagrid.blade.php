<?php /** @var \App\Models\AdminInvite $model */ ?>
<table class="table table-striped">
    <thead>
    <tr>
        <th>Campaign</th>
        <th>User</th>
        <th class="hidden-xs hidden-sm">Token</th>
        <th>Date</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach ($models as $model)
        <tr>
            <td>
                <a href="{{ route('admin.campaigns.show', $model->campaign) }}">
                    {!! $model->campaign->name !!}
                </a>
            </td>
            <td>

                <a href="{{ route('admin.users.show', $model->user) }}">
                    {{ $model->user->name }}
                </a>
            </td>
            <td class="hidden-xs hidden-sm">
                {{ $model->token }}
            </td>
            <td>
                {{ $model->created_at->diffForHumans() }}
            </td>
            <td class="text-right">
                <a href="{{ route('admin.admin_invites.show', $model) }}">
                    Use token
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

