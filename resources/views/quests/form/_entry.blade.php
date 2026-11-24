@include('cruds.fields.type', ['base' => \App\Models\Quest::class, 'trans' => 'quests'])

@include('cruds.fields.parent')
@include('cruds.fields.instigator')
@include('cruds.fields.locations', ['from' => $model ?? null, 'quickCreator' => true])

@include('cruds.fields.date')

@unless ($workspaceFields ?? false)
<div class="col-span-2">
    @include('cruds.forms._calendar', ['source' => $source])
</div>
@endunless

@include('cruds.fields.status')

@include('cruds.fields.entry2')

@include('cruds.fields.tags')
