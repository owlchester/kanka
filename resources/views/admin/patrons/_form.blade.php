
{{ csrf_field() }}
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="form-group required">
                    <label>Pledge</label>
                    {!! Form::select('patreon_pledge', array_merge(['' => ''], \App\Models\Patreon::pledges()), null, ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
    </div>
</div>

<button class="btn btn-success" id="form-submit-main" data-unsaved="{{ __('crud.hints.unsaved_changes') }}">{{ trans('crud.save') }}</button>
{!! trans('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous())]) !!}
