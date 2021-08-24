
<div class="box box-solid entity-pins">
    <div class="box-header with-border">
        <h3 class="box-title">
            {{ __('entities/pins.title') }}
        </h3>
        <div class="box-tools">
            <i class="fas fa-question-circle" data-toggle="ajax-modal" role="button" data-target="#entity-modal" data-url="{{ route('helpers.pins') }}"></i>
        </div>
    </div>
    <div class="box-body">
        <ul class="list-group list-group-unbordered">
            @include('entities.components.relations')
            @include('entities.components.attributes')
        </ul>
    </div>
</div>

@includeWhen(!isset($printing) && $campaign->campaign()->boosted() && $model->entity->hasLinks(), 'entities.components.links')
