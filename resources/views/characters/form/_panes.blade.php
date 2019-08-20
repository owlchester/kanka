<div class="tab-pane {{ (request()->get('tab') == 'traits' ? ' active' : '') }}" id="form-traits">
    @include('characters.form._traits')
</div>
<div class="tab-pane {{ (request()->get('tab') == 'organisations' ? ' active' : '') }}" id="form-organisations">
    @include('characters.form._organisations')
</div>