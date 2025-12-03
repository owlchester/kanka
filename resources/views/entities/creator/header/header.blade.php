<div class="quick-creator-header pb-4 border-b border-base-300 ">
    <div class="flex gap-1">
        <div class="grow flex flex-col gap-2">
            <div class="qq-mode text-sm text-uppercase sm:w-96">
                @if ($mode === 'bulk')
                    {{ __('entities.creator.modes.bulk') }}
                @elseif ($mode === 'templates')
                    {{ __('entities.creator.modes.templates') }}
                @else
                    {{ __('entities.creator.modes.default') }}
                @endif
            </div>
            @if (empty($target))
                <div class="dropdown">
                    <div role="button" class="text-2xl" data-dropdown aria-expanded="false">
                        {!! $newLabel !!}
                        <x-icon class="fa-regular fa-chevron-down" />
                        <span class="sr-only">Change type</span>
                    </div>
                    <div class="dropdown-menu hidden" role="menu">
                        <div class="overflow-y-auto max-h-80">
                        @foreach ($orderedEntityTypes as $dropdownEntityType)
                            @include('entities.creator.header._dropdown')
                        @endforeach
                        <x-dropdowns.divider />
                        @php $data = ['toggle' => 'entity-creator', 'url' => route('entity-creator.selection', $campaign), 'entity-type' => 'return']; @endphp
                        <x-dropdowns.item link="#" icon="fa-regular fa-arrow-left" :data="$data">
                            {{ __('entities.creator.back') }}
                        </x-dropdowns.item>
                        </div>
                    </div>
                </div>
            @else
                <div>
                    <div class="text-2xl">
                        {!! $newLabel !!}
                    </div>
                </div>
            @endif
        </div>
        @if (empty($target))
            <div class="qq-toggles flex text-right items-center content-center justify-end gap-2">
                @if (isset($entityType))
                    <div class="qq-mode-toggle btn2 btn-sm self-end @if (empty($mode)) btn-outline  @endif" data-mode="single" data-url="{{ route('entity-creator.form', [$campaign, 'entity_type' => $entityType]) }}" aria-label="{{ __('entities.creator.modes.default') }}" data-title="{{ __('entities.creator.modes.default') }}" data-toggle="tooltip">
                        <x-icon class="fa-regular fa-user" />
                    </div>
                    <div class="qq-mode-toggle btn2 btn-sm self-end @if ($mode == 'bulk') btn-outline  @endif" data-mode="bulk" data-url="{{ route('entity-creator.form', [$campaign, 'entity_type' => $entityType, 'mode' => 'bulk']) }}" aria-label="{{ __('entities.creator.modes.bulk') }}" data-title="{{ __('entities.creator.modes.bulk') }}" data-toggle="tooltip">
                        <x-icon class="fa-regular fa-users" />
                    </div>
                    <div class="qq-mode-toggle btn2 btn-sm self-end @if ($mode == 'templates') btn-outline  @endif" data-mode="templates" data-url="{{ route('entity-creator.form', [$campaign, 'entity_type' => $entityType, 'mode' => 'templates']) }}" aria-label="{{ __('entities.creator.modes.templates') }}" data-title="{{ __('entities.creator.modes.templates') }}" data-toggle="tooltip">
                        <x-icon class="fa-regular fa-address-book" />
                    </div>
                @else

                    <div class="qq-mode-toggle btn2 btn-sm self-end @if (empty($mode)) btn-outline  @endif" data-mode="single" data-url="{{ route('entity-creator.post', [$campaign]) }}" aria-label="{{ __('entities.creator.modes.default') }}" data-title="{{ __('entities.creator.modes.default') }}" data-toggle="tooltip">
                        <x-icon class="fa-regular fa-user" />
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
