    @include('cruds.fields.type', ['base' => \App\Models\Ability::class, 'trans' => 'abilities'])

    @include('cruds.fields.parent')
    @include('cruds.fields.charges')

    @include('cruds.fields.entry2')

    @include('cruds.fields.tags')
