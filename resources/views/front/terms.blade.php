@extends('layouts.front', [
    'title' => trans('front.menu.terms'),
])
@section('content')
    <header class="masthead reduced-masthead">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-7 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-5">{{ trans('front.terms.title') }}</h1>
                        <p class="mb-5">{{ trans('front.terms.description') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="features" id="terms">
        <div class="container">
            <div class="section-heading">
                <h3>Your Content</h3>
                <p class="mb-3">In these Terms and Conditions, “Your Content” shall mean any text, images or other material you choose to display on this Website.</p>
                <p class="mb-3">Your Content must be your own and must not be invading any third-party's rights. Kanka reserves the right to remove any of Your Content from this Website at any time without notice.</p>

                <p class="mb-2">Furthermore, as a condition of use, you promise not to use Kanka for any purpose that is unlawful or prohibited by these terms, or any other purpose not reasonably intended by Kanka. By way of example, and not as a limitation, you agree not to use Kanka:</p>
                <ul>
                    <li>To abuse, harass, threaten, impersonate or intimidate any person;</li>
                    <li>To communicate with Kanka representatives or other users in an abusive or offensive manner;</li>
                    <li>To post or transmit, or cause to be posted or transmitted, any Content that is libellous, defamatory, obscene, pornographic, abusive, offensive, profane, or that infringes any copyright;</li>
                    <li>To create or transmit unwanted ‘spam’ to any person or any URL;</li>
                </ul>
            </div>
        </div>
    </section>
@endsection
