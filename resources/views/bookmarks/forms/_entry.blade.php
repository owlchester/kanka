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

<x-box class="flex flex-col gap-4">
    @include('cruds.fields.name', ['trans' => 'bookmarks'])

    <x-grid>

        <x-forms.field field="icon" :label="__('entities/links.fields.icon')">
            @if($campaign->boosted())
                <input type="text" name="icon" value="{{ old('text', $source->icon ?? $model->icon ?? null) }}" placeholder="fa-solid fa-users" list="link-icon-list" data-paste="fontawesome" maxlength="45" />
                <div class="hidden">
                    <datalist id="link-icon-list">
                        @foreach (\App\Facades\BookmarkCache::iconSuggestion() as $icon)
                            <option value="{{ $icon }}">{{ $icon }}</option>
                        @endforeach
                    </datalist>
                </div>
                <x-slot name="helper">
                    {!! __('entities/links.helpers.icon', [
                        'fontawesome' => '<a href="' . config('fontawesome.search') . '" target="_blank">FontAwesome</a>',
                        'rpgawesome' => '<a href="https://nagoshiashumari.github.io/Rpg-Awesome/" target="_blank">RPGAwesome</a>',
                        'docs' => '<a href="https://docs.kanka.io/en/latest/articles/available-icons.html" target="_blank">' . __('footer.documentation',) . '</a>',
                    ]) !!}
                </x-slot>
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
            tooltip
            :helper="__('entities/links.helpers.parent')">
            <x-forms.select name="parent" :options="$sidebar->campaign($campaign)->availableParents()" :selected="$model->parent ?? 'bookmarks'" />

            <p class="text-neutral-content md:hidden">
                {!! __('entities/links.helpers.parent') !!}
            </p>
        </x-forms.field>


        <x-forms.field
            field="active"
            :label="__('bookmarks.fields.active')"
            tooltip
            :helper="__('bookmarks.helpers.active')">
            <input type="hidden" name="is_active" value="0" />

            <x-checkbox :text="__('bookmarks.visibilities.is_active')">
                <input type="checkbox" name="is_active" value="1" @if (old('is_active', $model->is_active ?? true)) checked="checked" @endif />
            </x-checkbox>

        </x-forms.field>

        <x-forms.field
                field="class"
                :label="__('dashboard.widgets.fields.class')"
                tooltip
                :helper="__('dashboard.widgets.helpers.class')"
        >
            @if ($campaign->boosted())
                <input type="text" name="css" value="{{ old('css', $model->css ?? null) }}" class="w-full" maxlength="45" id="config[class]" />
                <p class="text-neutral-content md:hidden">
                    {{ __('bookmarks.helpers.class') }}
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
    </x-grid>

    @includeWhen(auth()->user()->isAdmin(), 'cruds.fields.privacy_callout')
</x-box>


<x-box class="flex flex-col gap-4">
    <div class="text-xl">{{ __('bookmarks.fields.selector') }}</div>

    <x-helper :text="__('bookmarks.helpers.selector')" />

    <x-forms.field field="target" :label="__('bookmarks.fields.target')">
        <select name="type" class="" id="bookmark-selector">
            <option value="">{{ __('bookmarks.targets.select') }}</option>
            <option value="entity" @if($isEntity) selected="selected" @endif data-target="#bookmark-entity">
                {{ __('bookmarks.targets.entity') }}
            </option>
            <option value="type" @if($isList) selected="selected" @endif data-target="#bookmark-list">
                {{ __('bookmarks.targets.type') }}
            </option>
            <option value="random" @if($isRandom) selected="selected" @endif data-target="#bookmark-random">
                {{ __('bookmarks.targets.random') }}
            </option>
            <option value="dashboard" @if($isDashboard) selected="selected" @endif data-target="#bookmark-dashboard">
                {{ __('bookmarks.targets.dashboard') }}
            </option>
        </select>
    </x-forms.field>
    <div>
        <div class="bookmark-subform transition-opacity duration-300 ease-in-out @if(!$isEntity) opacity-0 invisible h-0 @endif" id="bookmark-entity">
            @include('bookmarks.forms._entity')
        </div>
        <div class="bookmark-subform transition-opacity duration-300 ease-in-out @if(!$isList) opacity-0 invisible h-0 @endif" id="bookmark-list">
            @include('bookmarks.forms._type')
        </div>
        <div class="bookmark-subform transition-opacity duration-300 ease-in-out @if(!$isRandom) opacity-0 invisible h-0 @endif" id="bookmark-random">
            @include('bookmarks.forms._random')
        </div>
        <div class="bookmark-subform transition-opacity duration-300 ease-in-out @if(!$isDashboard) opacity-0 invisible h-0 @endif" id="bookmark-dashboard">
            @include('bookmarks.forms._dashboard')
        </div>
    </div>
</x-box>
