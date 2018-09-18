<!-- Main Footer -->
<footer class="main-footer">
    <div class="row">
        <div class="col-xs-4 hidden-xs hidden-sm">
            <strong>{!! trans('footer.copyright', ['year' => date('Y')]) !!} <a href="#">{{ config('app.name') }}</a> - <a href="{{ route('releases.index') }}">{{ setting('kanka.version') }}</a>.</strong> All rights reserved.
        </div>
        <div class="col-xs-4 text-center hidden-xs hidden-sm">
            <a href="mailto:#">hello@kanka.io</a>
        </div>
        <div class="col-xs-8 visible-xs visible-sm">
            <a href="mailto:#">hello@kanka.io</a>
        </div>
        <div class="col-xs-4 text-right footer-social">
            <a href="//twitter.com/kankaio" title="Twitter">
                <i class="fa fa-twitter"></i>
            </a>
            <a href="//www.facebook.com/kanka.io.ch/" title="Facebook">
                <i class="fa fa-facebook"></i>
            </a>
            <a href="//www.reddit.com/r/kanka/" title="Reddit">
                <i class="fa fa-reddit"></i>
            </a>
            <a href="//www.patreon.com/kankaio" title="Patreon" class="footer-patreon">
                <img src="/images/thirdparty/patreon-logo-colour.png" alt="Patreon" /> {{ trans('footer.patreon') }}
            </a>
        </div>
    </div>
    <!-- Default to the left -->
</footer>
