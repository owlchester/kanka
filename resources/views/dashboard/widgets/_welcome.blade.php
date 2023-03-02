<div class="panel panel-default widget-welcome" id="dashboard-widget-{{ $widget->id }}">
    <div class="panel-heading">
        <h3 class="panel-title">
            {{ __('dashboards/widgets/welcome.title', ['kanka' => config('app.name')]) }}
        </h3>
    </div>
    <div class="panel-body">
        <p>
            {!! __('dashboards/widgets/welcome.intros.1', [
    'user' => auth()->check() ? '<strong>' . auth()->user()->name . '</strong>' : __('crud.users.unknown'),
    'characters' => link_to_route('characters.index', __('entities.characters')),
    'locations' => link_to_route('locations.index', __('entities.locations')),
    ]) !!}
        </p>
            {!! __('dashboards/widgets/welcome.intros.2', [
        'new-entity' => '<a class="btn btn-primary btn-xs" href="#" tabindex="0" role="button" data-pulse="#qq-sidebar-btn">
            <i class="fa-solid fa-plus" aria-hidden="true"></i> ' . __('sidebar.new-entity') . '
        </a>',
        'letter' => '<kbd>N</kbd>',
        'characters' => '<span class="label label-default"><i class="fa-solid fa-user" aria-hidden="true"></i> ' . __('entities.character') . '</span>',
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
    'world' => '<span class="label label-default"><i class="fa-solid fa-globe" aria-hidden="true"></i> ' . __('sidebar.world') . '</span>',
    'edit' => '<span class="label label-default"><i class="fa-solid fa-pencil" aria-hidden="true"></i> ' . __('campaigns.show.actions.edit') . '</span>',
]) !!}
            </li>
            <li class="mb-2">
                {!! __('dashboards/widgets/welcome.tricks.3', [
        'posts' => link_to('https://docs.kanka.io/en/latest/features/posts.html', __('entities.posts') . ' <i class="fa-solid fa-external-link" aria-hidden="true"></i>', ['target' => '_blank'], null, false)]) !!}
            </li>
            <li class="mb-2">
                {!! __('dashboards/widgets/welcome.tricks.4', [
     'world' => '<span class="label label-default"><i class="fa-solid fa-globe" aria-hidden="true"></i> ' . __('sidebar.world') . '</span>',
    'members' => '<span class="label label-default">' . __('campaigns.show.tabs.members') . '</span>',
]) !!}
            </li>
            <li class="mb-2">
                {!! __('dashboards/widgets/welcome.tricks.5', [
    'button' => '<span class="label label-default"><i class="fa-solid fa-cog" aria-hidden="true"></i> ' . __('dashboard.settings.title') . '</span>'
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
        'kb' => link_to_route('front.faqs.index', __('front.menu.kb')),
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
        'public-campaigns' => link_to(route('front.public_campaigns'), __('front.menu.campaigns'))
    ]) !!}
            </li>
            <li class="mb-2">
                {!! __('dashboards/widgets/welcome.endings.4', [
        'supporting-us' => link_to_route('settings.subscription', __('dashboards/widgets/welcome.endings.supporting-us'))
    ]) !!}
            </li>
        </ul>
    </div>

</div>
