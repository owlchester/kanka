<form method="GET" action="{{ $route }}" class="flex-0 w-fit! datagrid-search inline-block" role="form">
    <div class="field field-search">
        <input type="text" name="term" value="{{ $term ?? null }}" placeholder="{{ __('crud.search') }}" />
    </div>
</form>
