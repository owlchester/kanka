<?php /** @var \App\Models\AppRelease $model */ ?>
<table class="table table-striped">
    <thead>
    <tr>
        <th>{{ __('admin/releases.fields.name') }}</th>
        <th>{{ __('admin/releases.fields.category') }}</th>
        <th>URL</th>
        <th>{{ __('admin/releases.fields.visibility') }}</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach ($models as $model)
        <tr>
            <td>
                <a href="{{ route('admin.app-releases.edit', $model) }}">{!! $model->name !!}</a><br />
                <p class="help-block">{!! nl2br($model->excerpt) !!}</p>
            </td>
            <td>
                {{ $model->category() }}
            </td>
            <td>
                <a href="{{ $model->link }}" target="_blank">
                    {{ \Illuminate\Support\Str::limit(\Illuminate\Support\Str::replaceFirst('https://', '', $model->link), 20) }}
                </a>
            </td>
            <td>
                {{ $model->visibility() }}
            </td>
            <td>
                <a href="{{ route('admin.app-releases.edit', $model) }}">
                    <i class="fa-solid fa-edit"></i>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

