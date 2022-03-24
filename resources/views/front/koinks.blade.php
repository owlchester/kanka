@extends('layouts.front', [
    'title' => 'Kanka Koinks',
    'active' => 'koinks',
    'skipPerf' => true,
])

@section('og')
    <meta property="og:description" content="Introducing Kanka Koinks!" />
    <meta property="og:url" content="{{ route('front.koinks') }}" />
@endsection

@section('content')
    <header class="masthead reduced-masthead" id="about">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-md-9">
                    <div class="header-content mx-auto">
                        <h1 class="mb-3">Introducing KOINKS!</h1>
                        <p class="mb-3">With the help of our amazing community and experts in the worldbuilding and cryptocurrency world, we've spent last two years building the KAPPY network. Today we are ready to release it into Kanka, and expect many of your favourite worldbuilding websites to start using them soon.</p>

                        <p class="mb-5">Koinks are a worldbuilding-focused, eco-friendly, murderhobo-free cryptocurrency that will power the future of worldbuilding and TTRPGs.</p>
                    </div>
                </div>
                <div class="col-md-3 mt-md-5 text-center">
                    <img src="/images/koink_large.png" class="profile-subscriber" title="Koinks" />
                    <div class="text-uppercase">Koinks</div>
                </div>
            </div>
        </div>
    </header>

    <section class="team" id="team">
        <div class="container">
            <div class="section-body">
                <h1>FAQ</h1>

                <h3>What are Koinks?</h3>
                <p>We've been building the Koink Action Payment Portal Yummies (KAPPY) network with experts in the cryoptocurrency and worldbuilding sphere for the past two years. Along with our partners, we started mining Koinks in secret before the end of 2021 to accumulate Koinks into a central pool.</p>

                <h3 class="mt-5">How come I already have koinks?</h3>
                <p>When logged in, you will see your number of available Koinks in the top-right, between your notifications and user profile picture. Koinks were granted based on how long you've actively been using Kanka during the past five years, pooling from the Koinks that were mind during the past few months.</p>

                <h3 class="mt-5">How to get more Koinks?</h3>
                <p>Whenever an element is created in Kanka or in our partner applications, that element is sent to the decentralised KAPPY network for analysis. Various notes will then attribute a worldbuilding score from 0 to 1, with 1 being the highest, to each element. The network will then compare the results between nodes, and form a consensus on the worldbuilding quality and potential of the created element, and assign a number of Koinks to the KWallet based on the score.</p>

                <h3 class="mt-5">What about new accounts?</h3>
                <p>Staying true to our moto of worldbuilding shouldn't be limited by your financial situation, we've reserved a pool of Koinks for new users that get attributed at random when they create a new account. We'll be supplying that pool of Koinks with Koinks that users spend worldbuilding in Kanka. These initial Koinks should be enough for new users to start worldbuilding quality content, thus generating more Koinks for their account.</p>

                <h3 class="mt-5">How to use Koinks?</h3>
                <p>Most actions in Kanka and our partner's worldbuilding apps now costs Koinks. Creating a new character in Kanka for example costs 15 koinks, while editing one costs only 6. Creating a new relation costs 5, while deleting it costs 1. We've invested tremendous amounts of time to figure out what actions generate the most worldbuilding potential in Kanka, and applied costs based on that research. As everything we do, we'll be listening to community feedback on tweaking these values.</p>

                <h3 class="mt-5">Is the KAPPY network really eco-friendly?</h3>
                <p>Absolutely! Instead of being powered by electricity, which can be costly and polluting, the KAPPY network runs on <i>worldbuilding potential</i>. The more quality worldbuilding is submitted to the network, the more power it has to generate more Koinks.</p>

                <h3 class="mt-5">Exciting! How can I learn more and get involved?</h3>
                <p>We are thrilled that you share our excitement! If you are an independent wanting to show love, set up your own KAPPY node, or have a worldbuilding tool you want connected to the KAPPY network, contact us on our <a href="{{ config('social.discord') }}" target="_blank">Discord</a>.</p>
            </div>
        </div>
    </section>
@endsection
