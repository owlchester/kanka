<?php /** @var \App\Datagrids\Sorters\DatagridSorter $datagridSorter */?>
@if (!empty($datagridSorter) && auth()->check())
<div class="input-group export-hidden">
    <div class="input-group-addon">
        <i class="fa fa-sort-amount-down" title="{{ __('crud.filters.sorting.helper') }}" data-toggle="tooltip"></i>
    </div>
    <select id="datagrid-simple-sorter" name="{{ $datagridSorter->fieldname() }}" class="form-control" data-url="{{ request()->url() . (!empty($allMembers) ? '?all_members=1' : null) }}">
        <option value=""></option>
        @foreach ($datagridSorter->options(\App\Facades\CampaignLocalization::getCampaign()) as $key => $val)
        <option value="{{ $key . $datagridSorter->direction() }}" @if($datagridSorter->isSelected($key)) selected="selected" @endif>
            {{ __('crud.filters.sorting.asc', ['field' => __($val)]) }}
        </option>

        <option value="{{ $key . $datagridSorter->direction(false) }}" @if($datagridSorter->isSelected($key, false)) selected="selected" @endif>
            {{ __('crud.filters.sorting.desc', ['field' => __($val)]) }}
        </option>
        @endforeach
    </select>
</div>
@endif

