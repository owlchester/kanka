@inject('campaignService', 'App\Services\CampaignService')

<div class="modal-body text-center">
    @include('partials.modals.close')

    @if(isset($new))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {!! $new !!}
        </div>
    @endif
    <p class="help-block mb-5">{{ __('entities.creator.helper_v2') }}</p>
    <div class="entity-creator">
        @if (isset($entities['characters']))
                <a href="#" class="rounded-lg quick-creator-selection" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', ['type' => 'characters']) }}" data-entity-type="character">
                    <i class="fa-solid fa-user fa-2x"></i>
                    {{ __('entities.character') }}
                </a>
        @endif

        @if (isset($entities['families']))
                <a href="#" class="rounded-lg quick-creator-selection" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', ['type' => 'families']) }}" data-entity-type="family">
                    <i class="ra ra-double-team ra-2x"></i>
                    {{ __('entities.family') }}
                </a>
        @endif

        @if (isset($entities['locations']))
                <a href="#" class="rounded-lg quick-creator-selection" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', ['type' => 'locations']) }}" data-entity-type="location">
                    <i class="ra ra-tower ra-2x"></i>
                    {{ __('entities.location') }}
                </a>
        @endif

        @if (isset($entities['organisations']))
                <a href="#" class="rounded-lg quick-creator-selection" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', ['type' => 'organisations']) }}" data-entity-type="organisation">
                    <i class="ra ra-hood ra-2x"></i>
                    {{ __('entities.organisation') }}
                </a>
        @endif

        @if (isset($entities['items']))
                <a href="#" class="rounded-lg quick-creator-selection" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', ['type' => 'items']) }}" data-entity-type="item">
                    <i class="ra ra-gem-pendant ra-2x"></i>
                    {{ __('entities.item') }}
                </a>
        @endif

        @if (isset($entities['notes']))
                <a href="#" class="rounded-lg quick-creator-selection" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', ['type' => 'notes']) }}" data-entity-type="note">
                    <i class="fa-solid fa-book-open fa-2x"></i>
                    {{ __('entities.note') }}
                </a>
        @endif

        @if (isset($entities['events']))
                <a href="#" class="rounded-lg quick-creator-selection" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', ['type' => 'events']) }}" data-entity-type="event">
                    <i class="fa-solid fa-bolt fa-2x"></i>
                    {{ __('entities.event') }}
                </a>
        @endif

        @if (isset($entities['calendars']))
                <a href="#" class="rounded-lg quick-creator-selection" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', ['type' => 'calendar']) }}" data-entity-type="calendar">
                    <i class="fa-solid fa-calendar fa-2x"></i>
                    {{ __('entities.calendar') }}
                </a>
        @endif

        @if (isset($entities['races']))
                <a href="#" class="rounded-lg quick-creator-selection" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', ['type' => 'races']) }}" data-entity-type="race">
                    <i class="ra ra-wyvern ra-2x"></i>
                    {{ __('entities.race') }}
                </a>
        @endif

        @if (isset($entities['quests']))
                <a href="#" class="rounded-lg quick-creator-selection" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', ['type' => 'quests']) }}" data-entity-type="quest">
                    <i class="ra ra-wooden-sign ra-2x"></i>
                    {{ __('entities.quest') }}
                </a>
        @endif

        @if (isset($entities['journals']))
                <a href="#" class="rounded-lg quick-creator-selection" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', ['type' => 'journals']) }}" data-entity-type="journal">
                    <i class="ra ra-quill-ink ra-2x"></i>
                    {{ __('entities.journal') }}
                </a>
        @endif

        @if (isset($entities['abilities']))
                <a href="#" class="rounded-lg quick-creator-selection" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', ['type' => 'abilities']) }}" data-entity-type="ability">
                    <i class="ra ra-fire-symbol ra-2x"></i>
                    {{ __('entities.ability') }}
                </a>
        @endif

        @can('create', \App\Models\Tag::class)
            <a href="#" class="rounded-lg quick-creator-selection" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', ['type' => 'tags']) }}" data-entity-type="tag">
                <i class="fa-solid fa-tags fa-2x"></i>
                {{ __('entities.tag') }}
            </a>
        @endcan

        @can('recover', $campaignService->campaign())
            <a href="#" class="rounded-lg quick-creator-selection" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', ['type' => 'posts']) }}" data-entity-type="post">
                <i class="fa-solid fa-pen fa-2x"></i>
                {{ __('entities.post') }}
            </a>
        @endcan
    </div>

    <p class="help-block my-5">{{ __('entities.creator.missing') }}</p>
</div>

