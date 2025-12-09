<x-box class="widget-welcome" id="dashboard-widget-{{ $widget->id }}">
    <span class="widget-title block text-lg mb-3">
        {{ __('dashboards/widgets/welcome.title', ['kanka' => config('app.name')]) }}
    </span>
    <div class=" entity-content">
    <p>
        {!! __('dashboards/widgets/welcome.intros.1', [
'user' => auth()->check() ? '<strong>' . auth()->user()->name . '</strong>' : __('crud.users.unknown'),
'characters' => '<a href="' . route('characters.index', [$campaign]) . '" class="text-link">' . __('entities.characters') . '</a>',
'locations' => '<a href="' . route('locations.index', [$campaign]) . '" class="text-link">' . __('entities.locations') . '</a>',
]) !!}
    </p>

    <p>
        {!! __('dashboards/widgets/welcome.intros.2', [
            'new-entity' => '<a class="btn2 btn-primary btn-xs" href="#" tabindex="0" role="button" data-pulse=".quick-creator-button" data-content="' . __('dashboards/widgets/welcome.focus.text') . '">
                <i class="fa-solid fa-plus" aria-hidden="true"></i> ' . __('crud.create') . '
            </a>',
            'letter' => '<kbd>N</kbd>',
            'characters' => '<span class="badge border select-none flex items-center gap-2"><i class="fa-solid fa-user" aria-hidden="true"></i> ' . __('entities.character') . '</span>',
            'entities' => '<a target="_blank" href="https://docs.kanka.io/en/latest/entities/overview.html" class="text-link">' . __('abilities.show.tabs.entities') . ' <i class="fa-regular fa-external-link" aria-hidden="true"></i></a>',
        ]) !!}
    </p>
    <p class="font-bold">
        {!! __('dashboards/widgets/welcome.intros.3', [
]) !!}
    </p>

    <ul class="flex flex-col gap-2">
        <li class="">
            {!! __('dashboards/widgets/welcome.tricks.1', [
    'code' => '<code>@</code>',
    'mention' => '<a target="_blank" href="https://docs.kanka.io/en/latest/features/mentions.html" class="text-link">' . __('dashboards/widgets/welcome.tricks.mention') . ' <i class="fa-regular fa-external-link" aria-hidden="true"></i></a>',
]) !!}
        </li>
        <li class="">
            {!! __('dashboards/widgets/welcome.tricks.2', [
'world' => '<a href="' . route('overview', $campaign) . '"><i class="fa-solid fa-cog" aria-hidden="true"></i> ' . __('sidebar.settings') . '</a>',
'edit' => '<span class="badge border select-none flex items-center gap-2"><i class="fa-solid fa-pencil" aria-hidden="true"></i> ' . __('campaigns.show.actions.edit') . '</span>',
]) !!}
        </li>
        <li class="">
            {!! __('dashboards/widgets/welcome.tricks.3', [
    'posts' => '<a target="_blank" href="https://docs.kanka.io/en/latest/features/posts.html" class="text-link">' . __('entities.posts') . ' <i class="fa-regular fa-external-link" aria-hidden="true"></i></a>']) !!}
        </li>
        <li class="">
            {!! __('dashboards/widgets/welcome.tricks.4', [
 'world' => '<a href="' . route('overview', $campaign) . '"><i class="fa-solid fa-cog" aria-hidden="true"></i> ' . __('sidebar.settings') . '</a>',
'members' => '<a href="' . route('campaign_users.index', $campaign) . '">' . __('campaigns.show.tabs.members') . '</a>',
]) !!}
        </li>
        <li class="">
            {!! __('dashboards/widgets/welcome.tricks.5', [
'button' => '<span class="badge border select-none flex items-center gap-2"><i class="fa-solid fa-cog" aria-hidden="true"></i> ' . __('dashboard.actions.customise') . '</span>'
]) !!}
        </li>
    </ul>
    </div>
</x-box>
