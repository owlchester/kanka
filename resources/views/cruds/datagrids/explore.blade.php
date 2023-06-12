<?php /** @var \App\Models\MiscModel $model */?>
<div class="entities-grid flex flex-wrap gap-3 lg:gap-5">
    @if (!empty($parent))
        <a href="{{ route($route . '.' . $sub, $parent->parent ? ['parent_id' => $parent->parent->id] : []) }}" class="entity block w-[47%] xs:w-[25%] sm:w-48 overflow-hidden rounded flex flex-col shadow-sm hover:shadow-md sm">
            <div class="block w-46 flex items-center justify-center grow  text-6xl">
                <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
            </div>
            <div class="block text-center p-4 h-12 bg-box">
                @if ($parent->parent)
                {{ __('datagrids.actions.back_to', ['name' => $parent->parent->name]) }}
                @else
                    {{ __('crud.actions.back') }}
                @endif
            </div>
        </a>

        @include('cruds.datagrids._grid', ['model' => $parent, 'isParent' => true])
    @endif
    @foreach ($models as $model)
        @include('cruds.datagrids._grid')
    @endforeach

    @if ($models->hasPages() && auth()->check() && !auth()->user()->settings()->get('tutorial_pagination'))
        <div class="block border rounded shadow-xs hover:shadow-md w-48 overflow-hidden tutorial">
            <div class="bg-blue-100 h-48 w-48 overflow-hidden p-2 flex flex-col gap-2">
                <a class="grow" href="{{ route('settings.appearance', ['highlight' => 'pagination', 'from' => base64_encode(route($route . '.' . $sub))]) }}">
                    {!! __('crud.helpers.pagination.text', ['settings' => __('crud.helpers.pagination.settings')]) !!}
                </a>

                <button type="button" class="btn2 btn-primary btn-sm btn-block banner-notification-dismiss" data-dismiss="tutorial" data-url="{{ route('settings.banner', ['code' => 'pagination', 'type' => 'tutorial']) }}">
                    {{ __('header.notifications.dismiss') }}
                </button>
            </div>

        </div>
    @endif
</div>


@if($models->hasPages())
    <div class="text-right">
        {{ $models->appends($filterService->pagination())->onEachSide(0)->links() }}
    </div>
@endif
