<?php /** @var \App\Models\Note $model */?>
<div class="row">
    <div class="col-md-2">
        @include('maps._menu', ['active' => 'story'])
    </div>

    <div class="col-md-8">

        @include('entities.components.entry')
        @include('entities.components.notes')



        @if(!$model->notes->isEmpty())
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ __('notes.fields.notes') }}</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                    @foreach ($model->notes->sortBy('name') as $subNote)
                        <div class="col-sm-6">
                        {!! $subNote->tooltipedLink() !!}<br />
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>
        @endif

        @include('cruds.partials.mentions')
        @include('cruds.boxes.history')
    </div>

    <div class="col-md-2">
        @include('entities.components.pins')
    </div>
</div>
