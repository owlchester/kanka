<?php
/** @var \App\Models\Quest[] $subquests */
$subquests = $model->quests()->has('quest')->orderBy('name', 'ASC')->paginate(1);
if($subquests->count() == 0) {
    return;
}
?>

@inject('dateRenderer', 'App\Renderers\DateRenderer')

<div class="box box-solid quest-subquests" id="subquests">
    <div class="box-header with-border">
        <h3 class="box-title">{{ __('quests.fields.quests') }}</h3>
    </div>
    <div class="box-body entity-content">
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
            @foreach ($subquests as $subquest)
                <tr>
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $subquest->getImageUrl(40) }}');" title="{{ $subquest->name }}" href="{{ route('quests.show', $subquest->id) }}"></a>
                    </td>
                    <td>
                        {!! $subquest->tooltipedLink() !!}
                    </td>
                    <td>
                        {{ $subquest->type }}
                    </td>
                    <td>
                        {{ $dateRenderer->render($subquest->date) }}
                    </td>
                    <td>
                        @if ($subquest->is_completed)
                            <i class="fa fa-check-circle" title="{{ __('quests.fields.is_completed') }}"></i>
                        @endif
                    </td>
                    <td>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $subquests->fragment('subquests')->links() }}

    </div>
</div>
