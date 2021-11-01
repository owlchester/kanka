<?php
$targets = [
    \App\Models\Conversation::TARGET_CHARACTERS => __('conversations.targets.characters'),
    \App\Models\Conversation::TARGET_USERS => __('conversations.targets.members'),
]
?>
{{ csrf_field() }}
<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.name', ['trans' => 'conversations'])
        @include('cruds.fields.type', ['base' => \App\Models\Conversation::class, 'trans' => 'conversations'])

        <div class="form-group required">
            <label>{{ trans('conversations.fields.target') }}</label>
            {!! Form::select('target_id', $targets, FormCopy::field('target_id')->string(), ['class' => 'form-control']) !!}
        </div>

        @include('cruds.fields.tags')
    </div>
    <div class="col-md-6">
        @include('cruds.fields.image')
    </div>
</div>
@include('cruds.fields.closed')
@include('cruds.fields.private2')
