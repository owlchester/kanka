<div class="tab-pane {{ (request()->get('tab') == 'traits' ? ' active' : '') }}" id="form-traits">
    @include('characters.form._traits', ['source' => null])
</div>