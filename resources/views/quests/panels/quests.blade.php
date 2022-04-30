<?php
$datagridOptions = [
    $model,
    'init' => 1
];
?>

<div class="box box-solid quest-subquests" id="subquests">
    <div class="box-header with-border">
        <h3 class="box-title">{{ __('quests.fields.quests') }}</h3>
        <div class="box-tools">
            <a href="#" class="btn btn-box-tool" data-toggle="modal" data-target="#help-modal">
                <i class="fa-solid fa-question-circle"></i> {{ __('crud.actions.help') }}
            </a>
        </div>
    </div>
    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table', ['datagridUrl' => route('quests.quests', $datagridOptions)])
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
