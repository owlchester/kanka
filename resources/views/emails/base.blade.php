<!DOCTYPE html>
<html lang="en">
<head>

    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
</head>
<body>
<style>
    body {
        padding: 0;
        margin: 0;
    }
    .primary {
        padding-bottom: 20px;
        font-family: 'Open Sans', sans-serif;
        background-color: #eee;
    }
    .content {
        border-radius: 15px;
        max-width: 700px;
        background-color: #fff;
        padding: 20px;
        margin: -200px auto 60px auto;
        left: 0;
        right: 0;
    }
    .header {
        height: 420px !important;
    }
    .footer {
        text-align: center;
        padding-top: 20px;
        padding-bottom: 20px;
        background-color: #eee;
        margin-top: 35px;
        border-radius: 5px;
        font-size: 0.8rem;
    }

    .social {
        margin-right: 5px;
        margin-left: 5px;
        color: white;
    }

    .mail-btn {
        padding: 10px 20px;
        border-radius: 20px;
        background-color: #1919ad;
        color: #efefef;
        text-decoration: none;
        margin: 20px 0;
        display: inline-block;
    }
    .main-btn:hover {
        font-weight: 900;
    }

    @media(max-width: 992px) {
        .content {
            width: auto;
            margin: 0 10%;
        }
    }
    @media(max-width: 768px) {
        .content {
            width: auto;
            margin: 0 5%
        }
    }
</style>
<div class="primary">

    <div class="header" style="background-image: url(https://kanka-app-assets.s3.amazonaws.com/emails/email-banner.jpg); background-position: top center; background-size: cover; width: 100%; height: 220px; text-align: center;">
        <a href="{{ route('home', ['utm_source' => ($utmSource ?? 'notification'), 'utm_medium' => 'email', 'utm_campaign' => ($utmCampaign ?? 'notification')]) }}">
            <img src="https://th.kanka.io/cHKXasGfCKw8sQTzvc2ujNmni_A=/120x120/smart/src/app/logos/kanka-logo-large.png" alt="Kanka logo" title="Kanka logo" style="margin: 50px;" width="120px" height="120px">
        </a>
    </div>

    <div class="content" style="background-color: #fff; padding: 20px;">
        @yield('content')

        <div class="footer">
            <p>
                <a href="https://{{ config('social.discord') }}" class="social" target="discord" title="Discord" rel="noreferrer">
                    <img src="https://d3a4xjr8r2ldhu.cloudfront.net/app/socials/discord-brands.png" /></a>
                <a href="https://{{ config('social.facebook') }}" class="social" target="facebook" title="Facebook" rel="noreferrer">
                    <img src="https://d3a4xjr8r2ldhu.cloudfront.net/app/socials/facebook-brands.png" /></a>
                <a href="https://{{ config('social.instagram') }}" class="social" target="instagram" title="Instagram" rel="noreferrer">
                    <img src="https://d3a4xjr8r2ldhu.cloudfront.net/app/socials/instagram-brands.png" /></a>
                <a href="https://{{ config('social.youtube') }}" class="social" target="youtube" title="Youtube" rel="noreferrer">
                    <img src="https://d3a4xjr8r2ldhu.cloudfront.net/app/socials/youtube-brands.png" /></a>
                <a href="https://{{ config('social.twitter') }}" class="social" target="twitter" title="Twitter" rel="noreferrer">
                    <img src="https://d3a4xjr8r2ldhu.cloudfront.net/app/socials/twitter-brands.png" /></a>
            </p>

            @if (!empty($user))
                <i>This email was automatically sent to {{ $user->email }} by <a href="https://kanka.io">Kanka.io</a>.</i>
            @endif

            <p class="copy">Copyright &copy; {{ date('Y') }} Owlchester SNC</p>
        </div>
    </div>
</div>
</body>
</html>
