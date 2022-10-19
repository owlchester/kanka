<div class="btn-group">
    <input id="submit-mode" type="hidden" value="true"/>
    <button class="btn btn-success" id="form-submit-main" data-target="{{ $target ?? null }}">
        {{ __('crud.save') }}
    </button>
    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li>
            <button type="submit" name="submit" value="save" class="dropdown-item">
                {{ __('crud.save') }}
            </button>
        </li>
        <li>
            <button type="submit" name="submit" value="update" class="dropdown-item">
                {{ __('crud.save_and_update') }}
            </button>
        </li>
        <li>
            <button type="submit" name="submit" value="new" class="dropdown-item">
                {{ __('crud.save_and_new') }}
            </button>
        </li>
        <li>
            <button type="submit" name="submit" value="explore" class="dropdown-item">
                {{ __('maps/markers.actions.save_and_explore') }}
            </button>
        </li>
    </ul>
    <div class="submit-animation" style="display: none;">
        <button class="btn btn-success" disabled><i class="fa-solid fa-spinner fa-spin"></i></button>
    </div>
</div>
