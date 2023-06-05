<?php /** @var \App\Datagrids\Bulks\Bulk $bulk */ $fieldCount = 0;?>
{!! Form::open(['url' => route('bulk.process'), 'method' => 'POST']) !!}
<div class="modal fade" id="bulk-edit" tabindex="-1" role="dialog" aria-labelledby="clickConfirmLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <x-dialog.close />
                <h4 class="modal-title" id="clickModalLabel">{{ __('crud.bulk.edit.title') }}</h4>
            </div>
            <div class="modal-body">
                <x-grid>
                @foreach ($bulk->fields() as $field)
                    @php $trimmed = \Illuminate\Support\Str::beforeLast($field, '_id'); @endphp
                    {!! $fieldCount % 2 === 0 ? '' : null !!}
                    @include('cruds.fields.' . $trimmed, [
                        'trans' => $name,
                        'base' => $model,
                        'bulk' => true,
                        'parent' => \Illuminate\Support\Str::plural($trimmed) == $name,
                        'allowNew' => false,
                        'dropdownParent' => '#bulk-edit',
                        'route' => null,
                    ])
                    @php $fieldCount++; @endphp
                @endforeach
                </x-grid>
            </div>
            <div class="modal-footer">
                <a href="#" class="pull-left" data-dismiss="modal">{{ __('crud.cancel') }}</a>
                <button class="btn btn-success" type="submit">
                    <x-icon class="save"></x-icon>
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

