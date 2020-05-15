<div class="tab-pane {{ (request()->get('tab') == 'entity' ? ' active' : '') }}" id="entity">
    @include('menu_links.form._entity', ['source' => null])
</div>
<div class="tab-pane {{ (request()->get('tab') == 'type' ? ' active' : '') }}" id="type">
    @include('menu_links.form._type', ['source' => null])
</div>
