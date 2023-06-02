<?php /** @var \App\Models\Note $model */?>

<div class="entity-grid">
    @include('entities.components.header', [
        'model' => $model,
        'breadcrumb' => [
            ['url' => Breadcrumb::index('notes'), 'label' => \App\Facades\Module::plural(config('entities.ids.note'), __('entities.notes'))],
            null
        ]
    ])

    @include('entities.components.menu_v2', ['active' => 'story'])

    <div class="entity-story-block">
        @include('entities.components.posts', ['withEntry' => true])

        @if(!$model->notes->isEmpty())
            <h3 class="">
                {!! \App\Facades\Module::plural(config('entities.ids.note'), __('entities.notes')) !!}
            </h3>
            <x-box>
                <div class="row">
                    @foreach ($model->notes->sortBy('name') as $subNote)
                        <div class="col-sm-6">
                            {!! $subNote->tooltipedLink() !!} @if($subNote->is_private) <i class="fa-solid fa-lock"></i> @endif <br />
                        </div>
                    @endforeach
                </div>
            </x-box>
        @endif

        @include('entities.pages.logs.history')
    </div>

    <div class="entity-sidebar">
        @include('entities.components.pins')
    </div>
</div>
