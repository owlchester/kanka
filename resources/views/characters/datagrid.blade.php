<table id="characters" class="table table-striped">
    <tbody><tr>
        <th class="avatar"><br></th>
        <th><a href="{{ route('characters.index', ['order' => 'name', 'page' => request()->get('page')]) }}">{{ trans('characters.fields.name') }}</a></th>
        <th>{{ trans('characters.fields.family') }}</th>
        <th>{{ trans('characters.fields.location') }}</th>
        <th><a href="{{ route('characters.index', ['order' => 'age', 'page' => request()->get('page')]) }}">{{ trans('characters.fields.age') }}</a></th>
        <th><a href="{{ route('characters.index', ['order' => 'race', 'page' => request()->get('page')]) }}">{{ trans('characters.fields.race') }}</a></th>
        <th><a href="{{ route('characters.index', ['order' => 'sex', 'page' => request()->get('page')]) }}">{{ trans('characters.fields.sex') }}</a></th>
        @if (!Auth::user()->viewer())
            <th><a href="{{ route('characters.index', ['order' => 'is_private', 'page' => request()->get('page')]) }}">{{ trans('crud.fields.is_private') }}</a></th>
        @endif
        <th>&nbsp;</th>
    </tr>
    @foreach ($models as $character)
        @include('characters._row')
    @endforeach
    </tbody>
</table>