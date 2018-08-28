<div class="col-md-<?=(isset($saveColLength) ? $saveColLength : 12)?>">
    <div class="form-group">
        <div class="btn-group">
            <button class="btn btn-success">{{ trans('crud.save') }}</button>
            <button class="btn btn-default" name="submit-new">{{ trans('crud.save_and_new') }}</button>
            <button class="btn btn-default" name="submit-update">{{ trans('crud.save_and_update') }}</button>
            @if (empty($model))
                <button class="btn btn-default" name="submit-view">{{ trans('crud.save_and_view') }}</button>
                @else
                <button class="btn btn-default" name="submit-close">{{ trans('crud.save_and_close') }}</button>
            @endif
        </div>
        {!! trans('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous())]) !!}
    </div>
</div>