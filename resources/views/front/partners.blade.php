@extends('layouts.front', [
    'title' => __('front.partners.title'),
])
@section('content')

    <header class="masthead reduced-masthead" id="partner">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-9 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-3">{{ __('front.partners.title') }}</h1>
                        <p class="mb-5">{{ __('front.partners.description') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="features" id="partners">
        <div class="container">
            <div class="section-body">

                <div class="row">
                    <div class="col-lg-6">
                        <div class="card mb-5 mb-lg-0">
                            <div class="card-body">
                                <h5 class="card-title text-uppercase text-center">
                                    <img src="/images/front/partners/gramel.png" alt="Gramel Books" title="Gramel Books" width="64" />
                                    <a href="https://www.facebook.com/wydawnictwo.gramel" target="_blank" rel="nofollow noref">Gramel Books</a>
                                </h5>
                                <p class="text-muted text-justify">Gramel Books is small Polish RPG publisher, responsible for Polish editions of Savage Worlds, Dungeon World, Monsterhearts, Beyond the Wall and Other Adventures or Eclipse Phase. They've also published a few English-language supplements for Savage Worlds, most notably Beasts and Barbarians and Tropicana, as well as a simplistic game system called Adventurers. Publishing and playing tabletop RPGs is their passion and favourite past-time for more than 20 years, and they are proud and happy to be part of Kanka project!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
