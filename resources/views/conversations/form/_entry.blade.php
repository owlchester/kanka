<?php
$targets = [
        \App\Models\Conversation::TARGET_USERS => __('conversations.targets.members'),
        \App\Models\Conversation::TARGET_CHARACTERS => __('conversations.targets.characters'),
];
?>

{{ csrf_field() }}
<div class="grid gap-5 grid-cols-1 md:grid-cols-2">
    @include('cruds.fields.name', ['trans' => 'conversations'])
    @include('cruds.fields.type', ['base' => \App\Models\Conversation::class, 'trans' => 'conversations'])

    <div class="form-group required mb-0">
        <label>{{ __('conversations.fields.participants') }}</label>
        {!! Form::select('target_id', $targets, FormCopy::field('target_id')->string(), ['class' => 'form-control']) !!}
    </div>

    @include('cruds.fields.tags')
    <div>
    @include('cruds.fields.closed')
    </div>
</div>

@include('cruds.fields.image')
