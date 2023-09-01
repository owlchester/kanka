<?php /**
 * @var \App\Models\Bookmark $model
 * @var \App\Services\EntityService $entityService
 * @var \App\Services\SidebarService $sidebar
 */

$tab = empty($model) || old('entity_id') || $model->entity_id ? 'entity' : 'type';

$isEntity = $isDashboard = $isRandom = $isList = false;
if (isset($model)) {
    if ($model->isDashboard()) {
        $isDashboard = true;
    } elseif ($model->isEntity()) {
        $isEntity = true;
    } elseif ($model->isList()) {
        $isList = true;
    } elseif ($model->isRandom()) {
        $isRandom = true;
    }
}
?>
@inject('sidebar', 'App\Services\SidebarService')
<x-grid>
    @include('cruds.fields.name', ['trans' => 'menu_links'])

    <x-forms.field field="icon" :label="__('entities/links.fields.icon')">
        @if($campaign->boosted())
            {!! Form::text(
                'icon',
                null,
                [
                    'placeholder' => 'fa-solid fa-users',
                    'class' => '',
        'data-paste' => 'fontawesome',
                    'maxlength' => 45
                ]
            ) !!}
            <x-helper>
                {!! __('entities/links.helpers.icon', [
                    'fontawesome' => link_to(config('fontawesome.search'), 'FontAwesome', ['target' => '_blank']),
                    'rpgawesome' => link_to('https://nagoshiashumari.github.io/Rpg-Awesome/', 'RPGAwesome', ['target' => '_blank']),
                    'docs' => link_to('https://docs.kanka.io/en/latest/articles/available-icons.html', __('footer.documentation', ['target' => '_blank']))
                ]) !!}
            </x-helper>
        @else
            @subscriber()
            <x-helper>
                {!! __('callouts.booster.pitches.icon', ['boosted-campaign' => link_to_route('settings.premium', __('concept.premium-campaign'), ['campaign' => $campaign])]) !!}
            </x-helper>
            @else
                <x-helper>
                    {!! __('callouts.booster.pitches.icon', ['boosted-campaign' => link_to('https://kanka.io/premium', __('concept.premium-campaign'))]) !!}
                </x-helper>
                @endsubscriber

            @endif
    </x-forms.field>

    <x-forms.field
            field="position"
            :label="__('menu_links.fields.position')"
            :tooltip="true"
            :helper="__('entities/links.helpers.parent')">
        @if ($campaign->boosted())
            {{ Form::select('parent', $sidebar->campaign($campaign)->availableParents(), (empty($model) || empty($model->parent) ? 'bookmarks' : $model->parent), ['class' => '']) }}

            <p class="text-neutral-content md:hidden">
                {!! __('entities/links.helpers.parent') !!}
            </p>
        @else
            @subscriber()
            <x-helper>
                {!! __('callouts.booster.pitches.link-parent', ['boosted-campaign' => link_to_route('settings.premium', __('concept.premium-campaign'), ['campaign' => $campaign])]) !!}
            </x-helper>
            @else
                <x-helper>
                    {!! __('callouts.booster.pitches.link-parent', ['boosted-campaign' => link_to('https://kanka.io/premium', __('concept.premium-campaign'))]) !!}
                </x-helper>
                @endsubscriber
            @endif
    </x-forms.field>

    <x-forms.field
            field="class"
            :label="__('dashboard.widgets.fields.class')"
            :tooltip="true"
            :helper="__('dashboard.widgets.helpers.class')"
    >
        @if ($campaign->boosted())
            {!! Form::text('css', null, ['class' => '', 'id' => 'config[class]', 'maxlength' => 45]) !!}
            <p class="text-neutral-content md:hidden">
                {{ __('dashboard.widgets.helpers.class') }}
            </p>
        @else
            @subscriber()
            <x-helper>
                {!! __('callouts.booster.pitches.element-class', ['boosted-campaign' => link_to_route('settings.premium', __('concept.premium-campaign'), ['campaign' => $campaign])]) !!}
            </x-helper>
            @else
                <x-helper>
                    {!! __('callouts.booster.pitches.element-class', ['boosted-campaign' => link_to('https://kanka.io/premium', __('concept.premium-campaign'))]) !!}
                </x-helper>
                @endsubscriber
            @endif
    </x-forms.field>

    <x-forms.field field="active" :label="__('menu_links.fields.active')" :tooltip="true"
                   :helper="__('menu_links.helpers.active')">
        {!! Form::hidden('is_active', 0) !!}

        <label class="text-neutral-content cursor-pointer flex gap-2">
            {!! Form::checkbox('is_active', 1, isset($model) ? $model->is_active : 1) !!}
            <span>{{ __('menu_links.visibilities.is_active') }}</span>
        </label>

    </x-forms.field>
</x-grid>

<hr/>

<h4>{{ __('menu_links.fields.selector') }}</h4>
<x-helper :text="__('menu_links.helpers.selector')" />

<x-forms.field field="target" :label="__('menu_links.fields.target')">
    <select name="type" class="" id="bookmark-selector">
        <option value="">Choose an option</option>
        <option value="entity" @if($isEntity) selected="selected" @endif data-target="#bookmark-entity">
            {{ __('menu_links.fields.entity') }}
        </option>
        <option value="type" @if($isList) selected="selected" @endif data-target="#bookmark-list">
            {{ __('crud.fields.type') }}
        </option>
        <option value="random" @if($isRandom) selected="selected" @endif data-target="#bookmark-random">
            {{ __('menu_links.fields.random') }}
        </option>
        <option value="dashboard" @if($isDashboard) selected="selected" @endif data-target="#bookmark-dashboard">
            {{ __('menu_links.fields.dashboard') }}
        </option>
    </select>
</x-forms.field>
<div>
    <div class="bookmark-subform @if(!$isEntity) hidden @endif" id="bookmark-entity">
        @include('bookmarks.form._entity')
    </div>
    <div class="bookmark-subform @if(!$isList) hidden @endif" id="bookmark-list">
        @include('bookmarks.form._type')
    </div>
    <div class="bookmark-subform @if(!$isRandom) hidden @endif" id="bookmark-random">
        @include('bookmarks.form._random')
    </div>
    <div class="bookmark-subform @if(!$isDashboard) hidden @endif" id="bookmark-dashboard">
        @include('bookmarks.form._dashboard')
    </div>
</div>

<hr/>
@includeWhen(auth()->user()->isAdmin(), 'cruds.fields.privacy_callout')

