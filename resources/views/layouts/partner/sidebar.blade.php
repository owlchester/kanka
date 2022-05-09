@inject('sidebar', 'App\Services\SidebarService')

<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu tree" data-widget="tree">
            <li class="{{ $sidebar->admin('referrals') }}">
                <a href="{{ route('partner.referrals') }}"><i class="fa-solid fa-user-tag"></i> <span>Referrals</span></a>
            </li>
        </ul>
    </section>
</aside>
