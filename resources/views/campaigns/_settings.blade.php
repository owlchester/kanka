
<p>You can easily disable elements from your campaign that will be hidden. If you have already created elements in the categories you disable, they won't be deleted, just hidden.</p>


{!! Form::model($campaign->setting, ['method' => 'POST', 'route' => ['campaigns.settings.save', $campaign->id]]) !!}
<div class="form-group">
    {!! Form::hidden('characters', 0) !!}
    <label>{!! Form::checkbox('characters') !!}
        {{ trans('campaigns.settings.fields.characters') }}
    </label>
</div>
<div class="form-group">
    {!! Form::hidden('events', 0) !!}
    <label>{!! Form::checkbox('events') !!}
        {{ trans('campaigns.settings.fields.events') }}
    </label>
</div>
<div class="form-group">
    {!! Form::hidden('families', 0) !!}
    <label>{!! Form::checkbox('families') !!}
        {{ trans('campaigns.settings.fields.families') }}
    </label>
</div>
<div class="form-group">
    {!! Form::hidden('items', 0) !!}
    <label>{!! Form::checkbox('items') !!}
        {{ trans('campaigns.settings.fields.items') }}
    </label>
</div>
<div class="form-group">
    {!! Form::hidden('journals', 0) !!}
    <label>{!! Form::checkbox('journals') !!}
        {{ trans('campaigns.settings.fields.journals') }}
    </label>
</div>
<div class="form-group">
    {!! Form::hidden('locations', 0) !!}
    <label>{!! Form::checkbox('locations') !!}
        {{ trans('campaigns.settings.fields.locations') }}
    </label>
</div>
<div class="form-group">
    {!! Form::hidden('notes', 0) !!}
    <label>{!! Form::checkbox('notes') !!}
        {{ trans('campaigns.settings.fields.notes') }}
    </label>
</div>
<div class="form-group">
    {!! Form::hidden('organisations', 0) !!}
    <label>{!! Form::checkbox('organisations') !!}
        {{ trans('campaigns.settings.fields.organisations') }}
    </label>
</div>
<div class="form-group">
    {!! Form::hidden('quests', 0) !!}
    <label>{!! Form::checkbox('quests') !!}
        {{ trans('campaigns.settings.fields.quests') }}
    </label>
</div>

<div class="form-group">
    <button class="btn btn-success">{{ trans('crud.save') }}</button>
</div>

{!! Form::close() !!}