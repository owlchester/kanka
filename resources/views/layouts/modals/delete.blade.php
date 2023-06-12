<!-- The delete confirmation modal, can be configured to show custom text and options -->
<div class="modal fade" id="delete-confirm" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content bg-base-100 rounded-2xl">
            <div class="modal-body text-center">

                <x-dialog.close />

                <h4 class="modal-title">{{ __('crud.delete_modal.title') }}</h4>
                <p class="mt-3">
                    {!! __('crud.delete_modal.description_v2', ['tag' => '<strong><span class="target-name"></span></strong>']) !!}<br />
                    <span class="permanent" style="display: none">
                            {{ __('crud.delete_modal.permanent') }}
                        </span>
                </p>
                <div id="delete-confirm-mirror" class="field-delete-confirm  checkbox" style="display: none">
                    <label>
                        <input type="checkbox" id="delete-confirm-mirror-checkbox" name="delete-mirror">
                        {{ __('entities/relations.delete_mirrored.option') }}
                        <i class="fa-solid fa-question-circle hidden-xs hidden-sm" title="{{ __('entities/relations.delete_mirrored.helper') }}" data-toggle="tooltip" aria-hidden="true"></i>
                    </label>
                    <p class="help-block visible-xs visible-sm">
                        {{ __('entities/relations.delete_mirrored.helper') }}
                    </p>
                </div>
                <div class="mt-3 recoverable" style="display: none">
                    @include('layouts.callouts.recoverable')
                </div>

                <x-dialog.footer :modal="true">
                    <button type="button" class="btn2 btn-error btn-outline delete-confirm-submit px-8 ml-5 rounded-full">
                        <x-icon class="trash"></x-icon>
                        <span class="remove-button-label">{{ __('crud.remove') }}</span>
                    </button>
                </x-dialog.footer>
            </div>
        </div>
    </div>
</div>
