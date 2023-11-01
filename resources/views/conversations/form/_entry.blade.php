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

    <x-forms.field
        field="participants"
        :required="true"
        :label="__('conversations.fields.participants')">
        {!! Form::select('target_id', $targets, FormCopy::field('target_id')->string(), ['class' => 'w-full']) !!}
    </x-forms.field>

    @include('cruds.fields.tags')
    @include('cruds.fields.closed')

    @include('cruds.fields.image')
</x-grid>

