<?php /** @var \App\Datagrids\Bulks\Bulk $bulk */ $fieldCount = 0;?>
{!! Form::open(['url' => route('bulk.process', $campaign), 'method' => 'POST']) !!}
<div class="modal fade" id="bulk-edit" tabindex="-1" role="dialog" aria-labelledby="clickConfirmLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content bg-base-100">
            <div class="modal-header">
                <x-dialog.close :modal="true" />
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


                <x-dialog.footer :modal="true">
                    <button class="btn2 btn-primary" type="submit">
                        <x-icon class="save"></x-icon>
                        {{ __('crud.actions.apply') }}
                    </button>
                </x-dialog.footer>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="datagrid-action" value="batch" />
<input type="hidden" name="entity" value="{{ $name }}" />

{!! Form::hidden('mode', $mode) !!}
{!! Form::hidden('models', null, ['id' => 'datagrid-bulk-batch-models']) !!}
{!! Form::close() !!}

