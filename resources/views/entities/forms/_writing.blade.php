<div class="entry-workspace-columns">
    <div class="entry-workspace-story min-w-0 flex flex-col gap-8 p-4 md:p-8">
        <section class="entry-workspace-description flex flex-col gap-4" aria-label="{{ __('fields.description.label') }}">
            <div class="field-entry entry">
                @include('cruds.fields.entry', ['model' => $entity ?? null])
            </div>
            <a href="https://docs.kanka.io/en/latest/features/mentions.html" target="_blank" rel="noopener noreferrer" class="text-link text-xs w-fit" data-title="{{ __('helpers.link.description') }}" data-toggle="tooltip">
                {{ __('crud.helpers.linking') }}
            </a>
        </section>

    </div>

    <aside class="entry-workspace-inspector min-w-0 flex flex-col gap-6 p-4 md:p-6" aria-label="{{ __('entries/workspace.metadata') }}">
        @if ($entityType->isCharacter())
            @include('characters.form._inspector')
        @else
        <section class="flex flex-col gap-4" aria-labelledby="entry-identity-heading">
            <h2 id="entry-identity-heading" class="text-sm font-semibold">{{ __('entries/workspace.identity') }}</h2>
            @if ($entityType->isCustom())
                @include('entities.forms.entry', ['workspaceFields' => true])
            @else
                @include($entityType->pluralCode() . '.form._entry', ['workspaceFields' => true])
            @endif
            @if (!empty($dateRows) && ($dateCalendars->isNotEmpty() || collect($dateRows)->contains('editable', false)))
                @include('entities.forms._dates')
            @endif
        </section>
        @endif

        <section class="entry-workspace-inspector-section flex flex-col gap-4 pt-6" aria-labelledby="entry-metadata-heading">
            <h2 id="entry-metadata-heading" class="text-sm font-semibold">{{ __('entries/workspace.metadata') }}</h2>
            @unless ($entityType->isAttributeTemplate())
                @include('cruds.fields.tags')
            @endunless
            @if (config('limits.campaigns.premium'))
                @include('cruds.forms._premium', ['premiumField' => 'tooltip'])
            @endif
            @if (config('limits.campaigns.premium') && $campaign->boosted())
                <div class="entry-workspace-cover flex flex-col gap-2" role="group" aria-labelledby="entry-header-image-heading">
                    <h3 id="entry-header-image-heading" class="text-xs font-medium">{{ __('fields.header-image.title') }}</h3>
                    @include('cruds.forms._premium', ['premiumField' => 'header', 'coverLayout' => true])
                </div>
            @endif
        </section>
    </aside>
</div>
