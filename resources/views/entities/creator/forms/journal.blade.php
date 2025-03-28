
<div class="grid gap-5 grid-cols-1 md:grid-cols-2">
    @include('cruds.fields.type', ['base' => \App\Models\Journal::class, 'trans' => 'journals'])
    @include('cruds.fields.journal', ['isParent' => true, 'dynamicNew' => true])
</div>

@include('cruds.fields.author')
