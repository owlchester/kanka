{{ csrf_field() }}
<div class="row">
    <div class="col-md-12">
        <div class="form-group required">
            {!! Form::select2(
                'ability_id',
                (!empty($ability) && $ability->item ? $ability->item: null),
                App\Models\Ability::class,
                false,
                'crud.fields.ability',
                'abilities.find',
                'crud.placeholders.ability',
                $entity
            ) !!}
        </div>

        <div class="row">
            <div class="col-md-12">
                @include('cruds.fields.visibility')
            </div>
        </div>
    </div>
</div>
