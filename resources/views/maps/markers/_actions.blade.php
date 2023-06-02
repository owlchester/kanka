<div class="submit-group float-right">
    <input id="submit-mode" type="hidden" value="true"/>
    <div class="btn-group">
        <button class="btn btn-success" id="form-submit-main"
            data-action="{{ request()->from == 'explore' ? 'submit-explore' : null }}"
            data-target="{{ isset($target) ? $target : null }}">{{ __('crud.save') }}
        </button>
        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown"
            aria-expanded="false">
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-right" role="menu">
            <li>
                <a href="#" class="dropdown-item form-submit-actions">
                    {{ __('crud.save') }}
                </a>
            </li>
            <li>
                <a href="#" class="dropdown-item form-submit-actions" data-action="submit-update">
                    {{ __('crud.save_and_update') }}
                </a>
            </li>
            <li>
                <a href="#" class="dropdown-item form-submit-actions" data-action="submit-explore">
                    {{ __('maps/markers.actions.save_and_explore') }}
                </a>
            </li>
        </ul>
    </div>
</div>
<div class="submit-animation" style="display: none;">
    <button class="btn btn-success" disabled><i class="fa-solid fa-spinner fa-spin"></i></button>
</div>
