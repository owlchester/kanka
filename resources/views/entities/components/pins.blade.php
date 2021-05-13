
<div class="box box-solid">
    <div class="box-header">
        <h3 class="box-title">{{ __('entities/pins.title') }}</h3>
    </div>
    <div class="box-body">
        @include('entities.components.links')
        <ul class="list-group list-group-unbordered">
            @include('entities.components.relations')
            @include('entities.components.attributes')
        </ul>
    </div>
</div>
