<form method="post" action="{{ $route }}">
    @csrf
    <input type="hidden" name="_method" value="DELETE" />
    <x-dialog.header>
        {{ __('confirm.delete.title') }}
    </x-dialog.header>
    <x-dialog.article>
        <x-grid type="1/1">
        <p class="text-neutral-content">
            {!! __('confirm.delete.helper', ['name' => '<span class="font-bold">' . $name . '</span>']) !!}
        </p>
        @if ($permanent)
            <p class="permanent text-neutral-content">
                {{ __('crud.delete_modal.permanent') }}
            </p>
        @endif

        @if ($mirrored)
        <div class="field field-delete-confirm checkbox">
            <label>
                <input type="checkbox" id="delete-confirm-mirror-checkbox" name="delete-mirror">
                {{ __('entities/relations.delete_mirrored.option') }}
                <x-helpers.tooltip :title="__('entities/relations.delete_mirrored.helper')" />
            </label>
            <p class="text-neutral-content md:hidden">
                {{ __('entities/relations.delete_mirrored.helper') }}
            </p>
        </div>
        @endif

            @includeWhen(!$permanent, 'layouts.callouts.recoverable')

        </x-grid>
    </x-dialog.article>
    <footer class="flex flex-wrap gap-2 justify-between items-start p-4 md:p-6">
        <menu class="flex flex-wrap gap-3 ps-0 ms-0">
            <button autofocus type="button" class="btn2 btn-outline" onclick="this.closest('dialog').close('close')">
                {{ __('crud.cancel') }}
            </button>
        </menu>
        <menu class="flex flex-wrap gap-3 ps-0">
            <button type="submit" class="btn2 btn-error btn-outline delete-confirm-submit px-8 ml-5 rounded-full">
                <x-icon class="trash" />
                {{ __('crud.remove') }}
            </button>
        </menu>
    </footer>
</form>
