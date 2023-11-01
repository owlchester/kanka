{!! Form::open(['url' => route('bulk.process', $campaign), 'method' => 'POST']) !!}
<div class="modal fade" id="bulk-ajax" tabindex="-1" role="dialog" aria-labelledby="clickConfirmLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content bg-base-100">
        </div>
    </div>
</div>
{!! Form::hidden('models', null, ['id' => 'datagrid-bulk-ajax-models']) !!}
{!! Form::hidden('mode', $mode) !!}
{!! Form::close() !!}
