<table id="journals" class="table table-hover">
    <tbody><tr>
        <th><a href="{{ route('journals.index', ['order' => 'name', 'page' => request()->get('page')]) }}">{{ trans('journals.fields.name') }}</a></th>
        <th><a href="{{ route('journals.index', ['order' => 'type', 'page' => request()->get('page')]) }}">{{ trans('journals.fields.type') }}</a></th>
        <th><a href="{{ route('journals.index', ['order' => 'date', 'page' => request()->get('page')]) }}">{{ trans('journals.fields.date') }}</a></th>
        @if (!Auth::user()->viewer())
        <th><a href="{{ route('journals.index', ['order' => 'is_private', 'page' => request()->get('page')]) }}">{{ trans('crud.fields.is_private') }}</a></th>
        @endif
        <th>&nbsp;</th>
    </tr>
    @foreach ($models as $model)
        <tr>
            <td>
                <a href="{{ route('journals.show', $model->id) }}">{{ $model->name }}</a>
            </td>
            <td>{{ $model->type }}</td>
            <td>{{ $model->date }}</td>
            @if (!Auth::user()->viewer())
            <td>
                @if ($model->is_private == true)
                    <i class="fa fa-lock" title="{{ trans('crud.is_private') }}"></i>
                @endif
            </td>
            @endif
            <td class="text-right">
                <a href="{{ route('journals.show', ['id' => $model->id]) }}" class="btn btn-xs btn-primary">
                    <i class="fa fa-eye" aria-hidden="true"></i> {{ trans('crud.view') }}
                </a>
            </td>
        </tr>
    @endforeach
    </tbody></table>

{{ $models->appends('order', request()->get('order'))->links() }}