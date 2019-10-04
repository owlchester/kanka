{{ csrf_field() }}
<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.name', ['trans' => 'conversations'])
        @include('cruds.fields.type', ['base' => \App\Models\Conversation::class, 'trans' => 'conversations'])

        <div class="form-group required">
            <label>{{ trans('conversations.fields.target') }}</label>
            {!! Form::select('target', trans('conversations.targets'), FormCopy::field('target')->string(), ['class' => 'form-control']) !!}
        </div>

        @include('cruds.fields.tags')
        @include('cruds.fields.private')
    </div>
    <div class="col-md-6">
        @include('cruds.fields.image')
    </div>
</div>
