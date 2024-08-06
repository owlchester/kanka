<form method="post" action="{{ $route }}">
    @csrf
    <input type="hidden" name="_method" value="DELETE" />
    <x-dialog.header>
        {{ __('crud.delete_modal.title') }}
    </x-dialog.header>
    <article>
        <x-grid type="1/1">
        <p class="m-0">
            {!! __('crud.delete_modal.description_v2', ['tag' => '<strong>' . $name . '</strong>']) !!}
        </p>
        @if ($permanent)
            <p class="permanent">
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

        @if (!$permanent)
        <div class="mt-3 recoverable">
            @include('layouts.callouts.recoverable')
        </div>
        @endif
        </x-grid>
    </article>
    <footer class="bg-base-200 flex flex-wrap gap-3 justify-between items-start p-3 md:rounded-b">
        <menu class="flex flex-wrap gap-3 ps-0 ms-0">
            <button autofocus type="button" class="btn2 btn-ghost btn-full" onclick="this.closest('dialog').close('close')">
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
