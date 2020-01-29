@extends('layouts.front', [
    'title' => trans('front.menu.privacy'),
    'menus' => [
        'privacy',
    ],
])
@section('content')
    <header class="masthead reduced-masthead">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-7 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-5">{{ trans('front.privacy.title') }}</h1>
                        <p class="mb-5">{{ trans('front.privacy.description') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="features" id="privacy">
        <div class="container">
            <div class="section-heading">
                <h3>Information gathering and usage</h3>
                <p>When registering for Kanka we ask for information such as your name and email address. Your information is only used internally and won't be shared with others.</p>

                <p>Kanka collects the email addresses of those who communicate with us via email, and information submitted through voluntary activities such as site registrations or participation in surveys. Kanka also collects aggregated, anonymous user data regarding app usage. The user data we collect is used to improve Kanka and the quality of our service. We only collect personal data that is required to provide our services, and we only store it insofar that it is necessary to deliver these services.</p>
                <p><br /></p>
                <h3>Your data</h3>
                <p>Kanka uses third party vendors and hosting partners to provide the necessary hardware, software, networking, storage, and related technology required to run Kanka. Although Kanka owns the code, databases, and all rights to the Kanka application, you retain all rights to your data. We will never share your personal data with a 3rd party without your prior authorization, and we will never sell data to 3rd parties. We process data inside of the European Union and Switzerland. We transfer data with third-parties necessary to our ability to provide our services, all of whom are GDPR-compliant and provide the necessary safeguards required if they are outside of the EU.</p>
                <p><br /></p>

                <h3>Cookies</h3>
                <p>We use cookies to store visitors preferences, customize Web page content based on visitors browser type or other information that the visitor sends. Cookies are required to use Kanka.</p>
                <p><br /></p>

                <h3>Ad servers</h3>
                <p>We do not partner with or have special relationships with any ad server companies.</p>
                <p><br /></p>

                <h3>Security</h3>
                <p>All data and information transmitted with Service is secured by SSL protocol.</p>
                <p><br /></p>

                <h3>Changes</h3>
                <p>If our information practices change at some time in the future we will post the policy changes to our Web site to notify you of these changes and we will use for these new purposes only data collected from the time of the policy change forward. If you are concerned about how your information is used, you should check back at our Web site periodically.</p>
                <p><br /></p>
            </div>
        </div>
    </section>
@endsection