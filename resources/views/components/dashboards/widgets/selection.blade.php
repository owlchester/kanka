<a href="#" class="flex gap-4 p-2 px-3 rounded-xl border border-base-300 items-center text-base-content hover:text-primary hover:border-primary focus:border-primary hover:shadow-xs" data-url="{{ route('campaign_dashboard_widgets.create', [$campaign, 'widget' => $widget->value, 'dashboard' => $dashboard]) }}" data-toggle="dialog">
    <x-icon class="fa-regular {{ $icon }} text-xl" />
    <div class="flex flex-col gap-0">
        <p>{{ __('dashboards/widgets/' . $widget->value . '.name') }}</p>
        <p class="text-neutral-content text-xs">
            {{ __('dashboards/widgets/' . $widget->value . '.description') }}
        </p>
    </div>
</a>
