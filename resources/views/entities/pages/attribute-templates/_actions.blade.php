<div class="submit-group">
    <input id="submit-mode" type="hidden" value="true"/>
    <div class="btn-group">
        <button class="btn btn-success ml-5 rounded-full px-8 form-submit-actions" id="form-submit-main"
        data-action="{{ request()->from == 'explore' ? 'submit-explore' : null }}"
    >{{ __('crud.actions.apply') }}</button>
        
        <button type="button" class="btn btn-success rounded-full dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-right" role="menu">
            <li>
                <a href="#" class="dropdown-item form-submit-actions">
                {{ __('crud.actions.apply') }}
                </a>
            </li>
            <li>
                <a href="#" class="dropdown-item form-submit-actions" data-action="submit-update">
                {{ __('entities/attributes.actions.save_and_edit') }}
                </a>
            </li>
            <li>
                <a href="#" class="dropdown-item form-submit-actions" data-action="submit-story">
                    {{ __('entities/attributes.actions.save_and_story') }}
                </a>
            </li>
        </ul>
    </div>
</div>
<div class="submit-animation" style="display: none;">
    <button class="btn btn-success" disabled><i class="fa-solid fa-spinner fa-spin"></i></button>
</div>
