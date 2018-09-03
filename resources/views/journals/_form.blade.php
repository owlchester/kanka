@inject('formService', 'App\Services\FormService')

{{ csrf_field() }}
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>{{ trans('crud.panels.general_information') }}</h4>
            </div>
            <div class="panel-body">
                <div class="form-group required">
                    <label>{{ trans('journals.fields.name') }}</label>
                    {!! Form::text('name', $formService->prefill('name', $source), ['placeholder' => trans('journals.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                </div>
                <div class="form-group">
                    <label>{{ trans('journals.fields.type') }}</label>
                    {!! Form::text('type', $formService->prefill('type', $source), ['placeholder' => trans('journals.placeholders.type'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                </div>
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
                @include('cruds.fields.section')
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

                @if (Auth::user()->isAdmin())
                    <hr>
                    @include('cruds.fields.private')
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>{{ trans('crud.panels.appearance') }}</h4>
            </div>
            <div class="panel-body">
                @include('cruds.fields.image')
            </div>
        </div>
    </div>


    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>{{ trans('crud.fields.entry') }}</h4>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    {!! Form::textarea('entry', $formService->prefill('entry', $source), ['class' => 'form-control html-editor', 'id' => 'entry']) !!}
                </div>
            </div>
            <div class="panel-footer">
                <a href="{{ route('helpers.link') }}" target="_blank">{{ trans('crud.linking_help') }}</a>
            </div>
        </div>
    </div>
</div>

@include('cruds.fields.save')