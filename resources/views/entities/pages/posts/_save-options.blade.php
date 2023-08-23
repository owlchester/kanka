<div class="join">
    <input id="submit-mode" type="hidden" value="true"/>
    <button class="btn2 btn-sm btn-primary join-item" id="form-submit-main" data-target="{{ isset($target) ? $target : null }}">{{ __('crud.save') }}</button>
    <div class="dropdown">
        <button type="button" class="btn2 btn-sm btn-primary join-item dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-right" role="menu">
            <li>
                <a href="#" class="form-submit-actions flex">
                    <span class="flex-grow">{{ __('crud.save') }}</span>
                    <span class="keyboard-shortcut flex-none ml-2 hidden sm:inline">CTRL+S</span>
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
                    <span class="keyboard-shortcut flex-none ml-2 hidden sm:inline">CTRL+SHIFT+S</span>
                </a>
            </li>
        </ul>
    </div>
</div>

