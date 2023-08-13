<x-box css="widget-welcome" id="dashboard-widget-{{ $widget->id }}">
    <h4 class="text-lg mb-2">
        {{ __('dashboards/widgets/welcome.title', ['kanka' => config('app.name')]) }}
    </h4>
    <p>
        {!! __('dashboards/widgets/welcome.intros.1', [
'user' => auth()->check() ? '<strong>' . auth()->user()->name . '</strong>' : __('crud.users.unknown'),
'characters' => link_to_route('characters.index', __('entities.characters'), [$campaign]),
'locations' => link_to_route('locations.index', __('entities.locations'), [$campaign]),
]) !!}
    </p>

    <p>
        {!! __('dashboards/widgets/welcome.intros.2', [
            'new-entity' => '<a class="btn2 btn-primary btn-xs" href="#" tabindex="0" role="button" data-pulse="#qq-sidebar-btn">
                <i class="fa-solid fa-plus" aria-hidden="true"></i> ' . __('sidebar.new-entity') . '
            </a>',
            'letter' => '<kbd>N</kbd>',
            'characters' => '<span class="badge select-none flex items-center gap-2"><i class="fa-solid fa-user" aria-hidden="true"></i> ' . __('entities.character') . '</span>',
            'entities' => link_to('https://docs.kanka.io/en/latest/entities/overview.html', __('abilities.show.tabs.entities') . ' <i class="fa-solid fa-external-link" aria-hidden="true"></i>', ['target' => '_blank'], null, false),
        ]) !!}
    </p>
    <p class="font-bold">
        {!! __('dashboards/widgets/welcome.intros.3', [
]) !!}
    </p>

    <ul class="">
        <li class="mb-2">
            {!! __('dashboards/widgets/welcome.tricks.1', [
    'code' => '<code>@</code>',
    'mention' => link_to('https://docs.kanka.io/en/latest/features/mentions.html', __('dashboards/widgets/welcome.tricks.mention') . ' <i class="fa-solid fa-external-link" aria-hidden="true"></i>', ['target' => '_blank'], null, false)
]) !!}
        </li>
        <li class="mb-2">
            {!! __('dashboards/widgets/welcome.tricks.2', [
'world' => '<span class="badge select-none flex items-center gap-2"><i class="fa-solid fa-globe" aria-hidden="true"></i> ' . __('sidebar.world') . '</span>',
'edit' => '<span class="badge select-none flex items-center gap-2"><i class="fa-solid fa-pencil" aria-hidden="true"></i> ' . __('campaigns.show.actions.edit') . '</span>',
]) !!}
        </li>
        <li class="mb-2">
            {!! __('dashboards/widgets/welcome.tricks.3', [
    'posts' => link_to('https://docs.kanka.io/en/latest/features/posts.html', __('entities.posts') . ' <i class="fa-solid fa-external-link" aria-hidden="true"></i>', ['target' => '_blank'], null, false)]) !!}
        </li>
        <li class="mb-2">
            {!! __('dashboards/widgets/welcome.tricks.4', [
 'world' => '<span class="badge select-none flex items-center gap-2"><i class="fa-solid fa-globe" aria-hidden="true"></i> ' . __('sidebar.world') . '</span>',
'members' => '<span class="badge select-none flex items-center gap-2">' . __('campaigns.show.tabs.members') . '</span>',
]) !!}
        </li>
        <li class="mb-2">
            {!! __('dashboards/widgets/welcome.tricks.5', [
'button' => '<span class="badge select-none flex items-center gap-2"><i class="fa-solid fa-cog" aria-hidden="true"></i> ' . __('dashboard.settings.title') . '</span>'
]) !!}
        </li>
    </ul>


    <p class="font-bold">
        {!! __('dashboards/widgets/welcome.endings.lead', [
    ]) !!}
    </p>
    <ul class="">
        <li class="mb-2">
            {!! __('dashboards/widgets/welcome.endings.1', [
    'kb' => link_to('https://kanka.io/kb', __('front.menu.kb')),
    'documentation' => link_to('https://docs.kanka.io', __('front.menu.documentation'))
]) !!}
        </li>
        <li class="mb-2">
            {!! __('dashboards/widgets/welcome.endings.2', [
    'discord' => link_to(config('social.discord'), 'Discord', ['target' => 'discord'])
]) !!}
        </li>
        <li class="mb-2">
            {!! __('dashboards/widgets/welcome.endings.3', [
    'public-campaigns' => link_to('https://kanka.io/campaigns', __('front.menu.campaigns'))
]) !!}
        </li>
        <li class="mb-2">
            {!! __('dashboards/widgets/welcome.endings.4', [
    'supporting-us' => link_to_route('settings.subscription', __('dashboards/widgets/welcome.endings.supporting-us'))
]) !!}
        </li>
    </ul>

</x-box>
