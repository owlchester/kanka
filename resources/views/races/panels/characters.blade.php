<?php
/**
 * @var \App\Models\Race $model
 * @var \App\Models\Character $character
 */

$allMembers = true;
$datagridOptions = [
    $model,
    'init' => 1
];
if (request()->has('race_id')) {
    $datagridOptions['race_id'] = (int) $model->id;
    $allMembers = true;
}
?>
<div class="box box-solid" id="race-characters">
    <div class="box-header with-border">
        <h3 class="box-title">{{ __('races.show.tabs.characters') }}</h3>

        <div class="box-tools pull-right">
            <a href="#" class="btn btn-box-tool" data-toggle="modal" data-target="#help-modal">
                <i class="fa-solid fa-question-circle"></i> {{ __('crud.actions.help') }}
            </a>

            @if (request()->has('race_id'))
                <a href="{{ route('races.show', $model) }}" class="btn btn-box-tool">
                    <i class="fa-solid fa-filter"></i> {{ __('crud.filters.all') }} ({{ $model->allCharacters()->count() }})
                </a>
            @else
                <a href="{{ route('races.show', [$model, 'race_id' => $model->id]) }}" class="btn btn-box-tool">
                    <i class="fa-solid fa-filter"></i> {{ __('crud.filters.direct') }} ({{ $model->characters()->count() }})
                </a>
            @endif
        </div>
    </div>
    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table', ['datagridUrl' => route('races.characters', $datagridOptions)])
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
                        {{ __('races.characters.helpers.' . ($allMembers ? 'all_' : null) . 'characters') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
