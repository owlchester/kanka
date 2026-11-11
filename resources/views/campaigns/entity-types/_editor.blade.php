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
                @include('cruds.fields.image-old', ['model' => $entityType ?? null, 'campaignImage' => true, 'imageLabel' => 'campaigns/modules.fields.image', 'isModule' => true, 'image' => isset($image) ? Img::crop(96, 96)->url($image['path']) : null])
            </section>
            <section id="category-statuses" class="bg-box rounded-xl p-4 md:p-6 flex flex-col gap-4" data-category-statuses>
                <h2 class="text-xl">{{ __('Statuses') }}</h2>
                <p class="text-neutral-content">{{ __('Optional vocabulary for entries in this category. Define up to 10 statuses. A default applies to new entries only; entries can still have no status.') }}</p>
                @if (!$campaign->premium())
                    <x-helper><p>{{ __('Status management requires a premium campaign. Existing assignments are preserved.') }}</p></x-helper>
                @else
                    <input type="hidden" name="statuses_present" value="1" />
                @endif
                <fieldset @disabled(!$campaign->premium()) class="flex flex-col gap-4">
                    <label class="flex items-center gap-2">
                        <input type="radio" name="status_default" value="" data-status-default-none @checked(!collect(old('statuses', $entityType->statuses ?? []))->contains(fn ($status) => (bool) data_get($status, 'is_default'))) />
                        {{ __('No default') }}
                    </label>
                    <div class="flex flex-col gap-4" data-status-rows>
                        @foreach (old('statuses', isset($entityType) ? $entityType->statuses->toArray() : []) as $index => $row)
                            @include('campaigns.entity-types.statuses._row')
                        @endforeach
                    </div>
                    <button type="button" class="btn2 btn-outline self-start" data-status-add>{{ __('Add status') }}</button>
                </fieldset>
                <template data-status-template>
                    @include('campaigns.entity-types.statuses._row', ['index' => 0, 'row' => []])
                </template>
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
