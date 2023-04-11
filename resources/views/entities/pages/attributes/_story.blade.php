<div class="entity-attributes">
    <div class="box box-solid box-attributes">
        <div class="box-header with-border">
            <h3 class="box-title">
                <i class="fa-solid fa-th-list" aria-hidden="true"></i> {{ __('crud.tabs.attributes') }}
            </h3>
        </div>
        <div class="box-body">
            @include('entities.pages.attributes.render')
        </div>
    </div>
</div>

<input type="hidden" name="live-attribute-config" data-live="{{ route('entities.attributes.live.edit', $entity) }}" />

@section('scripts')
    @parent
    @vite('resources/js/attributes.js')
@endsection

@section('modals')
    @parent
    <div class="modal fade" id="live-attribute-modal" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content"></div>
        </div>
    </div>
@endsection
