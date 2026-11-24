<aside class="main-sidebar main-sidebar-placeholder z-840 flex flex-col transition-all duration-150" @if ($user->avatar) style="--sidebar-placeholder: url('{{ Img::for($user->avatar)->crop(240, 208)->url() }}')" @endif>
    <section class="sidebar-campaign relative h-36 flex-none overflow-hidden flex items-end">
        <div class="hidden md:flex absolute top-2 right-2 items-center gap-1 z-10">
            @if (auth()->check() && !\App\Facades\Identity::isImpersonating())
                <button
                    type="button"
                    data-sidebar-action="worlds"
                    data-tooltip
                    data-title="{{ __('entities.campaigns') }}"
                    aria-label="{{ __('entities.campaigns') }}"
                    class="size-8 rounded-lg bg-black/35 hover:bg-black/55 text-white/90 hover:text-white backdrop-blur-sm inline-flex items-center justify-center transition-colors cursor-pointer"
                >
                    <x-icon class="fa-regular fa-earth-americas text-sm" />
                </button>
            @endif
            <button
                type="button"
                data-sidebar-action="toggle"
                data-tooltip
                data-html="true"
                data-title="{{ __('crud.keyboard-shortcut', ['code' => '<code>]</code>']) }}"
                aria-label="{{ __('header.toggle_navigation') }}"
                class="size-8 rounded-lg bg-black/35 hover:bg-black/55 text-white/90 hover:text-white backdrop-blur-sm inline-flex items-center justify-center transition-colors cursor-pointer"
            >
                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect width="18" height="18" x="3" y="3" rx="2" />
                    <path d="M9 3v18" />
                    <path d="m16 15-3-3 3-3" />
                </svg>
            </button>
        </div>
        <div class="px-4 py-4">
            <div class="campaign-head">
                <div class="campaign-name truncate text-xl">
                    {{ $user->name }}
                </div>
            </div>
        </div>
    </section>
    <section class="sidebar grow">
        <ul class="sidebar-menu overflow-hidden whitespace-no-wrap list-none m-0 p-0">
            <li class="px-2 {{ $active('profile') }}">
                <x-sidebar.element
                    :url="route('settings.profile')"
                    icon="fa-regular fa-user"
                    :text="__('settings.menu.profile')"
                ></x-sidebar.element>
            </li>
            <li class="px-2 {{ $active('account') }}">
                <x-sidebar.element
                    :url="route('settings.account')"
                    icon="fa-regular fa-lock"
                    :text="__('settings.menu.account')"
                ></x-sidebar.element>
            </li>
            <li class="px-2 {{ $active('security') }}">
                <x-sidebar.element
                    :url="route('settings.security')"
                    icon="fa-regular fa-shield"
                    :text="__('settings.menu.security')"
                ></x-sidebar.element>
            </li>
            <li class="px-2 {{ $active('appearance') }}">
                <x-sidebar.element
                    :url="route('settings.appearance')"
                    icon="fa-regular fa-swatchbook"
                    :text="__('settings.menu.appearance')"
                ></x-sidebar.element>
            </li>
            <li class="px-2 {{ $active('newsletter') }}">
                <x-sidebar.element
                    :url="route('settings.newsletter')"
                    icon="fa-regular fa-bell"
                    :text="__('settings.menu.notifications')"
                ></x-sidebar.element>
            </li>

            <li class="section-subscription pt-3">
                <x-sidebar.section :text="__('settings.menu.subscription')" />
                <ul class="sidebar-submenu list-none p-0 m-0">
                    @if (config('services.stripe.enabled'))
                        <li class="px-2 {{ $active('subscription') }} subsection">
                            <x-sidebar.element
                                :url="route('settings.subscription')"
                                icon="fa-regular fa-heart"
                                :text="__('billing/menu.overview')"
                            ></x-sidebar.element>
                        </li>
                        @if (auth()->user()->hasLegacyBoosterNomenclature())
                            <li class="px-2 {{ $active('boosters') }} subsection">
                                <x-sidebar.element
                                    :url="route('settings.boost')"
                                    icon="fa-regular fa-rocket"
                                    :text="__('settings.menu.boosters')"
                                ></x-sidebar.element>
                            </li>
                        @else
                            <li class="px-2 {{ $active('premium') }} subsection">
                                <x-sidebar.element
                                    :url="route('settings.premium')"
                                    icon="fa-regular fa-gem"
                                    :text="__('settings.menu.premium')"
                                ></x-sidebar.element>
                            </li>
                        @endif
                    @endif

                    @if (config('services.stripe.enabled'))
                        <li class="px-2 {{ $active('payment-method', 3) }} subsection">
                            <x-sidebar.element
                                :url="route('billing.payment-method')"
                                icon="fa-regular fa-credit-card"
                                :text="__('billing/menu.payment-method')"
                            ></x-sidebar.element>
                        </li>
                        <li class="px-2 {{ $active('history', 3) }} subsection">
                            <x-sidebar.element
                                :url="route('billing.history')"
                                icon="fa-regular fa-receipt"
                                :text="__('billing/menu.history')"
                            ></x-sidebar.element>
                        </li>
                    @endif
                </ul>
            </li>

            <li class="section-other pt-3">
                <x-sidebar.section :text="__('settings.menu.other')" />

                <ul class="sidebar-submenu list-none p-0 m-0">
                    @if (auth()->user()->isLegacyPatron() || app()->isLocal())
                        <li class="px-2 {{ $active('patreon') }} subsection">
                            <x-sidebar.element
                                :url="route('settings.patreon')"
                                icon="fa-brands fa-patreon"
                                :text="__('settings.menu.patreon')"
                            ></x-sidebar.element>
                        </li>@endif

                    <li class="px-2 {{ $active('apps') }} subsection">
                        <x-sidebar.element
                            :url="route('settings.apps')"
                            icon="fa-brands fa-discord"
                            :text="__('settings.menu.apps')"
                        ></x-sidebar.element>
                    </li>
                        <li class="px-2 {{ $active('referrals') }} subsection">
                            <x-sidebar.element
                                :url="route('settings.referrals')"
                                icon="fa-regular fa-users"
                                :text="__('settings.referrals.title')"
                            ></x-sidebar.element>
                        </li>
                    <li class="px-2 {{ $active('api') }} subsection">
                        <x-sidebar.element
                            :url="route('settings.api')"
                            icon="fa-regular fa-code"
                            :text="__('settings.menu.api')"
                        ></x-sidebar.element>
                    </li>
                </ul>
            </li>

        </ul>
    </section>
    @include('layouts.sidebars._user')
</aside>
