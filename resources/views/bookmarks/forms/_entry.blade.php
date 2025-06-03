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

        <x-forms.field
            field="position"
            :label="__('bookmarks.fields.position')"
            tooltip
            :helper="__('entities/links.helpers.parent')">
            <x-forms.select name="parent" :options="$sidebar->campaign($campaign)->availableParents()" :selected="$model->parent ?? 'bookmarks'" />
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

        @include('cruds.fields.icon', ['suggestions' => \App\Facades\BookmarkCache::iconSuggestion()])

        <x-forms.field
                field="class"
                :label="__('dashboard.widgets.fields.class')"
                :helper="__('dashboard.widgets.helpers.class')"
        >
            @if ($campaign->boosted())
                <input type="text" name="css" value="{{ old('css', $model->css ?? null) }}" class="w-full" maxlength="45" id="config[class]" />
                <p class="text-neutral-content md:hidden">
                    {{ __('bookmarks.helpers.class') }}
                </p>
            @else
                <x-slot name="helper">
                    @can('boost', auth()->user())
                        {!! __('callouts.booster.pitches.element-class', ['boosted-campaign' => $settingsLink]) !!}
                    @else
                        {!! __('callouts.booster.pitches.element-class', ['boosted-campaign' => $premiumLink]) !!}
                    @endif
                </x-slot>
            @endif
        </x-forms.field>
    </x-grid>

    @includeWhen(auth()->user()->isAdmin(), 'cruds.fields.privacy_callout')
</x-box>


<x-box class="flex flex-col gap-4">
    <div class="text-xl">{{ __('bookmarks.fields.selector') }}</div>

    <x-helper>
        <p>{{ __('bookmarks.helpers.selector') }}</p>
    </x-helper>

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
