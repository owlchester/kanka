{{--@if (auth()->check() && auth()->user()->created_at->isBefore(\Carbon\Carbon::create(2024, 12, 25)))--}}
{{--    <x-tutorial code="banner_s25" type="info" :auth="true">--}}
{{--        <p>--}}
{{--            We thrive on your feedback! Take a moment to fill out our <a href="https://docs.google.com/forms/d/e/1FAIpQLSepB1v1Es2NV-7axGc8vGeyEHrIehvIHTwV-pU5frZMzKQC7w/viewform?usp=dialog" target="_blank" style="text-decoration: underline"><x-icon class="fa-regular fa-external-link" />2025 Satisfaction Survey</a> and help us improve Kanka.--}}
{{--        </p>--}}
{{--    </x-tutorial>--}}
{{--@endif--}}

{{--<x-tutorial code="banner_maria11" type="warning" :auth="false">--}}
{{--    <p>--}}
{{--        We will be performing server maintenance work on Tuesday 8th of July 2025. As a result, Kanka will be completely unavailable from <a href="https://everytimezone.com/s/7ad382aa" target="_blank" class="underline"><x-icon class="fa-regular fa-external-link" /> 14:30 UTC</a> to 15:30 UTC. This impacts Kanka, Plugins, and the API.</p>--}}

{{--    <p>--}}
{{--        Join us on <a href="https://kanka.io/go/discord" target="_blank" class="underline">Discord</a> to get live updates.--}}
{{--    </p>--}}
{{--</x-tutorial>--}}

{{--<x-tutorial code="banner_kanka30" type="warning" :auth="false">--}}
{{--    <p>--}}
{{--        We are releasing a big update on Wednesday 19th of February 2025. As a result, Kanka will be unavailable from <a href="https://everytimezone.com/s/07a5d1d9" target="_blank" class="underline"><i class="fa-regular fa-external-link" aria-hidden="true"></i> 14:30 UTC</a> to 15:30 UTC. Join us on <a href="https://kanka.io/go/discord" target="_blank" class="underline">Discord</a> to get updates.--}}
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

@can('freeTrial', auth()->user())
    <x-tutorial code="banner_free_trial" type="info">
            <p>
                {!! __('subscriptions/free-trial.pitch.title') !!}<br />

                <a href="{{ route('settings.free-trial') }}" class="font-bold underline">
                    <x-icon class="fa-duotone fa-sparkles" /> {!! __('subscriptions/free-trial.actions.accept') !!}
                </a>
            </p>

        </x-tutorial>
@endif
