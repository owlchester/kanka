<?php /** @var \App\Models\Referral $model */ ?>
<table class="table table-striped">
    <thead>
    <tr>
        <th>Referral</th>
        <th>Status</th>
        <th>Users</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach ($models as $model)
        <tr>
            <td>
                {{ $model->code }}
            </td>
            <td>
                @if($model->is_valid) active @else disabled @endif
            </td>
            <td>
                <a href="{{ route('admin.users.index', ['referral_id' => $model->id]) }}">
                    {{ $model->users()->count() }}
                </a>
            </td>
            <td>
                <a href="{{ route('admin.referrals.edit', $model) }}">
                    <i class="fa fa-edit"></i>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

