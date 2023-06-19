<x-grid>
    @include('cruds.fields.type', ['base' => \App\Models\Creature::class, 'trans' => 'creatures'])

    @include('cruds.fields.creature', ['isParent' => true])
</x-grid>
