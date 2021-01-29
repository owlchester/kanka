<li class="{{ request()->get('tab') == 'entity' ? 'active' : null }}">
    <a href="#entity">{{ __('menu_links.fields.entity') }}</a>
</li>
<li class="{{ request()->get('tab') == 'type' ? 'active' : null }}">
    <a href="#type">{{ __('menu_links.fields.type') }}</a>
</li>
<li class="{{ request()->get('tab') == 'random' ? 'active' : null }}">
    <a href="#random">{{ __('menu_links.fields.random') }}</a>
</li>
<li class="{{ request()->get('tab') == 'dashboard' ? 'active' : null }}">
    <a href="#dashboard">{{ __('menu_links.fields.dashboard') }}</a>
</li>
