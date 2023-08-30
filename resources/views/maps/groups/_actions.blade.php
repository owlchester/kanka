<div class="join float-right">
    <input id="submit-mode" type="hidden" value="true"/>
    <button class="btn2 btn-primary join-item btn-xm" id="form-submit-main" data-target="{{ $target ?? null }}">
        {{ __('crud.save') }}
    </button>
    <div class="dropdown">
        <button type="button" class="btn2 btn-primary join-item dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-right" role="menu">
            <li>
                <a href="#" class="form-submit-actions flex">
                    <span class="flex-grow">{{ __('crud.save') }}</span>
                </a>
            </li>
            <li>
                <a href="#" class="form-submit-actions flex" data-action="submit-new">
                    <span class="flex-grow">{{ __('crud.save_and_new') }}</span>
                </a>
            </li>
            <li>
                <a href="#" class="form-submit-actions flex" data-action="submit-update">
                    <span class="flex-grow">{{ __('crud.save_and_update') }}</span>
                </a>
            </li>
            <li>
                <a href="#" class="form-submit-actions flex" data-action="submit-explore">
                    <span class="flex-grow">
                        {{ __('maps/markers.actions.save_and_explore') }}
                    </span>
                </a>
            </li>
        </ul>
    </div>
</div>
