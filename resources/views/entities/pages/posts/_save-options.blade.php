<div class="form-group">
    <div class="btn-group">
        <input id="submit-mode" type="hidden" value="true"/>
        <button class="btn btn-success" id="form-submit-main" data-target="{{ isset($target) ? $target : null }}">{{ __('crud.save') }}</button>
        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-right" role="menu">
            <li>
                <a href="#" class="form-submit-actions flex">
                    <span class="flex-grow">{{ __('crud.save') }}</span>
                    <span class="keyboard-shortcut flex-none ml-2 hidden-xs">CTRL+S</span>
                </a>
            </li>
            <li>
                <a href="#" class="form-submit-actions" data-action="submit-new">
                    {{ __('crud.save_and_new') }}
                </a>
            </li>
            <li>
                <a href="#" class="form-submit-actions flex" data-action="submit-update">
                    <span class="flex-grow">{{ __('crud.save_and_update') }}</span>
                    <span class="keyboard-shortcut flex-none ml-2 hidden-xs">CTRL+SHIFT+S</span>
                </a>
            </li>
        </ul>
    </div>
</div>

