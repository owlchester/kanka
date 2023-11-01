<?php
$targets = [
    \App\Models\Conversation::TARGET_USERS => __('conversations.targets.members'),
    \App\Models\Conversation::TARGET_CHARACTERS => __('conversations.targets.characters'),
];
?>
<x-grid>
    @include('cruds.fields.type', ['base' => \App\Models\Conversation::class, 'trans' => 'conversations'])

    <x-forms.field
        field="participants"
        :label="__('conversations.fields.participants')">
        {!! Form::select('target_id', $targets, FormCopy::field('target_id')->string(), ['class' => '']) !!}
    </x-forms.field>
</x-grid>
