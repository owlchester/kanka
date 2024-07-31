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
$settingsLink = '<a href="' . route('settings.premium', ['campaign' => $campaign]) . '">' . __('concept.premium-campaign') . '</a>';
$premiumLink = '<a href="https://kanka.io/premium">' . __('concept.premium-campaign') . '</a>';
?>
@inject('sidebar', 'App\Services\SidebarService')
<x-grid>
    @include('cruds.fields.name', ['trans' => 'bookmarks'])

    <x-forms.field field="icon" :label="__('entities/links.fields.icon')">
        @if($campaign->boosted())
            <input type="text" name="icon" value="{{ old('text', $source->icon ?? $model->icon ?? null) }}" placeholder="fa-solid fa-users" data-paste="fontawesome" maxlength="45" />
            <x-helper>
                {!! __('entities/links.helpers.icon', [
                    'fontawesome' => '<a href="' . config('fontawesome.search') . '" target="_blank">FontAwesome</a>',
                    'rpgawesome' => '<a href="https://nagoshiashumari.github.io/Rpg-Awesome/" target="_blank">RPGAwesom</a>',
                    'docs' => '<a href="https://docs.kanka.io/en/latest/articles/available-icons.html" target="_blank">' . __('footer.documentation',) . '</a>',
                ]) !!}
            </x-helper>
        @else
            @if (auth()->user()->hasBoosters())
            <x-helper>
                {!! __('callouts.booster.pitches.icon', ['boosted-campaign' => $settingsLink]) !!}
            </x-helper>
            @else
                <x-helper>
                    {!! __('callouts.booster.pitches.icon', ['boosted-campaign' => $premiumLink]) !!}
                </x-helper>
            @endif
        @endif
    </x-forms.field>

    <x-forms.field
            field="position"
            :label="__('bookmarks.fields.position')"
            :tooltip="true"
            :helper="__('entities/links.helpers.parent')">
        @if ($campaign->boosted())
            <x-forms.select name="parent" :options="$sidebar->campaign($campaign)->availableParents()" :selected="$model->parent ?? 'bookmarks'" />

            <p class="text-neutral-content md:hidden">
                {!! __('entities/links.helpers.parent') !!}
            </p>
        @else
            @if (auth()->user()->hasBoosters())
                <x-helper>
                    {!! __('callouts.booster.pitches.link-parent', ['boosted-campaign' => $settingsLink]) !!}
                </x-helper>
            @else
                <x-helper>
                    {!! __('callouts.booster.pitches.link-parent', ['boosted-campaign' => $premiumLink]) !!}
                </x-helper>
            @endif
        @endif
    </x-forms.field>

    <x-forms.field
            field="class"
            :label="__('dashboard.widgets.fields.class')"
            :tooltip="true"
            :helper="__('dashboard.widgets.helpers.class')"
    >
        @if ($campaign->boosted())
            <input type="text" name="css" value="{{ old('css', $model->css ?? null) }}" class="w-full" maxlength="45" id="config[class]" />
            <p class="text-neutral-content md:hidden">
                {{ __('dashboard.widgets.helpers.class') }}
            </p>
        @else
            @if (auth()->user()->hasBoosters())
            <x-helper>
                {!! __('callouts.booster.pitches.element-class', ['boosted-campaign' => $settingsLink]) !!}
            </x-helper>
            @else
                <x-helper>
                    {!! __('callouts.booster.pitches.element-class', ['boosted-campaign' => $premiumLink]) !!}
                </x-helper>
            @endif
        @endif
    </x-forms.field>

    <x-forms.field field="active" :label="__('bookmarks.fields.active')" :tooltip="true"
                   :helper="__('bookmarks.helpers.active')">
        <input type="hidden" name="is_active" value="0" />

        <x-checkbox :text="__('bookmarks.visibilities.is_active')">
            <input type="checkbox" name="is_active" value="1" @if (old('is_active', $model->is_active ?? true)) checked="checked" @endif />
        </x-checkbox>

    </x-forms.field>
</x-grid>

<x-grid type="1/1">
    <hr/>

    <h4>{{ __('bookmarks.fields.selector') }}</h4>
    <x-helper :text="__('bookmarks.helpers.selector')" />

    <x-forms.field field="target" :label="__('bookmarks.fields.target')">
        <select name="type" class="" id="bookmark-selector">
            <option value="">Choose an option</option>
            <option value="entity" @if($isEntity) selected="selected" @endif data-target="#bookmark-entity">
                {{ __('bookmarks.fields.entity') }}
            </option>
            <option value="type" @if($isList) selected="selected" @endif data-target="#bookmark-list">
                {{ __('crud.fields.type') }}
            </option>
            <option value="random" @if($isRandom) selected="selected" @endif data-target="#bookmark-random">
                {{ __('bookmarks.fields.random') }}
            </option>
            <option value="dashboard" @if($isDashboard) selected="selected" @endif data-target="#bookmark-dashboard">
                {{ __('bookmarks.fields.dashboard') }}
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
</x-grid>
