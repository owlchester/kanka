<?php /** @var \App\Models\Note $model */?>

<div class="entity-grid">
    @include('entities.components.header_grid', [
        'model' => $model,
        'breadcrumb' => [
            ['url' => Breadcrumb::index($name), 'label' => __($name . '.index.title')],
            null
        ]
    ])

    @include($name . '._menu', ['active' => 'story'])

    <div class="entity-story-block">
        @include('entities.components.notes', ['withEntry' => true])

        @if(!$model->notes->isEmpty())
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ __('notes.fields.notes') }}</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        @foreach ($model->notes->sortBy('name') as $subNote)
                            <div class="col-sm-6">
                                {!! $subNote->tooltipedLink() !!} @if($subNote->is_private) <i class="fa-solid fa-lock"></i> @endif <br />
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        @include('cruds.partials.mentions')
        @include('cruds.boxes.history')
    </div>

    <div class="entity-sidebar">
        @include('entities.components.pins')
    </div>
</div>
