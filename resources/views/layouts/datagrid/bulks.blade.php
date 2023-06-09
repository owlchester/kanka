<?php /** @var \App\Renderers\DatagridRenderer2 $datagrid */
use App\Facades\Datagrid;
$hasOthers = false;
?>
<div class="dropdown datagrid-bulk-actions">
    <a class="dropdown-toggle btn2 btn-disabled" data-toggle="dropdown" aria-expanded="false" data-tree="escape">
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
<a href="#" class="btn2 btn-disabled datagrid-spinner" style="display:none">
    <i class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i>
</a>
<input type="hidden" name="action" value="" />

@section('modals')
    @parent
    <div class="modal fade" id="datagrid-bulk-delete" tabindex="-1" role="dialog" aria-labelledby="clickConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content bg-base-100 rounded-2xl">
                <div class="modal-body text-center">

                    <x-dialog.close />
                    <h4 class="modal-title">{{ __('crud.delete_modal.title') }}</h4>

                    <p class="mt-3">
                        {{ __('crud.bulk.delete.warning') }}<br />
                        {{ __('crud.delete_modal.permanent') }}
                    </p>

                    <x-dialog.footer :modal="true">
                        <button type="button" class="btn2 btn-error btn-outline" id="datagrid-action-confirm">
                            <x-icon class="trash"></x-icon>
                            <span class="remove-button-label">{{ __('crud.remove') }}</span>
                        </button>
                    </x-dialog.footer>
                </div>
            </div>
        </div>
    </div>
@endsection
