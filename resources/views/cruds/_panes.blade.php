<div class="tab-pane {{ (request()->get('tab') == 'notes' ? ' active' : '') }}" id="notes">
    @include('cruds._notes')
</div>
