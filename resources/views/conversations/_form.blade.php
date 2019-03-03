@inject('formService', 'App\Services\FormService')

{{ csrf_field() }}
<div class="panel panel-default">
    <div class="panel-heading">
        <h4>{{ trans('crud.panels.general_information') }}</h4>
    </div>
    <div class="panel-body">
        <div class="form-group required">
            <label>{{ trans('conversations.fields.name') }}</label>
            {!! Form::text('name', $formService->prefill('name', $source), ['placeholder' => trans('conversations.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        </div>

        @include('cruds.fields.type', ['base' => \App\Models\Conversation::class, 'trans' => 'conversations'])

        <div class="form-group required">
            <label>{{ trans('conversations.fields.target') }}</label>
            {!! Form::select('target', trans('conversations.targets'), $formService->prefill('target', $source), ['class' => 'form-control']) !!}
        </div>

        @include('cruds.fields.tags')
        @include('cruds.fields.private')
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <h4>{{ trans('crud.panels.appearance') }}</h4>
    </div>
    <div class="panel-body">
        @include('cruds.fields.image')
    </div>

</div>

@include('cruds.fields.save')
