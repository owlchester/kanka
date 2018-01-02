<!-- Main Footer -->
<footer class="main-footer">
    <div class="row">
        <div class="col-md-4 hidden-xs">
            <strong>Copyright © 2017 - <?=date('Y')?> <a href="#">{{ config('app.name') }}</a> - <a href="{{ route('releases.index') }}">{{ setting('kanka.version') }}</a>.</strong> All rights reserved.
        </div>
        <div class="col-md-4 text-center">
            <a href="mailto:#">hello@kanka.io</a>
        </div>
        <div class="col-md-4 text-right footer-social hidden-xs">
            <a href="//twitter.com/kankaio" title="Twitter">
                <i class="fa fa-twitter"></i>
            </a>
            <a href="//www.facebook.com/kanka.io.ch/" title="Facebook">
                <i class="fa fa-facebook"></i>
            </a>
            <a href="//www.reddit.com/r/kanka/" title="Reddit">
                <i class="fa fa-reddit"></i>
            </a>
            <a href="//www.patreon.com/kankaio" title="Patreon">
                <i class="fa fa-gratipay"></i>
            </a>
        </div>
    </div>
    <!-- Default to the left -->
</footer>
