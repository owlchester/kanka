<x-box class="widget-help" id="dashboard-widget-{{ $widget->id }}">
    <span class="widget-title block text-lg mb-3">
        {{ __('dashboards/widgets/help.title') }}
    </span>
    <div class="">
        <ul class="flex flex-col gap-2 lg:gap-3 xl:gap-4 list-none m-0 px-1">
        <li>
            <a href="https://docs.kanka.io/" class="text-link">
               <x-icon class="fa-regular fa-book" />
               {{ __('footer.documentation') }}
            </a>
        </li>
        <li>
            <a href="{{ \App\Facades\Domain::toFront('kb') }}" class="text-link">
               <x-icon class="fa-regular fa-question-circle" />
               {{ __('footer.kb') }}
            </a>
        </li>
        <li>
            <a href="{{ \App\Facades\Domain::toFront('go/discord') }}" class="text-link">
               <x-icon class="fa-brands fa-discord" />
               Discord
            </a>
        </li>
            <li>
                <a href="{{ \App\Facades\Domain::toFront('campaigns') }}" class="text-link">
                    <x-icon class="fa-regular fa-globe" />
                    {{ __('footer.public-campaigns') }}
                </a>
            </li>
            <li>
                <a href="{{ route('settings.subscription') }}" class="text-link">
                    <x-icon class="fa-regular fa-gem" />
                    {{ trim(__('misc.ads.member'), '.') }}
                </a>
            </li>
        </ul>
    </div>
</x-box>
