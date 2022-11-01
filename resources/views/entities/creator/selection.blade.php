@inject('campaignService', 'App\Services\CampaignService')

<div class="modal-body">
    @include('partials.modals.close')
    <div class="quick-creator-header">
        <div>
            <div class="qq-entity-type">
                {{ __('entities.creator.title') }}
            </div>
        </div>
    </div>

    <div class="quick-creator-body">

    @includeWhen(isset($new), 'entities.creator._created', ['success' => $new ?? null])

    <p class="help-block mb-5">{{ __('entities.creator.helper_v2') }}</p>
    <div class="entity-creator">
        @if (isset($entities['characters']))
                <a href="#" class="rounded-lg quick-creator-selection" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', ['type' => 'characters']) }}" data-entity-type="character">
                    <i class="fa-solid fa-user fa-2x"></i>
                    {{ __('entities.character') }}
                </a>
        @endif

        @if (isset($entities['locations']))
            <a href="#" class="rounded-lg quick-creator-selection" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', ['type' => 'locations']) }}" data-entity-type="location">
                <i class="ra ra-tower ra-2x"></i>
                {{ __('entities.location') }}
            </a>
        @endif
        @if (isset($entities['maps']))
            <a href="#" class="rounded-lg quick-creator-selection" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', ['type' => 'maps']) }}" data-entity-type="map">
                <i class="fa-solid fa-map fa-2x"></i>
                {{ __('entities.map') }}
            </a>
        @endif

        @if (isset($entities['organisations']))
            <a href="#" class="rounded-lg quick-creator-selection" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', ['type' => 'organisations']) }}" data-entity-type="organisation">
                <i class="ra ra-hood ra-2x"></i>
                {{ __('entities.organisation') }}
            </a>
        @endif

        @if (isset($entities['families']))
                <a href="#" class="rounded-lg quick-creator-selection" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', ['type' => 'families']) }}" data-entity-type="family">
                    <i class="ra ra-double-team ra-2x"></i>
                    {{ __('entities.family') }}
                </a>
        @endif

        @if (isset($entities['calendars']))
            <a href="#" class="rounded-lg quick-creator-selection" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', ['type' => 'calendars']) }}" data-entity-type="calendar">
                <i class="fa-solid fa-calendar fa-2x"></i>
                {{ __('entities.calendar') }}
            </a>
        @endif

        @if (isset($entities['timelines']))
            <a href="#" class="rounded-lg quick-creator-selection" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', ['type' => 'timelines']) }}" data-entity-type="timeline">
                <i class="fa-solid fa-hourglass fa-2x"></i>
                {{ __('entities.timeline') }}
            </a>
        @endif

        @if (isset($entities['events']))
            <a href="#" class="rounded-lg quick-creator-selection" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', ['type' => 'events']) }}" data-entity-type="event">
                <i class="fa-solid fa-bolt fa-2x"></i>
                {{ __('entities.event') }}
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
        @if (isset($entities['creatures']))
            <a href="#" class="rounded-lg quick-creator-selection" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', ['type' => 'creatures']) }}" data-entity-type="creature">
                <i class="ra ra-raven ra-2x"></i>
                {{ __('entities.creature') }}
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

        @if (isset($entities['conversations']))
            <a href="#" class="rounded-lg quick-creator-selection" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', ['type' => 'conversations']) }}" data-entity-type="conversation">
                <i class="fa-solid fa-comment fa-2x"></i>
                {{ __('entities.conversation') }}
            </a>
        @endif

        @if (isset($entities['dice_rolls']))
            <a href="#" class="rounded-lg quick-creator-selection" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', ['type' => 'dice_rolls']) }}" data-entity-type="dice_roll">
                <i class="ra ra-dice-five ra-2x"></i>
                {{ __('entities.dice_roll') }}
            </a>
        @endif

        @if (isset($entities['attribute_templates']))
            <a href="#" class="rounded-lg quick-creator-selection" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', ['type' => 'attribute_templates']) }}" data-entity-type="attribute_template">
                <i class="fa-solid fa-copy fa-2x"></i>
                {{ __('entities.attribute_template') }}
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
    </div>

    <div class="quick-creator-footer text-center">

        <p class="help-block my-5">{{ __('entities.creator.missing') }}</p>

        <a href="//docs.kanka.io/en/latest/features/quick-creator.html" target="_blank">
            <i class="fa-solid fa-external-link" aria-hidden="true"></i>
            {{ __('front/newsletter.actions.learn_more') }}
        </a>
    </div>
</div>

