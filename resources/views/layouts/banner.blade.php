{{--@if (auth()->check() && auth()->user()->created_at->isBefore(\Carbon\Carbon::create(2024, 12, 25)))--}}
{{--    <x-tutorial code="banner_s25" type="info" :auth="true">--}}
{{--        <p>--}}
{{--            We thrive on your feedback! Take a moment to fill out our <a href="https://docs.google.com/forms/d/e/1FAIpQLSepB1v1Es2NV-7axGc8vGeyEHrIehvIHTwV-pU5frZMzKQC7w/viewform?usp=dialog" target="_blank" style="text-decoration: underline"><x-icon class="fa-solid fa-external-link" />2025 Satisfaction Survey</a> and help us improve Kanka.--}}
{{--        </p>--}}
{{--    </x-tutorial>--}}
{{--@endif--}}


{{--<x-tutorial code="banner_jan25" type="warning" :auth="false">--}}
{{--    <p>--}}
{{--        Kanka will be undergoing scheduled server and network maintenance on Wednesday 29th of January 2025. As a result, Kanka will be unavailable from <a href="https://everytimezone.com/s/fe312f10" target="_blank" style="text-decoration: underline"><i class="fa-solid fa-external-link" aria-hidden="true"></i> 14:15 UTC</a> to 14:25 UTC. Join us on <a href="{{ config('social.discord') }}" target="_blank"  style="text-decoration: underline">Discord</a> to get updates.--}}
{{--    </p>--}}
{{--</x-tutorial>--}}

{{--@if (auth()->check() && auth()->user()->subscriptions()->count() === 0 && \Carbon\Carbon::now()->between(\Carbon\Carbon::create('2024-11-29'), \Carbon\Carbon::create('2024-12-02')))--}}
{{--    <x-tutorial code="bf2024" type="warning">--}}
{{--        <p>--}}
{{--            <a href="{{ route('settings.subscription') }}" class="block text-warning-content">--}}
{{--                {!! __('banners.blackfriday24', ['code' => '<code>BF2024</code>']) !!}--}}
{{--            </a>--}}
{{--        </p>--}}
{{--    </x-tutorial>--}}
{{--@endif--}}
