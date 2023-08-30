<div class="entity-attributes">
    <div class="box box-solid box-attributes">
        <div class="box-header with-border">
            <h3 class="box-title">
                <x-icon class="fa-solid fa-th-list"></x-icon> {{ __('crud.tabs.attributes') }}
            </h3>
        </div>
        <div class="box-body">
            @include('entities.pages.attributes.render')
        </div>
    </div>
</div>

<input type="hidden" name="live-attribute-config" data-live="{{ route('entities.attributes.live.edit', [$campaign, $entity]) }}" />

@section('scripts')
    @parent
    @vite('resources/js/attributes.js')
@endsection

@section('modals')
    @parent
    <x-dialog id="live-attribute-modal" :loading="true"></x-dialog>
@endsection
