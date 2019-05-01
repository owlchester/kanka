@inject('formService', 'App\Services\FormService')

{{ csrf_field() }}
<div class="row">
    <div class="col-md-6">
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
    <div class="col-md-6">
        @include('cruds.fields.image')
    </div>
</div>
