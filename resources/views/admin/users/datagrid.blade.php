<?php /** @var \App\Models\Admin\UserAdmin $model */ ?>
<table class="table table-striped">
    <thead>
    <tr>
        <th>User</th>
        <th>Discord</th>
        <th>Subscription</th>
        <th>Referral Code</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach ($models as $model)
        <tr>
            <td>
                <a href="{{ route('admin.users.show', $model) }}">{{ $model->name }}</a>
                <p class="text-muted">Created at {{ $model->created_at->isoFormat('D.M.Y H:m') }}</p>
            </td>
            <td>
                @if ($discord = $model->apps->where('app', 'discord')->first())
                    <i class="fab fa-discord"></i> {{ $discord->settings['username'] }}#{{ $discord->settings['discriminator'] }}
                @endif
            </td>
            <td>
                @if ($model->subscribed('kanka'))
                    Subscribed
                @else
                    {{ $model->patreon_pledge }}
                @endif
            </td>
            <td>
                @if ($model->referrer)
                    {{ $model->referrer->code }}
                @endif
            </td>
            <td class="text-right">
                <a href="{{ route('admin.users.show', $model) }}" class="margin-r-5">
                    <i class="fa fa-eye"></i>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

