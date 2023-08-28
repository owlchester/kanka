<?php /** @var \App\Models\Note $model */?>

<div class="entity-grid flex flex-col gap-5">
    @include('entities.components.header', [
        'model' => $model,
        'breadcrumb' => [
            Breadcrumb::entity($model->entity)->list(),
            null
        ]
    ])

    <div class="entity-body flex flex-col md:flex-row gap-5 px-4">
        @include('entities.components.menu_v2', ['active' => 'story'])

        <div class="entity-main-block grow flex flex-col gap-5">
            @include('entities.components.posts', ['withEntry' => true])

            @if(!$model->notes->isEmpty())
                <h3 class="">
                    {!! \App\Facades\Module::plural(config('entities.ids.note'), __('entities.notes')) !!}
                </h3>
                <x-box>
                    <x-grid>
                        @foreach ($model->notes->sortBy('name') as $subNote)
                                {!! $subNote->tooltipedLink() !!} @if($subNote->is_private) <i class="fa-solid fa-lock"></i> @endif <br />

                        @endforeach
                    </x-grid>
                </x-box>
            @endif
        </div>

        @include('entities.components.pins')
    </div>
</div>
