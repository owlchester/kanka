<p class="help-block">{{ trans('locations.map.points.helpers.location_or_name') }}</p>

<div class="location-map-errors text-red" style="display: none"></div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group required">
            {!! Form::select2(
                'target_entity_id',
                (isset($model) && $model->targetEntity ? $model->targetEntity : null),
                App\Models\Entity::class,
                false,
                'crud.fields.entity',
                'search.calendar_event',
                'crud.placeholders.entity'
            ) !!}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group required">
            <label>{{ trans('locations.map.points.fields.name') }}</label>
            {!! Form::text('name', (!isset($model) ? request()->get('name', null) : null), ['placeholder' => trans('locations.map.points.placeholders.name'), 'class' => 'form-control', 'maxlength' => 194]) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group required">
            <label>{{ trans('locations.map.points.fields.colour') }}</label>
            {!! Form::select('colour', [
                'none' => trans('colours.none'),
                'grey' => trans('colours.grey'),
                'red' => trans('colours.red'),
                'blue' => trans('colours.blue'),
                'green' => trans('colours.green'),
                'yellow' => trans('colours.yellow'),
                'black' => trans('colours.black'),
                'white' => trans('colours.white')
            ], null, ['class' => 'form-control']) !!}
        </div>
    </div>

<?php
$iconOptions = trans('locations.map.points.icons');
unset($iconOptions['pin']);
unset($iconOptions['entity']);
$iconOptions = array_merge([
    'pin' => trans('locations.map.points.icons.pin'),
    'entity' => trans('locations.map.points.icons.entity'),
], $iconOptions);
?>
    <div class="col-sm-6">
        <div class="form-group required">
            <label>{{ trans('locations.map.points.fields.icon') }}</label>
            <select name="icon" class="form-control select2-icon" style="width: 100%">
                <option value="pin" data-icon="fa fa-map-marker">{{ __('locations.map.points.icons.pin') }}</option>
                <option value="entity">{{ __('locations.map.points.icons.entity') }}</option>
                <option value="anchor">{{ __('locations.map.points.icons.anchor') }}</option>
                <option value="anvil">{{ __('locations.map.points.icons.anvil') }}</option>
                <option value="apple">{{ __('locations.map.points.icons.apple') }}</option>
                <option value="aura">{{ __('locations.map.points.icons.aura') }}</option>
                <option value="axe">{{ __('locations.map.points.icons.axe') }}</option>
                <option value="beer">{{ __('locations.map.points.icons.beer') }}</option>
                <option value="biohazard">{{ __('locations.map.points.icons.biohazard') }}</option>
                <option value="book">{{ __('locations.map.points.icons.book') }}</option>
                <option value="bridge">{{ __('locations.map.points.icons.bridge') }}</option>
                <option value="campfire">{{ __('locations.map.points.icons.campfire') }}</option>
                <option value="candle">{{ __('locations.map.points.icons.candle') }}</option>
                <option value="cat">{{ __('locations.map.points.icons.cat') }}</option>
                <option value="cheese">{{ __('locations.map.points.icons.cheese') }}</option>
                <option value="cog">{{ __('locations.map.points.icons.cog') }}</option>
                <option value="crown">{{ __('locations.map.points.icons.crown') }}</option>
                <option value="character" data-icon="player">{{ __('locations.map.points.icons.character') }}</option>
                <option value="diamond">{{ __('locations.map.points.icons.diamond') }}</option>
                <option value="dragon">{{ __('locations.map.points.icons.dragon') }}</option>
                <option value="emerald">{{ __('locations.map.points.icons.emerald') }}</option>
                <option value="fire">{{ __('locations.map.points.icons.fire') }}</option>
                <option value="flask">{{ __('locations.map.points.icons.flask') }}</option>
                <option value="flower">{{ __('locations.map.points.icons.flower') }}</option>
                <option value="horseshoe">{{ __('locations.map.points.icons.horseshoe') }}</option>
                <option value="hourglass">{{ __('locations.map.points.icons.hourglass') }}</option>
                <option value="hydra">{{ __('locations.map.points.icons.hydra') }}</option>
                <option value="kaleidoscope">{{ __('locations.map.points.icons.kaleidoscope') }}</option>
                <option value="key">{{ __('locations.map.points.icons.key') }}</option>
                <option value="lever">{{ __('locations.map.points.icons.lever') }}</option>
                <option value="meat">{{ __('locations.map.points.icons.meat') }}</option>
                <option value="octopus">{{ __('locations.map.points.icons.octopus') }}</option>
                <option value="potion">{{ __('locations.map.points.icons.potion') }}</option>
                <option value="quest" data-icon="wooden-sign">{{ __('locations.map.points.icons.quest') }}</option>
                <option value="reactor">{{ __('locations.map.points.icons.reactor') }}</option>
                <option value="repair">{{ __('locations.map.points.icons.repair') }}</option>
                <option value="sheep">{{ __('locations.map.points.icons.sheep') }}</option>
                <option value="shield">{{ __('locations.map.points.icons.shield') }}</option>
                <option value="skull">{{ __('locations.map.points.icons.skull') }}</option>
                <option value="snake">{{ __('locations.map.points.icons.snake') }}</option>
                <option value="spades-card">{{ __('locations.map.points.icons.spades-card') }}</option>
                <option value="sprout" data-icon="sprout-emblem">{{ __('locations.map.points.icons.sprout') }}</option>
                <option value="sun">{{ __('locations.map.points.icons.sun') }}</option>
                <option value="tentacle">{{ __('locations.map.points.icons.tentacle') }}</option>
                <option value="toast">{{ __('locations.map.points.icons.toast') }}</option>
                <option value="tombstone">{{ __('locations.map.points.icons.tombstone') }}</option>
                <option value="torch">{{ __('locations.map.points.icons.torch') }}</option>
                <option value="dead-tree">{{ __('locations.map.points.icons.dead-tree') }}</option>
                <option value="palm-tree">{{ __('locations.map.points.icons.palm-tree') }}</option>
                <option value="pine-tree">{{ __('locations.map.points.icons.pine-tree') }}</option>
                <option value="tower">{{ __('locations.map.points.icons.tower') }}</option>
                <option value="water-drop">{{ __('locations.map.points.icons.water') }}</option>
                <option value="wrench">{{ __('locations.map.points.icons.wrench') }}</option>
            </select>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group required">
            <label>{{ trans('locations.map.points.fields.shape') }}</label>
            {!! Form::select('shape', [
                'circle' => trans('locations.map.points.shapes.circle'),
                'square' => trans('locations.map.points.shapes.square'),
            ], null, ['class' => 'form-control']) !!}
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group required">
            <label>{{ trans('locations.map.points.fields.size') }}</label>
            {!! Form::select('size', [
                'standard' => trans('locations.map.points.sizes.standard'),
                'small' => trans('locations.map.points.sizes.small'),
                'large' => trans('locations.map.points.sizes.large')
            ], null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>

{!! Form::hidden('location_id', $location->id) !!}
{!! Form::hidden('axis_x', (!isset($model) ? request()->get('axis_x', null) : null)) !!}
{!! Form::hidden('axis_y', (!isset($model) ? request()->get('axis_y', null) : null)) !!}

