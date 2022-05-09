<div class="form-group">
    <div class="btn-group">
        <input id="submit-mode" type="hidden" value="true"/>
        <button class="btn btn-success" id="form-submit-main" data-target="{{ isset($target) ? $target : null }}">{{ __('crud.save') }}</button>
        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu">
            <li><a href="#" class="form-submit-actions">
                {{ __('crud.save') }}
                <span class="shortcut hidden-xs">CTRL+S</span>
            </a></li>
            <li><a href="#" class="form-submit-actions" data-action="submit-new">
                {{ __('crud.save_and_new') }}
            </a></li>
            <li><a href="#" class="form-submit-actions" data-action="submit-update">
                {{ __('crud.save_and_update') }}
                <span class="shortcut hidden-xs">CTRL+SHIFT+S</span>
            </a></li>
        </ul>
    </div>
    @include('partials.or_cancel')
</div>

