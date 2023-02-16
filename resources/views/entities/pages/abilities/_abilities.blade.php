@if (auth()->check() && !auth()->user()->settings()->get('tutorial_abilities'))
    <div class="alert alert-info tutorial">
        <span>
            <button type="button" class="close banner-notification-dismiss" data-dismiss="alert" aria-hidden="true" data-url="{{ route('settings.banner', ['code' => 'abilities', 'type' => 'tutorial']) }}">×</button>
            <p>{{ __('entities/abilities.show.helper') }}</p>
            <p>{!!  __('crud.helpers.learn_more', ['documentation' => link_to('https://docs.kanka.io/en/latest/entities/abilities.html', '<i class="fa-solid fa-external-link" aria-hidden="true"></i> ' . __('front.menu.documentation'), ['target' => '_blank'], null, false)])!!}</p>
        </span>
    </div>
@endif

<div id="abilities">
    <abilities
            id="{{ $entity->id }}"
            api="{{ route('entities.entity_abilities.api', [$campaign, $entity]) }}"
            permission="{{ auth()->check() && auth()->user()->can('update', $entity->child) }}"
            trans="{{ $translations }}"
    ></abilities>
</div>
