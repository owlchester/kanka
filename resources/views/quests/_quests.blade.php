<?php
/** @var \App\Models\Quest[] $subquests */
$subquests = $model->quests()->has('quest')->orderBy('name', 'ASC')->paginate();
if($subquests->count() == 0) {
    return;
}
?>

<div class="box box-solid quest-subquests" id="subquests">
    <div class="box-header with-border">
        <h3 class="box-title">{{ __('quests.fields.quests') }}</h3>
        <div class="box-tools">
            <a href="#" class="btn btn-box-tool" data-toggle="dialog" data-target="help-modal">
                <i class="fa-solid fa-question-circle"></i> {{ __('crud.actions.help') }}
            </a>
        </div>
    </div>
    <div class="box-body entity-content">
        <table id="quest-quests" class="table table-hover">
            <thead>
                <tr>
                    <th class="avatar"><br /></th>
                    <th>{{ __('quests.fields.name') }}</th>
                    <th>{{ __('quests.fields.type') }}</th>
                    <th>{{ __('quests.fields.date') }}</th>
                    <th>{{ __('quests.fields.is_completed') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach ($subquests as $subquest)
                <tr class="{{ $subquest->rowClasses() }}">
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $subquest->thumbnail() }}');" title="{{ $subquest->name }}" href="{{ route('quests.show', $subquest->id) }}"></a>
                    </td>
                    <td>
                        @if ($subquest->is_private)
                            <i class="fa-solid fa-lock" title="{{ __('crud.is_private') }}" data-toggle="tooltip"></i>
                        @endif
                        {!! $subquest->tooltipedLink() !!}
                    </td>
                    <td>
                        {{ $subquest->type }}
                    </td>
                    <td>
                        @if (!empty($subquest->date))
                            {{ \App\Facades\UserDate::format($subquest->date) }}
                        @endif
                    </td>
                    <td>
                        @if ($subquest->is_completed)
                            <i class="fa-solid fa-check-circle" title="{{ __('quests.fields.is_completed') }}"></i>
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

@section('modals')
    @parent
    @include('partials.helper-modal', [
        'id' => 'help-modal',
        'title' => __('crud.actions.help'),
        'textes' => [
            __('quests.hints.quests')
        ]
    ])
@endsection

