<div class="tab-pane {{ (request()->get('tab') == 'form-settings' ? ' active' : '') }}" id="form-settings">
    @include('maps.form._settings', ['source' => null])
</div>
<div class="tab-pane {{ (request()->get('tab') == 'form-markers' ? ' active' : '') }}" id="form-markers">
    @include('maps.form._markers', ['source' => null])
</div>
