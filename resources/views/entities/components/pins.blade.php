
<div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">{{ __('entities/pins.title') }}</h3>
    </div>
    <div class="box-body">
        <ul class="list-group list-group-unbordered">
            @include('entities.components.relations')
            @include('entities.components.attributes')
        </ul>
    </div>
</div>

@includeWhen($campaign->campaign()->boosted() && $model->entity->hasLinks(), 'entities.components.links')
