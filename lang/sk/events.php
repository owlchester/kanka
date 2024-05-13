<?php

return [
    'create'        => [
        'title' => 'Nová udalosť',
    ],
    'destroy'       => [],
    'edit'          => [],
    'events'        => [
        'helper'    => 'Udalosti, ktoré majú tento objekt ako ich nadradený, sa zobrazujú tu.',
    ],
    'fields'        => [
        'date'  => 'Dátum',
    ],
    'helpers'       => [
        'date'  => 'Toto pole môže obsahovať čokoľvek a nie je prepojené s kalendármi kampane. Na zobrazenie tejto udalosti v kalendári je nutné ju pridať do kalendára alebo do karty Pripomienky tejto udalosti.',
    ],
    'index'         => [],
    'placeholders'  => [
        'date'  => 'Dátum tvojej udalosti',
        'type'  => 'ceremónia, festival, katastrofa, bitva, narodenie',
    ],
    'show'          => [],
    'tabs'          => [
        'calendars' => 'Záznamy v kalendári',
    ],
];
