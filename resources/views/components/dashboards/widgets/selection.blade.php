<a href="#" class="flex gap-3 p-3 rounded-xl border border-base-200 items-center text-base-content hover:shadow" data-url="{{ route('campaign_dashboard_widgets.create', [$campaign, 'widget' => $widget->value, 'dashboard' => $dashboard]) }}" data-toggle="dialog">
    <div class="flex-none rounded-lg w-10 h-10 flex items-center justify-center {{ $setupClass }}">
        <x-icon class="fa-regular {{ $icon }} text-lg" />
    </div>
    <div class="grow flex flex-col gap-0">
        <span class="font-medium">{{ __('dashboards/widgets/' . $widget->value . '.name') }}</span>
        <p class="text-neutral-content text-xs">
            {{ __('dashboards/widgets/' . $widget->value . '.description') }}
        </p>
    </div>
</a>
