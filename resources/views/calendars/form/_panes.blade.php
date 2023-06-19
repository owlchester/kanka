<div class="tab-pane pane-calendar {{ (request()->get('tab') == 'form-calendar' ? ' active' : '') }}" id="form-calendar">
    @include('calendars.form._calendar', ['source' => $source])
</div>
<div class="tab-pane pane-months {{ (request()->get('tab') == 'form-months' ? ' active' : '') }}" id="form-months">
    @include('calendars.form._months', ['source' => $source])
</div>
<div class="tab-pane pane-weeks {{ (request()->get('tab') == 'form-weeks' ? ' active' : '') }}" id="form-weeks">
    @include('calendars.form._weeks', ['source' => $source])
</div>
<div class="tab-pane pane-moons {{ (request()->get('tab') == 'form-moons' ? ' active' : '') }}" id="form-moons">
    @include('calendars.form._moons', ['source' => $source])
</div>
<div class="tab-pane pane-seasons {{ (request()->get('tab') == 'form-seasons' ? ' active' : '') }}" id="form-seasons">
    @include('calendars.form._seasons', ['source' => $source])
</div>
