<?php /** @var \App\Renderers\DatagridRenderer2 $datagrid */
use App\Facades\Datagrid;
$hasOthers = false;
?>
<div class="dropdown datagrid-bulk-actions">
    <a class="dropdown-toggle btn2 btn-disabled break-keep" data-toggle="dropdown" aria-expanded="false" data-tree="escape">
        {{ __('crud.bulk.buttons.label') }}
        <x-icon class="fa-solid fa-caret-down"></x-icon>
    </a>
    <ul class="dropdown-menu" role="menu">
        @foreach (\App\Facades\Datagrid::bulks() as $bulk)
            @if ($bulk === \App\Renderers\Layouts\Layout::ACTION_EDIT)
                <li>
                    <a href="#" class="datagrid-bulk" data-action="edit">
                        <x-icon class="pencil"></x-icon>
                        {{ __('crud.bulk.actions.edit') }}
                    </a>
                </li>
            @elseif ($bulk === \App\Renderers\Layouts\Layout::ACTION_DELETE)
                @if ($hasOthers) <li class="divider"></li> @endif
            <li>
                <a href="#" class="text-red datagrid-submit" data-action="delete">
                    <x-icon class="trash"></x-icon> {{ __('crud.remove') }}
                </a>
            </li>
            @elseif (is_array($bulk))
                @php $hasOthers = true; @endphp
            <li>
                <a href="#" class="datagrid-submit" data-action="{{ $bulk['action'] }}">
                    @if (!empty($bulk['icon'])) <i class="{{ $bulk['icon'] }}"></i>@endif
                    {{ __($bulk['label']) }}
                </a>
            </li>
            @endif
        @endforeach
    </ul>
</div>
<a href="#" class="btn2 btn-disabled datagrid-spinner text-lg" style="display:none">
    <x-icon class="load" />
</a>
<input type="hidden" name="action" value="" />

@section('modals')
    @parent
    <x-dialog id="datagrid-bulk-delete" :title="__('crud.delete_modal.title')">
        <x-grid type="1/1">
            <p class="m-0">
                {{ __('crud.bulk.delete.warning') }}</p>
            <p>
                {{ __('crud.delete_modal.permanent') }}
            </p>
        </x-grid>

        <x-dialog.footer>
            <button type="button" class="btn2 btn-error btn-outline" id="datagrid-action-confirm">
                <x-icon class="trash"></x-icon>
                <span class="remove-button-label">{{ __('crud.remove') }}</span>
            </button>
        </x-dialog.footer>
    </x-dialog>
@endsection
