@if (
    !request()->ajax()
    && auth()->check()
    && auth()->user()->entry_form_layout !== 'modern'
    && \App\Services\TutorialService::eligibleForV4(auth()->user(), 'v4_entry_form_layout')
)
    <div id="v4-entry-layout-prompt" class="bg-base-100 rounded-xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex items-start gap-3">
            <div class="size-9 rounded-lg bg-primary/10 text-primary flex items-center justify-center shrink-0">
                <x-icon class="fa-regular fa-pen-to-square" />
            </div>
            <div class="flex flex-col gap-0.5">
                <p class="font-semibold text-sm m-0">{{ __('tutorials/v4.entry_form.title') }}</p>
                <p class="text-sm text-base-content/75 m-0">{{ __('tutorials/v4.entry_form.body') }}</p>
            </div>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <button
                type="button"
                class="btn2 btn-primary btn-sm cursor-pointer"
                data-v4-enable-modern="{{ route('settings.appearance.modern-entry-form') }}"
            >
                {{ __('tutorials/v4.entry_form.actions.try') }}
            </button>
            <button
                type="button"
                class="btn2 btn-ghost btn-sm cursor-pointer"
                data-dismiss="tutorial"
                data-target="#v4-entry-layout-prompt"
                data-url="{{ route('tutorials.dismiss', ['code' => 'v4_entry_form_layout']) }}"
            >
                {{ __('tutorials/v4.entry_form.actions.dismiss') }}
            </button>
        </div>
    </div>
@endif
