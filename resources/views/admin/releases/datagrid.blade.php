<?php /** @var \App\Models\AppRelease $model */ ?>
<table class="table table-striped">
    <thead>
    <tr>
        <th>{{ __('admin/releases.fields.name') }}</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach ($models as $model)
        <tr>
            <td>
                <a href="{{ $model->link }}">{{ $model->name }}</a>
            </td>
            <td>
                <a href="{{ route('admin.app-releases.edit', $model) }}">
                    <i class="fa fa-edit"></i>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

