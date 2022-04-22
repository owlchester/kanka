<?php /** @var \App\Renderers\DatagridRenderer2 $datagrid */
use App\Facades\Datagrid;
$hasOthers = false;
?>
<div class="dropdown datagrid-bulk-actions">
    <a class="dropdown-toggle btn btn-default disabled" data-toggle="dropdown" aria-expanded="false" data-tree="escape">
        {{ __('crud.actions.bulk_actions') }}
        <i class="fa-solid fa-caret-down"></i>
    </a>
    <ul class="dropdown-menu dropdown-menu-right" role="menu">

        @foreach (\App\Facades\Datagrid::bulks() as $bulk)
            @if ($bulk === \App\Renderers\Layouts\Layout::ACTION_DELETE)
                @if ($hasOthers) <li class="divider"></li> @endif
            <li>
                <a href="#" class="text-red datagrid-submit" data-action="delete">
                    <i class="fa-solid fa-trash"></i> {{ __('crud.remove') }}
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
<a href="#" class="btn btn-default btn-disabled datagrid-spinner" style="display:none">
    <i class="fa-solid fa-spinner fa-spin"></i>
</a>
<input type="hidden" name="action" value="" />

@section('modals')
    @parent
    <div class="modal modal-danger fade" id="datagrid-bulk-delete" tabindex="-1" role="dialog" aria-labelledby="clickConfirmLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.click_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="clickModalLabel">{{ __('crud.bulk.delete.title') }}</h4>
                </div>
                <div class="modal-body">
                    {{ __('crud.bulk.delete.warning') }}
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">{{ __('crud.delete_modal.close') }}</button>

                    <a class="btn btn-outline" id="datagrid-action-confirm">{{ __('crud.click_modal.confirm') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
