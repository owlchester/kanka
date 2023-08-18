<div class="submit-group">
    <input id="submit-mode" type="hidden" value="true"/>
    <div class="join">
        <button class="btn2 join-item btn-primary" id="form-submit-main"
    >{{ __('crud.actions.apply') }}</button>

        <div class="dropdown">
            <button type="button" class="btn2 join-item btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
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
</div>
