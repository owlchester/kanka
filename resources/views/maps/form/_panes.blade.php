<div class="tab-pane {{ (request()->get('tab') == 'form-settings' ? ' active' : '') }}" id="form-settings">
    @include('maps.form._settings')
</div>
