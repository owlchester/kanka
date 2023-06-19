@include('cruds.fields.type', ['base' => \App\Models\Quest::class, 'trans' => 'quests'])
<x-grid>
    @include('cruds.fields.quest', ['isParent' => true])
    @include('cruds.fields.character', ['label' => 'quests.fields.character'])
</x-grid>
