
<li class="{{ (request()->get('tab') == 'notes' ? ' active' : '') }}" data-tab="secrets">
    <a href="#notes" title="{{ trans('crud.tabs.notes') }}">
        <i class="fa fa-file"></i> <span class="hidden-sm hidden-xs">{{ trans('crud.tabs.notes') }}</span>
    </a>
</li>
