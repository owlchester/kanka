<?php
/** @var \App\Models\Quest[] $subquests */
$subquests = $model->quests()->has('quest')->orderBy('name', 'ASC')->paginate();
if($subquests->count() == 0) {
    return;
}
?>

@inject('dateRenderer', 'App\Renderers\DateRenderer')

<div class="box box-solid quest-subquests" id="subquests">
    <div class="box-header with-border">
        <h3 class="box-title">{{ __('quests.fields.quests') }}</h3>
        <div class="box-tools">
            <a href="#" class="btn btn-box-tool" data-toggle="modal" data-target="#help-modal">
                <i class="fa fa-question-circle"></i> {{ __('crud.actions.help') }}
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
                        <a class="entity-image" style="background-image: url('{{ $subquest->getImageUrl(40) }}');" title="{{ $subquest->name }}" href="{{ route('quests.show', $subquest->id) }}"></a>
                    </td>
                    <td>
                        @if ($subquest->is_private)
                            <i class="fas fa-lock" title="{{ __('crud.is_private') }}" data-toggle="tooltip"></i>
                        @endif
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

@section('modals')
    @parent
    <div class="modal fade" id="help-modal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">
                        {{ __('crud.actions.help') }}
                    </h4>
                </div>
                <div class="modal-body">
                    <p>
                        {{ __('quests.hints.quests') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

