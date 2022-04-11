@extends('layouts.front', [
    'title' => trans('front.menu.terms'),
])

@section('og')
    <meta property="og:description" content="{{ trans('front.terms.description', ['date' => (new \Carbon\Carbon('2020-04-24'))->toFormattedDateString()]) }}" />
    <meta property="og:url" content="{{ route('front.terms') }}" />
@endsection

@section('content')
    <header class="masthead reduced-masthead">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-9 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-3">{{ trans('front.terms.title') }}</h1>
                        <p class="mb-5">{{ trans('front.terms.description', ['date' => (new \Carbon\Carbon('2020-04-24'))->toFormattedDateString()]) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="features" id="terms">
        <div class="container">
            <div class="section-heading">
                <h3 class="" id="agreement-to-terms"><a href="#agreement-to-terms">AGREEMENT TO TERMS</a></h3>

                <p class="mb-3">These Terms and Conditions constitute a legally binding agreement made between you, whether personally or on behalf of an entity (“you”) and Kanka (“we,” “us” or “our”), concerning your access to and use of the www.kanka.io website as well as any other media form, media channel, mobile website or mobile application related, linked, or otherwise connected thereto (collectively, the “Site”).</p>

                <p class="mb-3">You agree that by accessing the Site, you have read, understood, and agree to be bound by all of these Terms and Conditions. We reserve the right, in our sole discretion, to make changes or modifications to these Terms and Conditions at any time and for any reason.</p>

                <p class="mb-3">It is your responsibility to periodically review these Terms and Conditions to stay informed of updates. You will be subject to, and will be deemed to have been made aware of and to have accepted, the changes in any revised Terms and Conditions by your continued use of the Site after the date such revised Terms and Conditions are posted.</p>

                <p class="mb-3">The information provided on the Site is not intended for distribution to or use by any person or entity in any jurisdiction or country where such distribution or use would be contrary to law or regulation or which would subject us to any registration requirement within such jurisdiction or country.</p>

                <h3 class="mt-4" id="user-representations"><a href="#user-representations">USER REPRESENTATIONS</a></h3>

                <p class="mb-3">By using the Site, you represent and warrant that:</p>

                <p class="mb-3">(1) you have the legal capacity and you agree to comply with these Terms and Conditions;</p>

                <p class="mb-3">(2) you will not use the Site for any illegal or unauthorized purpose;</p>

                <p class="mb-3">(3) your use of the Site will not violate any applicable law or regulation.</p>

                <h3 class="mt-4" id="user-registration"><a href="#user-registration">USER REGISTRATION</a></h3>

                <p class="mb-3">You will be required to register with the Site. You agree to keep your password confidential and will be responsible for all use of your account and password. We reserve the right to remove, reclaim, or change a username you select if we determine, in our sole discretion, that such username is inappropriate, obscene, or otherwise objectionable.</p>

                <h3 class="mt-4" id="prohibited-activities"><a href="#prohibited-activities">PROHIBITED ACTIVITIES</a></h3>

                <p class="mb-3">You may not access or use the Site for any purpose other than that for which we make the Site available. The Site may not be used in connection with any commercial endeavors except those that are specifically endorsed or approved by us.</p>

                <p class="mb-3">As a user of the Site, you agree not to:</p>

                <ol>
                <li>make any unauthorized use of the Site, including collecting usernames and/or email addresses of users by electronic or other means for the purpose of sending unsolicited email, or creating user accounts by automated means or under false pretenses.</li>
                    <li>interfere with, disrupt, or create an undue burden on the Site or the networks or services connected to the Site.</li>
                    <li>attempt to bypass any measures of the Site designed to prevent or restrict access to the Site, or any portion of the Site.</li>
                    <li>harass, annoy, intimidate, or threaten any of our employees or agents engaged in providing any portion of the Site to you.</li>
                    <li>delete the copyright or other proprietary rights notice from any Content.</li>
                    <li>upload or transmit (or attempt to upload or to transmit) viruses, Trojan horses, or other material, including excessive use of capital letters and spamming (continuous posting of repetitive text), that interferes with any party’s uninterrupted use and enjoyment of the Site or modifies, impairs, disrupts, alters, or interferes with the use, features, functions, operation, or maintenance of the Site.</li>
                    <li>use the Site in a manner inconsistent with any applicable laws or regulations.</li>
                </ol>

                <h3 class="mt-4" id="user-generated-contributions"><a href="#user-generated-contributions">USER GENERATED CONTRIBUTIONS</a></h3>

                <p class="mb-3">The Site may provide you with the opportunity to create, submit, post, display, transmit, perform, publish, distribute, or broadcast content and materials to us or on the Site, including but not limited to text, writings, video, audio, photographs, graphics, comments, suggestions, or personal information or other material (collectively, "Contributions").</p>

                <p class="mb-3">Contributions may be viewable by other users of the Site. As such, any Contributions you transmit may be treated as non-confidential and non-proprietary. When you create or make available any Contributions, you thereby represent and warrant that:</p>

                <ol>
                    <li>you are the creator and owner of or have the necessary licenses, rights, consents, releases, and permissions to use and to authorize us, the Site, and other users of the Site to use your Contributions in any manner contemplated by the Site and these Terms and Conditions.</li>
                    <li>your Contributions are not obscene, lewd, lascivious, filthy, violent, harassing, libelous, slanderous, or otherwise objectionable (as determined by us).</li>
                    <li>your Contributions do not ridicule, mock, disparage, intimidate, or abuse anyone.</li>
                    <li>your Contributions do not include any offensive comments that are connected to race, national origin, gender, sexual preference, or physical handicap.</li>
                </ol>

                <p class="mb-3">Any use of the Site in violation of the foregoing violates these Terms and Conditions and may result in, among other things, termination or suspension of your rights to use the Site.</p>



                <h3 class="mt-4" id="site-management"><a href="#site-management">SITE MANAGEMENT</a></h3>

                <p class="mb-3">We reserve the right, but not the obligation, to:</p>

                <p class="mb-3">(1) monitor the Site for violations of these Terms and Conditions;</p>

                <p class="mb-3">(2) in our sole discretion and without limitation, refuse, restrict access to, limit the availability of, or disable (to the extent technologically feasible) any of your Contributions or any portion thereof;</p>

                <p class="mb-3">(3) otherwise manage the Site in a manner designed to protect our rights and to facilitate the proper functioning of the Site.</p>

                <h3 class="mt-4" id="copyright-infringements"><a href="#copyright-infringements">COPYRIGHT INFRINGEMENTS</a></h3>

                <p class="mb-3">We respect the intellectual property rights of others. If you believe that any material available on or through the Site infringes upon any copyright you own or control, please immediately notify us using the contact information provided below (a “Notification”). A copy of your Notification will be sent to the person who posted or stored the material addressed in the Notification.</p>

                <h3 class="mt-4" id="term-and-termination"><a href="#term-and-termination">TERM AND TERMINATION</a></h3>

                <p class="mb-3">These Terms and Conditions shall remain in full force and effect while you use the Site. Without limiting any other provision of these terms and conditions, we reserve the right to, in our sole discretion and without notice or liability, deny access to and use of the site (including blocking certain IP addresses), to any person for any reason, including without limitation for breach of any representation, warranty, or covenant contained in these terms and conditions or of any applicable law or regulation. We may terminate your use or participation in the site or delete [your account and] any content or information that you posted at any time, without warning, in our sole discretion.</p>

                <p class="mb-3">If we terminate or suspend your account for any reason, you are prohibited from registering and creating a new account under your name, a fake or borrowed name, or the name of any third party, even if you may be acting on behalf of the third party.</p>

                <p class="mb-3">In addition to terminating or suspending your account, we reserve the right to take appropriate legal action, including without limitation pursuing civil, criminal, and injunctive redress.</p>

                <h3 class="mt-4" id="modifications-and-interruptions"><a href="#modifications-and-interruptions">MODIFICATIONS AND INTERRUPTIONS</a></h3>

                <p class="mb-3">We cannot guarantee the Site will be available at all times. We may experience hardware, software, or other problems or need to perform maintenance related to the Site, resulting in interruptions, delays, or errors.</p>

                <p class="mb-3">We reserve the right to change, revise, update, suspend, discontinue, or otherwise modify the Site at any time or for any reason without notice. You agree that we have no liability whatsoever for any loss, damage, or inconvenience caused by your inability to access or use the Site during any downtime or discontinuance of the Site.</p>

                <h3 class="mt-4" id="user-data"><a href="#user-data">USER DATA</a></h3>

                <p class="mb-3">We will maintain certain data that you transmit to the Site for the purpose of managing the Site, as well as data relating to your use of the Site. Although we perform regular routine backups of data, you are solely responsible for all data that you transmit or that relates to any activity you have undertaken using the Site.</p>

                <h3 class="mt-4" id="miscellaneous"><a href="#miscellaneous">MISCELLANEOUS</a></h3>

                <p class="mb-3">These Terms and Conditions and any policies or operating rules posted by us on the Site constitute the entire agreement and understanding between you and us. Our failure to exercise or enforce any right or provision of these Terms and Conditions shall not operate as a waiver of such right or provision.</p>

                <p class="mb-3">If any provision or part of a provision of these Terms and Conditions is determined to be unlawful, void, or unenforceable, that provision or part of the provision is deemed severable from these Terms and Conditions and does not affect the validity and enforceability of any remaining provisions.</p>

            </div>
        </div>
    </section>
@endsection
