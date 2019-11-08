<?php /** @var \App\Datagrids\Bulks\Bulk $bulk */?>
@if (isset($bulk))

    {!! Form::open(['url' => route('bulk.process'), 'method' => 'POST']) !!}
    <div class="modal fade" id="bulk-edit" tabindex="-1" role="dialog" aria-labelledby="clickConfirmLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.click_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="clickModalLabel">{{ __('crud.bulk.edit.title') }}</h4>
                </div>
                <div class="modal-body">
                    @foreach ($bulk->fields() as $field)
                        @include('cruds.fields.' . rtrim($field, '_id'), ['trans' => $name, 'enableNew' => false, 'base' => $model, 'bulk' => true])
                    @endforeach
                </div>
                <div class="modal-footer">
                    <a href="#" class="pull-left" data-dismiss="modal">{{ __('crud.cancel') }}</a>
                    <button class="btn btn-primary" type="submit" name="datagrid-action" value="batch">{{ __('crud.click_modal.confirm') }}</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::hidden('entity', $name) !!}
    {!! Form::hidden('models', null, ['id' => 'datagrid-bulk-batch-models']) !!}
    {!! Form::close() !!}
@endif