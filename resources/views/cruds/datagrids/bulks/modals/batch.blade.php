<?php /** @var \App\Datagrids\Bulks\Bulk $bulk */ $fieldCount = 0;?>
{!! Form::open(['url' => route('bulk.process'), 'method' => 'POST']) !!}
<div class="modal fade" id="bulk-edit" tabindex="-1" role="dialog" aria-labelledby="clickConfirmLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.click_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="clickModalLabel">{{ __('crud.bulk.edit.title') }}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                @foreach ($bulk->fields() as $field)
                    @php $trimmed = \Illuminate\Support\Str::beforeLast($field, '_id'); @endphp
                    {!! $fieldCount % 2 === 0 ? '</div><div class="row">' : null !!}
                        <div class="col-md-6">
                    @include('cruds.fields.' . $trimmed, [
                        'trans' => $name,
                        'base' => $model,
                        'bulk' => true,
                        'parent' => \Illuminate\Support\Str::plural($trimmed) == $name,
                        'allowNew' => false,
                        'dropdownParent' => '#bulk-edit',
                        'route' => null,
                    ])
                    </div>
                    @php $fieldCount++; @endphp
                @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="pull-left" data-dismiss="modal">{{ __('crud.cancel') }}</a>
                <button class="btn btn-success" type="submit">
                    <i class="fa-solid fa-save" aria-hidden="true"></i>
                    {{ __('crud.actions.apply') }}
                </button>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="datagrid-action" value="batch" />
<input type="hidden" name="entity" value="{{ $name }}" />

{!! Form::hidden('mode', $mode) !!}
{!! Form::hidden('models', null, ['id' => 'datagrid-bulk-batch-models']) !!}
{!! Form::close() !!}

