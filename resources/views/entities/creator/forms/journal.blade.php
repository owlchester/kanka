<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.type', ['base' => \App\Models\Journal::class, 'trans' => 'journals'])
    </div>
    <div class="col-md-6">
        @include('cruds.fields.journal', ['isParent' => true])
    </div>
</div>

@include('cruds.fields.character', ['label' => __('journals.fields.author')])
