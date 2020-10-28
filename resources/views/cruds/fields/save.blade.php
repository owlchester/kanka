@if (isset($onlySave))
    <button class="btn btn-success" id="form-submit-main" data-unsaved="{{ __('crud.hints.unsaved_changes') }}" data-target="{{ isset($target) ? $target : null }}">{{ trans('crud.save') }}</button>
@else
    <div class="form-group">
        <div class="btn-group">
            <button class="btn btn-success" id="form-submit-main" data-unsaved="{{ __('crud.hints.unsaved_changes') }}" data-target="{{ isset($target) ? $target : null }}">{{ trans('crud.save') }}</button>
            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu {{ isset($disableCancel) ? 'dropdown-menu-right' : '' }}" role="menu">
                <li><a href="#" class="form-submit-actions">
                        {{ trans('crud.save') }}
                        <span class="shortcut hidden-xs">CTRL+S</span>
                    </a></li>
                <li><a href="#" class="form-submit-actions" data-action="submit-new">
                        {{ trans('crud.save_and_new') }}
                </a></li>
                <li><a href="#" class="form-submit-actions" data-action="submit-update">
                        {{ trans('crud.save_and_update') }}
                        <span class="shortcut hidden-xs">CTRL+SHIFT+S</span>
                </a></li>
                @if (empty($model))
                <li><a href="#" class="form-submit-actions" data-action="submit-view">{{ trans('crud.save_and_view') }}</a></li>
                @else
                <li><a href="#" class="form-submit-actions" data-action="submit-close">{{ trans('crud.save_and_close') }}</a></li>
                <li><a href="#" class="form-submit-actions" data-action="submit-copy">{{ trans('crud.save_and_copy') }}</a></li>
                @endif
            </ul>
        </div>
        @if (!isset($disableCancel))
            {!! trans('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous())]) !!}
        @endif
    </div>
@endif
