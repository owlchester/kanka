
<div class="box box-flat">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ trans('campaigns.show.tabs.settings') }}
        </h2>

        <p class="help-block">{{ trans('campaigns.settings.helper') }}</p>

        {!! Form::model($campaign->setting, ['method' => 'POST', 'route' => ['campaigns.settings.save', $campaign->id]]) !!}
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::hidden('calendars', 0) !!}
                    <label>{!! Form::checkbox('calendars') !!}
                        {{ trans('entities.calendars') }}
                    </label>
                    <p class="help-block">{{ trans('campaigns.settings.helpers.calendars') }}</p>
                </div>
                <div class="form-group">
                    {!! Form::hidden('characters', 0) !!}
                    <label>{!! Form::checkbox('characters') !!}
                        {{ trans('entities.characters') }}
                    </label>
                    <p class="help-block">{{ trans('campaigns.settings.helpers.characters') }}</p>
                </div>
                <div class="form-group">
                    {!! Form::hidden('events', 0) !!}
                    <label>{!! Form::checkbox('events') !!}
                        {{ trans('entities.events') }}
                    </label>
                    <p class="help-block">{{ trans('campaigns.settings.helpers.events') }}</p>
                </div>
                <div class="form-group">
                    {!! Form::hidden('families', 0) !!}
                    <label>{!! Form::checkbox('families') !!}
                        {{ trans('entities.families') }}
                    </label>
                    <p class="help-block">{{ trans('campaigns.settings.helpers.families') }}</p>
                </div>
                <div class="form-group">
                    {!! Form::hidden('menu_links', 0) !!}
                    <label>{!! Form::checkbox('menu_links') !!}
                        {{ trans('entities.menu_links') }}
                    </label>
                    <p class="help-block">{{ trans('campaigns.settings.helpers.menu_links') }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::hidden('items', 0) !!}
                    <label>{!! Form::checkbox('items') !!}
                        {{ trans('entities.items') }}
                    </label>
                    <p class="help-block">{{ trans('campaigns.settings.helpers.items') }}</p>
                </div>
                <div class="form-group">
                    {!! Form::hidden('journals', 0) !!}
                    <label>{!! Form::checkbox('journals') !!}
                        {{ trans('entities.journals') }}
                    </label>
                    <p class="help-block">{{ trans('campaigns.settings.helpers.journals') }}</p>
                </div>
                <div class="form-group">
                    {!! Form::hidden('locations', 0) !!}
                    <label>{!! Form::checkbox('locations') !!}
                        {{ trans('entities.locations') }}
                    </label>
                    <p class="help-block">{{ trans('campaigns.settings.helpers.locations') }}</p>
                </div>
                <div class="form-group">
                    {!! Form::hidden('notes', 0) !!}
                    <label>{!! Form::checkbox('notes') !!}
                        {{ trans('entities.notes') }}
                    </label>
                    <p class="help-block">{{ trans('campaigns.settings.helpers.notes') }}</p>
                </div>
                <div class="form-group">
                    {!! Form::hidden('races', 0) !!}
                    <label>{!! Form::checkbox('races') !!}
                        {{ trans('entities.races') }}
                    </label>
                    <p class="help-block">{{ trans('campaigns.settings.helpers.races') }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::hidden('organisations', 0) !!}
                    <label>{!! Form::checkbox('organisations') !!}
                        {{ trans('entities.organisations') }}
                    </label>
                    <p class="help-block">{{ trans('campaigns.settings.helpers.organisations') }}</p>
                </div>
                <div class="form-group">
                    {!! Form::hidden('quests', 0) !!}
                    <label>{!! Form::checkbox('quests') !!}
                        {{ trans('entities.quests') }}
                    </label>
                    <p class="help-block">{{ trans('campaigns.settings.helpers.quests') }}</p>
                </div>
                <div class="form-group">
                    {!! Form::hidden('tags', 0) !!}
                    <label>{!! Form::checkbox('tags') !!}
                        {{ trans('entities.tags') }}
                    </label>
                    <p class="help-block">{{ trans('campaigns.settings.helpers.tags') }}</p>
                </div>
                <div class="form-group">
                    {!! Form::hidden('dice_rolls', 0) !!}
                    <label>{!! Form::checkbox('dice_rolls') !!}
                        {{ trans('entities.dice_rolls') }}
                    </label>
                    <p class="help-block">{{ trans('campaigns.settings.helpers.dice_rolls') }}</p>
                </div>
                <div class="form-group">
                    {!! Form::hidden('conversations', 0) !!}
                    <label>{!! Form::checkbox('conversations') !!}
                        {{ trans('entities.conversations') }}
                    </label>
                    <p class="help-block">{{ trans('campaigns.settings.helpers.conversations') }}</p>
                </div>
            </div>
        </div>

        <div class="form-group">
            <button class="btn btn-success">{{ trans('crud.save') }}</button>
        </div>

        {!! Form::close() !!}
    </div>
</div>