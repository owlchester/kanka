<div class="flex flex-col gap-6">
    <x-campaigns.page-header :title="isset($entityType) ? $entityType->plural() : __('campaigns/modules.create.title')" />
    @include('partials.errors')
    <div class="flex flex-col gap-6 min-w-0">
            <section id="category-general" class="bg-box rounded-xl p-4 md:p-6 flex flex-col gap-4">
                <h2 class="text-xl">{{ __('General settings') }}</h2>
                @include('campaigns.entity-types._form')
            </section>
            <section id="category-image" class="bg-box rounded-xl p-4 md:p-6 flex flex-col gap-4">
                <h2 class="text-xl">{{ __('Placeholder image') }}</h2>
                @include('cruds.fields.image-old', ['model' => $entityType ?? null, 'campaignImage' => true, 'imageLabel' => 'campaigns/modules.fields.image', 'isModule' => true, 'image' => isset($image) ? Img::for($image['path'])->crop(96, 96)->url() : null])
            </section>
            @php
                $statusRows = collect(old('statuses', isset($entityType) ? $entityType->statuses->toArray() : []))->values();
                $statusCounts = $statusCounts ?? collect();
                $curatedStatusIcons = [
                    'fa-solid fa-check',
                    'fa-solid fa-xmark',
                    'fa-solid fa-clock',
                    'fa-solid fa-skull',
                    'fa-solid fa-star',
                    'fa-solid fa-flag',
                    'fa-solid fa-lock',
                    'fa-solid fa-eye-slash',
                    'fa-solid fa-fire',
                    'fa-solid fa-circle-question',
                ];
                $statusIconSuggestions = collect($curatedStatusIcons)
                    ->merge(app(\App\Services\Caches\SuggestionCache::class)->mapMarkerIcons($campaign))
                    ->unique()
                    ->values();
                $statusPresets = [
                    [
                        'label' => __('Draft / Active / Archived'),
                        'items' => [
                            ['label' => __('Draft'), 'icon' => 'fa-solid fa-pen-to-square', 'is_default' => true],
                            ['label' => __('Active'), 'icon' => 'fa-solid fa-check', 'is_default' => false],
                            ['label' => __('Archived'), 'icon' => 'fa-solid fa-box-archive', 'is_default' => false],
                        ],
                    ],
                    [
                        'label' => __('Unexplored / In progress / Completed'),
                        'items' => [
                            ['label' => __('Unexplored'), 'icon' => 'fa-solid fa-compass', 'is_default' => true],
                            ['label' => __('In progress'), 'icon' => 'fa-solid fa-clock', 'is_default' => false],
                            ['label' => __('Completed'), 'icon' => 'fa-solid fa-circle-check', 'is_default' => false],
                        ],
                    ],
                ];
            @endphp
            <section id="category-statuses" class="bg-box rounded-xl p-4 md:p-6 flex flex-col gap-4" data-category-statuses>
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <div class="flex items-center gap-2">
                        <h2 class="text-xl">{{ __('Statuses') }}</h2>
                        <span class="badge badge-sm" data-status-count>{{ $statusRows->count() }} / 10</span>
                    </div>
                </div>
                <p class="text-sm text-neutral-content">
                    {{ __('Optional vocabulary for entries in this category. Define up to 10 statuses. A default applies to new entries only; entries can still have no status.') }}
                    <a href="{{ config('fontawesome.search') }}" target="_blank" rel="noopener" class="text-link">{{ __('Browse FontAwesome icons') }}</a>
                </p>
                @if (!$campaign->premium())
                    <x-helper><p>{{ __('Status management requires a premium campaign. Existing assignments are preserved.') }}</p></x-helper>
                    @if ($statusRows->isNotEmpty())
                        <div class="flex flex-col gap-2">
                            @foreach ($statusRows as $row)
                                @php
                                    $rowId = $row['id'] ?? null;
                                    $usageCount = $rowId ? (int) ($statusCounts[$rowId] ?? 0) : 0;
                                @endphp
                                <div class="rounded-xl border border-base-300 bg-base-100 p-3 flex flex-wrap items-center justify-between gap-3">
                                    <div class="flex items-center gap-2 min-w-0">
                                        @if (!empty($row['icon']))
                                            <span class="size-8 shrink-0 rounded-lg border border-base-300 flex items-center justify-center">
                                                <i class="{{ str_contains($row['icon'], ' ') ? $row['icon'] : 'fa-regular ' . $row['icon'] }}" aria-hidden="true"></i>
                                            </span>
                                        @endif
                                        <span class="font-medium truncate">{{ $row['label'] ?? $row['key'] ?? '' }}</span>
                                        @if (!empty($row['is_default']))
                                            <span class="badge badge-primary badge-sm">{{ __('Default status') }}</span>
                                        @endif
                                    </div>
                                    @if ($rowId)
                                        <span class="badge badge-sm">
                                            {{ $usageCount > 0 ? trans_choice(':count entry|:count entries', $usageCount, ['count' => $usageCount]) : __('Unused') }}
                                        </span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                @else
                    <input type="hidden" name="statuses_present" value="1" />
                    <datalist id="status-icon-list">
                        @foreach ($statusIconSuggestions as $icon)
                            <option value="{{ $icon }}">{{ $icon }}</option>
                        @endforeach
                    </datalist>
                    <div class="border border-dashed border-base-300 rounded-xl p-6 text-center flex flex-col items-center gap-3 @if ($statusRows->isNotEmpty()) hidden @endif" data-status-empty>
                        <p class="text-sm text-neutral-content max-w-lg">
                            {{ __('No statuses yet. Add statuses to track states on entries (for example, alive, active, or completed), filter lists, and highlight entries at a glance.') }}
                        </p>
                        <div class="flex flex-wrap justify-center gap-2">
                            <button type="button" class="btn2 btn-primary btn-sm" data-status-add>
                                <x-icon class="fa-solid fa-plus" />
                                {{ __('Add your first status') }}
                            </button>
                            @foreach ($statusPresets as $preset)
                                <button type="button" class="btn2 btn-outline btn-sm" data-status-preset='@json($preset['items'])'>
                                    <x-icon class="fa-solid fa-wand-magic-sparkles" />
                                    {{ $preset['label'] }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex flex-col gap-2" data-status-rows>
                        @foreach ($statusRows as $index => $row)
                            @include('campaigns.entity-types.statuses._row')
                        @endforeach
                    </div>
                    <div class="flex flex-wrap items-center gap-3 @if ($statusRows->isEmpty()) hidden @endif" data-status-footer>
                        <button type="button" class="btn2 btn-outline btn-sm" data-status-add @disabled($statusRows->count() >= 10)>
                            <x-icon class="fa-solid fa-plus" />
                            {{ __('Add status') }}
                        </button>
                        <span class="text-xs text-neutral-content @if ($statusRows->count() < 10) hidden @endif" data-status-limit-hint>
                            {{ __('Maximum of 10 statuses reached.') }}
                        </span>
                    </div>
                    <template data-status-template>
                        @include('campaigns.entity-types.statuses._row', ['index' => 0, 'row' => [], 'statusCounts' => collect()])
                    </template>
                @endif
            </section>
            <div class="flex flex-wrap gap-3 items-center">
                <a href="{{ route('campaign.modules', $campaign) }}" class="btn2">{{ __('crud.cancel') }}</a>
                @isset($entityType)
                    <a href="{{ route('entity_types.confirm', [$campaign, $entityType]) }}" class="btn2 btn-error btn-outline">{{ __('Delete category') }}</a>
                @endisset
                <button class="btn2 btn-primary" type="submit">{{ __('crud.actions.save-changes') }}</button>
            </div>
    </div>
</div>
