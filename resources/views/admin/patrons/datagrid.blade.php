<?php /**
 * @var \App\User $model
 */
?>
<table class="table table-striped">
    <thead>
    <tr>
        <th>ID</th>
        <th>Info</th>
        <th>Patreon</th>
        <th>Pledge</th>
        <th>Boosts</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach ($models as $model)
        <tr>
            <td>{{ $model->id }}</td>
            <td>
                {{ $model->name }}<br />
                <i class="fa fa-envelope-open"></i> {{ $model->email }}
            </td>
            <td>
                {{ $model->patreon_fullname }}<br />
                <i class="fa fa-envelope-open"></i> {{ $model->patreon_email }}
            </td>
            <td>{{ $model->patreon_pledge }}</td>
            <td>
                @foreach ($model->boosts as $boost)
                   {!! $boost->campaign->dashboard() !!}<br />
                @endforeach

            </td>
            <td>
                <a href="{{ route('admin.patrons.edit', $model) }}">
                    <i class="fa fa-edit"></i>
                </a>

                <a href="#" class="text-danger delete-confirm" data-toggle="modal" data-name="{{ $model->name }}"
                        data-target="#delete-confirm" data-delete-target="delete-form-{{ $model->id }}"
                        title="{{ __('crud.remove') }}">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                </a>
                {!! Form::open(['method' => 'DELETE','route' => ['admin.patrons.destroy', $model], 'style '=> 'display:inline', 'id' => 'delete-form-' . $model->id]) !!}
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

