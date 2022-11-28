<?php
$targets = [
    \App\Models\Conversation::TARGET_USERS => __('conversations.targets.members'),
    \App\Models\Conversation::TARGET_CHARACTERS => __('conversations.targets.characters'),
];
?>
<div class="grid grid-cols-2 gap-5">
    @include('cruds.fields.type', ['base' => \App\Models\Conversation::class, 'trans' => 'conversations'])

    <div class="form-group">
        <label>{{ __('conversations.fields.participants') }}</label>
        {!! Form::select('target_id', $targets, FormCopy::field('target_id')->string(), ['class' => 'form-control']) !!}
    </div>
</div>
