<div class="tab-pane {{ (request()->get('tab') == 'form-settings' ? ' active' : '') }}" id="form-settings">
    @include('maps.form._settings', ['source' => null])
</div>
<div class="tab-pane {{ (request()->get('tab') == 'form-layers' ? ' active' : '') }}" id="form-layers">
    @include('maps.form._layers', ['source' => null])
</div>
<div class="tab-pane {{ (request()->get('tab') == 'form-groups' ? ' active' : '') }}" id="form-groups">
    @include('maps.form._groups', ['source' => null])
</div>
<div class="tab-pane {{ (request()->get('tab') == 'form-markers' ? ' active' : '') }}" id="form-markers">
    @include('maps.form._markers', ['source' => null])
</div>
