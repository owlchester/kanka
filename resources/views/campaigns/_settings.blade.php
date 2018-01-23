
<p>{{ trans('campaigns.settings.helper') }}</p>


{!! Form::model($campaign->setting, ['method' => 'POST', 'route' => ['campaigns.settings.save', $campaign->id]]) !!}
<div class="form-group">
    {!! Form::hidden('characters', 0) !!}
    <label>{!! Form::checkbox('characters') !!}
        {{ trans('entities.characters') }}
    </label>
</div>
<div class="form-group">
    {!! Form::hidden('events', 0) !!}
    <label>{!! Form::checkbox('events') !!}
        {{ trans('entities.events') }}
    </label>
</div>
<div class="form-group">
    {!! Form::hidden('families', 0) !!}
    <label>{!! Form::checkbox('families') !!}
        {{ trans('entities.families') }}
    </label>
</div>
<div class="form-group">
    {!! Form::hidden('items', 0) !!}
    <label>{!! Form::checkbox('items') !!}
        {{ trans('entities.items') }}
    </label>
</div>
<div class="form-group">
    {!! Form::hidden('journals', 0) !!}
    <label>{!! Form::checkbox('journals') !!}
        {{ trans('entities.journals') }}
    </label>
</div>
<div class="form-group">
    {!! Form::hidden('locations', 0) !!}
    <label>{!! Form::checkbox('locations') !!}
        {{ trans('entities.locations') }}
    </label>
</div>
<div class="form-group">
    {!! Form::hidden('notes', 0) !!}
    <label>{!! Form::checkbox('notes') !!}
        {{ trans('entities.notes') }}
    </label>
</div>
<div class="form-group">
    {!! Form::hidden('organisations', 0) !!}
    <label>{!! Form::checkbox('organisations') !!}
        {{ trans('entities.organisations') }}
    </label>
</div>
<div class="form-group">
    {!! Form::hidden('quests', 0) !!}
    <label>{!! Form::checkbox('quests') !!}
        {{ trans('entities.quests') }}
    </label>
</div>

<div class="form-group">
    <button class="btn btn-success">{{ trans('crud.save') }}</button>
</div>

{!! Form::close() !!}