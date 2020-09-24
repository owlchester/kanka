@inject('dateRenderer', 'App\Renderers\DateRenderer')

<p>{{ trans('quests.hints.quests') }}</p>
<table id="quest-quests" class="table table-hover">
    <tbody><tr>
        <th class="avatar"><br /></th>
        <th>{{ trans('quests.fields.name') }}</th>
        <th>{{ trans('quests.fields.type') }}</th>
        <th>{{ trans('quests.fields.date') }}</th>
        <th>{{ trans('quests.fields.is_completed') }}</th>
        <th>&nbsp;</th>
    </tr>
    @foreach ($r = $model->quests()->has('quest')->orderBy('name', 'ASC')->paginate() as $model)
        <tr>
            <td>
                <a class="entity-image" style="background-image: url('{{ $model->getImageUrl(40) }}');" title="{{ $model->name }}" href="{{ route('quests.show', $model->id) }}"></a>
            </td>
            <td>
                {!! $model->tooltipedLink() !!}
            </td>
            <td>
                {{ $model->type }}
            </td>
            <td>
                {{ $dateRenderer->render($model->date) }}
            </td>
            <td>
                @if ($model->is_completed)
                    <i class="fa fa-check-circle" title="{{ __('quests.fields.is_completed') }}"></i>
                @endif
            </td>
            <td>

            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{ $r->fragment('tab_quests')->links() }}
