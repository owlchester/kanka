<?php /** @var \App\Datagrids\Sorters\DatagridSorter $datagridSorter */?>
@if (!empty($datagridSorter) && auth()->check())
<div class="input-group">
    <div class="input-group-addon">
        <i class="fa fa-sort-amount-down" title="{{ __('crud.filters.sorting.helper') }}" data-toggle="tooltip"></i>
    </div>
    <select id="datagrid-simple-sorter" name="{{ $datagridSorter->fieldname() }}" class="form-control" data-url="{{ request()->url() . (!empty($allMembers) ? '?all_members=1' : (isset($filter) ? $filter : null)) . (isset($target) ? $target : null) }}">
        <option value=""></option>
@foreach ($datagridSorter->options(\App\Facades\CampaignLocalization::getCampaign()) as $key => $val)
    @if ($key === 'today')
        <option value="{{ $key . $datagridSorter->direction() }}" @if($datagridSorter->isSelected($key)) selected="selected" @endif>
            {{ __('calendars.sorters.after') }}
        </option>
        <option value="{{ $key . $datagridSorter->direction(false) }}" @if($datagridSorter->isSelected($key, false)) selected="selected" @endif>
            {{ __('calendars.sorters.before') }}
        </option>
    @else
        <option value="{{ $key . $datagridSorter->direction() }}" @if($datagridSorter->isSelected($key)) selected="selected" @endif>
            {{ __('crud.filters.sorting.asc', ['field' => __($val)]) }}
        </option>

        <option value="{{ $key . $datagridSorter->direction(false) }}" @if($datagridSorter->isSelected($key, false)) selected="selected" @endif>
            {{ __('crud.filters.sorting.desc', ['field' => __($val)]) }}
        </option>
    @endif
@endforeach
    </select>
</div>
@endif

