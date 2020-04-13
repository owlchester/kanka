@extends('layouts.front', [
    'title' => trans('front.menu.privacy'),
    'menus' => [
        'privacy',
    ],
])

@section('og')
    <meta property="og:description" content="{{ trans('front.privacy.description', ['date' => (new \Carbon\Carbon('2020-04-24'))->toFormattedDateString()]) }}" />
    <meta property="og:url" content="{{ route('front.privacy') }}" />
@endsection

@section('content')
    <header class="masthead reduced-masthead">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-7 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-5">{{ trans('front.privacy.title') }}</h1>
                        <p class="mb-5">{{ trans('front.privacy.description', ['date' => (new \Carbon\Carbon('2020-04-24'))->toFormattedDateString()]) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="features" id="privacy">
        <div class="container">
            <div class="section-heading">
                <h2>INTRODUCTION</h2>

                <p class="mb-2">Kanka (“we” or “us” or “our”) respects the privacy of our users (“user” or “you”). This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website www.kanka.io, including any other media form, media channel, mobile website, or mobile application related or connected thereto (collectively, the “Site”). Please read this privacy policy carefully.  If you do not agree with the terms of this privacy policy, please do not access the site.</p>

                <p class="mb-2">We reserve the right to make changes to this Privacy Policy at any time and for any reason.  Any changes or modifications will be effective immediately upon posting the updated Privacy Policy on the Site.</p>

                <p class="mb-5">You are encouraged to periodically review this Privacy Policy to stay informed of updates. You will be deemed to have been made aware of, will be subject to, and will be deemed to have accepted the changes in any revised Privacy Policy by your continued use of the Site after the date such revised Privacy Policy is posted.</p>

                <h2 class="mb-2">COLLECTION OF YOUR INFORMATION</h2>

                <p class="mb-5">We may collect information about you in a variety of ways. The information we may collect on the Site includes:</p>

                <h3 class="mb-2">Personal Data</h3>
                <p class="mb-2">Personally identifiable information, such as your name, email address, that you voluntarily give to us when you register with the Site or when you choose to participate in various activities related to the Site, such as online chat and message boards. You are under no obligation to provide us with personal information of any kind.</p>

                <h3 class="mb-2">Derivative Data</h3>
                <p class="mb-2">Information our servers automatically collect when you access the Site, such as your IP address, your browser type, your operating system, your access times, and the pages you have viewed directly before and after accessing the Site.</p>

                <h3 class="mb-2">Financial Data</h3>
                <p class="mb-2">We store only very limited, if any, financial information that we collect. Otherwise, all financial information is stored by our payment processor, Stripe, and you are encouraged to review their privacy policy and contact them directly for responses to your questions.</p>

                <h3 class="mb-2">Third-Party Data</h3>
                <p class="mb-5">Information from third parties, such as personal information or network friends, if you connect your account to the third party and grant the Site permission to access this information.</p>

                <h2 class="mb-2">USE OF YOUR INFORMATION</h2>

                <p class="mb-2">Having accurate information about you permits us to provide you with a smooth, efficient, and customized experience.  Specifically, we may use information collected about you via the Site to:

                <ul class="mb-5">
                    <li>Compile anonymous statistical data and analysis for use internally</li>
                    <li>Create and manage your account.</li>
                    <li>Email you regarding your account.</li>
                    <li>Fulfill and manage purchases, payments, and other transactions related to the Site.</li>
                    <li>Request feedback and contact you about your use of the Site.</li>
                    <li>Resolve disputes and troubleshoot problems.</li>
                    <li>Send you a newsletter.</li>
                </ul>

                <h2 class="mb-2">DISCLOSURE OF YOUR INFORMATION</h2>

                <p class="mb-2">We may share information we have collected about you in certain situations. Your information may be disclosed as follows:</p>

                <h3 class="mb-2">By Law or to Protect Rights</h3>
                <p class="mb-2">If we believe the release of information about you is necessary to respond to legal process, to investigate or remedy potential violations of our policies, or to protect the rights, property, and safety of others, we may share your information as permitted or required by any applicable law, rule, or regulation.  This includes exchanging information with other entities for fraud protection and credit risk reduction.</p>

                <h3 class="mb-2">Interactions with Other Users</h3>
                <p class="mb-2">If you interact with other users of the Site, those users may see your name, profile photo, and descriptions of your activity.</p>

                <h3 class="mb-2">Online Postings</h3>
                <p class="mb-5">When you post comments, contributions or other content to the Site, your posts may be viewed by all users and may be publicly distributed outside the Site in perpetuity.</p>

                <h2 class="mb-2">TRACKING TECHNOLOGIES</h2>

                <h3 class="mb-2">Cookies and Web Beacons</h3>
                <p class="mb-2">We may use cookies, and other tracking technologies on the Site to help customize the Site and improve your experience. When you access the Site, your personal information is not collected through the use of tracking technology.</p>

                <h3 class="mb-2">Internet-Based Advertising</h3>
                <p class="mb-2">We do not partner with or have special relationships with any ad server companies.</p>

                <h3 class="mb-2">Website Analytics</h3>
                <p class="mb-5">We may also partner with selected third-party vendors, such as Google Analytics, to allow tracking technologies and remarketing services on the Site through the use of first party cookies and third-party cookies, to, among other things, analyze and track users’ use of the Site, determine the popularity of certain content and better understand online activity.</p>

                <h2 class="mb-2">SECURITY OF YOUR INFORMATION</h2>

                <p class="mb-5">We use administrative, technical, and physical security measures to help protect your personal information.  While we have taken reasonable steps to secure the personal information you provide to us, please be aware that despite our efforts, no security measures are perfect or impenetrable, and no method of data transmission can be guaranteed against any interception or other type of misuse.  Any information disclosed online is vulnerable to interception and misuse by unauthorized parties. Therefore, we cannot guarantee complete security if you provide personal information.</p>

                <h2 class="mb-2">OPTIONS REGARDING YOUR INFORMATION</h2>

                <h3 class="mb-2">Account Information</h3>
                <p class="mb-2">You may at any time review or change the information in your account or terminate your account by:</p>
                <ul class="mb-2">
                    <li>Logging into your account settings and updating your account</li>
                    <li>Contacting us using the contact information provided below</li>
                </ul>
                <p class="mb-5">Upon your request to terminate your account, we will deactivate or delete your account and information from our active databases.</p>

                <h3 class="mb-2">Emails and Communications</h3>
                <p class="mb-2">If you no longer wish to receive correspondence, emails, or other communications from us, you may opt-out by:</p>
                <ul class="mb-2">
                    <li>Noting your preferences at the time you register your account with the Site</li>
                    <li>Logging into your account settings and updating your preferences.</li>
                </ul>
            </div>
        </div>
    </section>
@endsection
