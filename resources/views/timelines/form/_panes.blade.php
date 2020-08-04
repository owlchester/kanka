<div class="tab-pane {{ (request()->get('tab') == 'form-eras' ? ' active' : '') }}" id="form-eras">
    @include('timelines.form._eras', ['source' => $source])
</div>
