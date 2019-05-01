@inject('formService', 'App\Services\FormService')

{{ csrf_field() }}
<div class="row">
    <div class="col-md-6">
        <div class="form-group required">
            <label>{{ trans('journals.fields.name') }}</label>
            {!! Form::text('name', $formService->prefill('name', $source), ['placeholder' => trans('journals.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        </div>
        @include('cruds.fields.type', ['base' => \App\Models\Journal::class, 'trans' => 'journals'])
        @if ($campaign->enabled('characters'))
            <div class="form-group">
                {!! Form::select2(
                    'character_id',
                    (isset($model) && $model->character ? $model->character : $formService->prefillSelect('character', $source)),
                    App\Models\Character::class,
                    true,
                    'journals.fields.author'
                ) !!}
            </div>
        @endif
        @include('cruds.fields.location')

        @include('cruds.fields.tags')
        @include('cruds.fields.attribute_template')

        <div class="form-group">
            <label>{{ trans('journals.fields.date') }}</label>
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                {!! Form::text('date', $formService->prefill('date', $source), ['placeholder' => trans('journals.placeholders.date'), 'id' => 'date', 'class' => 'form-control date-picker']) !!}
            </div>
        </div>

        @include('cruds.fields.private')
    </div>
    <div class="col-md-6">
        @include('cruds.fields.image')
    </div>

    <div class="col-md-12">
        @include('cruds.fields.entry2')
    </div>
</div>