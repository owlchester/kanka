<?php
$targets = [
        \App\Models\Conversation::TARGET_USERS => __('conversations.targets.members'),
        \App\Models\Conversation::TARGET_CHARACTERS => __('conversations.targets.characters'),
];
?>

{{ csrf_field() }}
<x-grid>
    @include('cruds.fields.name', ['trans' => 'conversations'])
    @include('cruds.fields.type', ['base' => \App\Models\Conversation::class, 'trans' => 'conversations'])

    <div class="form-group required ">
        <label>{{ __('conversations.fields.participants') }}</label>
        {!! Form::select('target_id', $targets, FormCopy::field('target_id')->string(), ['class' => 'form-control']) !!}
    </div>

    @include('cruds.fields.tags')
    @include('cruds.fields.closed')

    @include('cruds.fields.image')
</x-grid>

