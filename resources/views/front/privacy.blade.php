@extends('layouts.front', [
    'title' => __('front.menu.privacy'),
    'menus' => [
        'privacy',
    ],
])

@section('og')
    <meta property="og:description" content="{{ __('front.privacy.description', ['date' => (new \Carbon\Carbon('2023-07-12'))->toFormattedDateString()]) }}" />
    <meta property="og:url" content="{{ route('front.privacy') }}" />

@endsection

@section('content')
    <section class="features" id="privacy">
        <div class="container">
            <div class="section-heading">
                <div class="mb-5">
                    <h1 class="display-4">{{ __('front.privacy.title') }}</h1>
                    <p class="lead">{{ __('front.privacy.description', ['date' => (new \Carbon\Carbon('2023-07-12'))->toFormattedDateString()]) }}</p>
                </div>
                <h2>Topics</h2>

                <ul class="mb-5">
                    <li>
                        <a href="#what-data-do-we-collect">What data do we collect and for how long?</a>
                    </li>
                    <li>
                        <a href="#how-do-we-collect">How do we collect your data?</a>
                    </li>
                    <li>
                        <a href="#how-will-we-use">How will we use your data?</a>
                    </li>
                    <li>
                        <a href="#how-do-we-store">How do we store your data?</a>
                    </li>
                    <li>
                        <a href="#cookies">Cookies</a>
                    </li>
                    <li>
                        <a href="#what-kind-of-cookies">What kind of cookies do we use?</a>
                    </li>
                    <li>
                        <a href="#why-cookies">What do we use these cookies for?</a>
                    </li>
                    <li>
                        <a href="#how-to-manage">How to manage your cookies</a>
                    </li>
                    <li>
                        <a href="#privacy-policies-of-others">Privacy policies of other websites</a>
                    </li>
                    <li>
                        <a href="#changes-to-our-policy">Changes to our privacy policy</a>
                    </li>
                    <li>
                        <a href="#how-to-contact-us">How to contact us</a>
                    </li>
                </ul>


                <h2 id="what-data-do-we-collect">What data do we collect and for how long?</h2>

                <p class="mb-2">Kanka collects the following data:</p>

                <ul class="mb-2">
                    <li>Information about your connection, such as your IP address and browser type</li>
                    <li>Personal identification information (login, email address, etc.)</li>
                </ul>

                <p class="mb-2">We keep your profile information and content for the duration of your account.</p>
                <p class="mb-2">We keep your IP address for a maximum of 30 days.</p>
                <p class="mb-5">We keep other personally identifiable data we collect for a maximum of 3 months.</p>

                <h2 id="how-do-we-collect">How do we collect your data?</h2>

                <p class="mb-2">You directly provide Kanka with most of the data we collect. We collect data and process data when you:</p>

                <ul class="mb-5">
                    <li>Use or view our website.</li>
                    <li>Register online or make a purchase.</li>
                    <li>Voluntarily complete a customer survey or provide feedback on any platform that we use or via email.</li>
                </ul>

                <h2 id="how-will-we-use">How will we use your data?</h2>

                <p class="mb-2">Kanka collects your data so that we can:</p>

                <ul class="mb-5">
                    <li>Manage your account and process your purchases.</li>
                    <li>Measure and analyse the effectiveness of our products and services and to better understand how you use them in order to improve.
                        Communicate with you about our products and services, including about updates and changes to our policies and terms.</li>
                    <li>Use information you share with us, or that we collect to conduct surveys, testing, and troubleshooting to help us operate and improve Kanka.
                    <li>When we process a purchase, we may send your data to, and also use the resulting information from, credit reference agencies to prevent fraudulent purchases.</li>
                </ul>

                <h2 id="how-do-we-store">How do we store your data?</h2>

                <p class="mb-5">We securely store your data on our servers which are with Hetzner in Germany and Amazon cloud Europe.</p>

                <h2 id="cookies">Cookies</h2>

                <p class="mb-5">Cookies are text files placed on your computer to collect standard Internet log information and visitor behaviour information. When you visit our websites, we may collect information from you automatically through cookies or similar technology.</p>

                <h2 id="what-kind-of-cookies">What kind of cookies do you use?</h2>

                <p class="mb-2">We use cookies in a range of ways to improve your experience on our website, including:</p>

                <ul class="mb-5">
                    <li>Authentication, security, and user preferences.</li>
                    <li>Analytics and research.</li>
                    <li>Advertising and marketing.</li>
                </ul>

                <h2 id="why-cookies">What do you use these cookies for?</h2>

                <p class="mb-2">Cookies help us in different ways:</p>
                <ul class="mb-5">
                    <li>Functionality – We use these cookies so that we recognise you on our website and remember your previously selected preferences. This includes automatic login, or which campaign you were invited to if registering through an invite link.</li>
                    <li>Advertising – This allows us to personalise ads and measure performance, like showing you ads and evaluating their effectiveness based on your visits to our ad partners' websites. This helps advertisers provide you with high-quality ads and content that may be more interesting to you.</li>
                    <li>Analytics – These help us understand and improve how people use our services, including buttons and widgets. This helps us optimise your experience by understanding how you interact with our services.</li>
                </ul>

                <h2 id="how-to-manage">How to manage your cookies</h2>

                <p class="mb-5">You can set your browser not to accept cookies. However, some of our website features may not function as a result.</p>

                <h2 id="privacy-policies-of-others">Privacy policies of other websites</h2>

                <p class="mb-5">The Kanka website contains links to other websites. Our privacy policy applies only to our website, so if you click on a link to another website, you should read their privacy policy.</p>

                <h2 id="changes-to-our-policy">Changes to our privacy policy</h2>

                <p class="mb-5">We keep our privacy policy under regular review and publish all updates on this web page. This privacy policy was last updated on 12th of July 2023.</p>

                <h2 id="how-to-contact-us">How to contact us</h2>

                <p class="mb-2">If you have any questions about Kanka’s privacy policy, the data we hold on you, or you would like to exercise one of your data protection rights, please do not hesitate to contact us.</p>

                <p class="mb-2">Email us at: <a href="mailto:{{ config('app.email') }}">{{ config('app.email') }}</a></p>

            </div>
        </div>
    </section>
@endsection
