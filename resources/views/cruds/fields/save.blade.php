<div class="col-md-<?=(isset($saveColLength) ? $saveColLength : 12)?>">
    <div class="form-group">
        <button class="btn btn-success">{{ trans('crud.save') }}</button>
        <button class="btn btn-default" name="submit-new">{{ trans('crud.save_and_new') }}</button>
        {!! trans('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous())]) !!}
    </div>
</div>