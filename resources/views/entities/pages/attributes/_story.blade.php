<div class="entity-attributes flex flex-col gap-2">
    <h3 class="text-xl">
        <x-icon class="fa-regular fa-th-list" />
        {{ __('crud.tabs.attributes') }}
    </h3>
    <x-box>
        @include('entities.pages.attributes.render')
    </x-box>
</div>

<input type="hidden" name="live-attribute-config" data-live="{{ route('entities.attributes.live.edit', [$campaign, $entity]) }}" />

@section('scripts')
    @parent
    @vite('resources/js/attributes.js')
@endsection

@section('modals')
    @parent
    <x-dialog id="live-attribute-dialog" :loading="true"></x-dialog>
@endsection
