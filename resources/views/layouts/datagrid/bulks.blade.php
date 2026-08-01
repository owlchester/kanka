<?php
use App\Facades\Datagrid;
$hasOthers = false;
?>
<div class="dropdown datagrid-bulk-actions">
    <a class="btn2 btn-disabled break-keep" data-dropdown aria-expanded="false" data-tree="escape">
        {{ __('crud.bulk.buttons.label') }}
        <x-icon class="fa-regular fa-caret-down" />
    </a>
    <div class="dropdown-menu hidden" role="menu">
        @foreach (\App\Facades\Datagrid::bulks() as $bulk)
            @if ($bulk === \App\Renderers\Layouts\Layout::ACTION_EDIT)
                <x-dropdowns.item link="#" css="datagrid-bulk" :data="['action' => 'edit']" icon="pencil">
                    {{ __('crud.bulk.actions.modify') }}
                </x-dropdowns.item>
            @elseif ($bulk === \App\Renderers\Layouts\Layout::ACTION_DELETE)
                @if ($hasOthers) <x-dropdowns.divider /> @endif
                <x-dropdowns.item link="#" css="text-error-content text-error hover:bg-error datagrid-submit" :data="['action' => 'delete']" icon="trash">
                    {{ __('crud.remove') }}
                </x-dropdowns.item>
            @elseif (is_array($bulk))
                @php $hasOthers = true; @endphp
                <x-dropdowns.item link="#" css="datagrid-submit" :data="['action' => $bulk['action']]" :icon="$bulk['icon'] ?? null">
                    {{ __($bulk['label']) }}
                </x-dropdowns.item>
            @endif
        @endforeach
    </div>
</div>
<input type="hidden" name="action" value="" />

@section('modals')
    @parent
    @include('layouts.datagrid.bulks._delete-dialog')
@endsection
