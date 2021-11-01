<?php /** @var \App\Models\CommunityEvent $model */ ?>
<table class="table table-striped">
    <thead>
    <tr>
        <th>{{ __('admin/community-events.fields.name') }}</th>
        <th>{{ __('admin/community-events.fields.status') }}</th>
        <th>{{ __('admin/community-events.fields.entries') }}</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach ($models as $model)
        <tr>
            <td>
                <a href="{{ route('community-events.show', $model) }}">
                    {!! $model->name !!}
                </a>
            </td>
            <td>
                {{ $model->status() }}
            </td>
            <td>
                <a href="{{ route('admin.community-events.show', $model) }}">{{ $model->entries->count() }} (rank)</a>
            </td>
            <td class="text-right">
                <a href="{{ route('admin.community-events.edit', $model) }}">
                    <i class="fa fa-edit"></i>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

