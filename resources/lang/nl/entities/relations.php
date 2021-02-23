<?php

return [
    'create'        => [
        'success'   => 'Relatie :target toegevoegd aan :entity.',
        'title'     => 'Nieuwe relatie voor :name',
    ],
    'destroy'       => [
        'success'   => 'Relatie :target verwijderd voor :entity',
    ],
    'fields'        => [
        'attitude'          => 'Attitude',
        'is_star'           => 'Vastgemaakt',
        'relation'          => 'Relatie',
        'target'            => 'Doel',
        'target_relation'   => 'Doel Relatie',
        'two_way'           => 'Maak spiegelrelatie',
    ],
    'helper'        => 'Zet relaties op tussen entiteiten met attitudes en zichtbaarheid. Relaties kunnen ook worden vastgemaakt aan het menu van de entiteit.',
    'hints'         => [
        'attitude'  => 'Dit optionele veld kan worden gebruikt om de standaardvolgorde in relaties in aflopende volgorde te definiëren.',
        'mirrored'  => [
            'text'  => 'Deze relatie is gespiegeld met :link.',
            'title' => 'Gespiegeld',
        ],
        'two_way'   => 'Als je ervoor kiest om een spiegelrelatie te maken, wordt dezelfde relatie op het doel gemaakt. Als je er echter een bewerkt, wordt de spiegel niet bijgewerkt.',
    ],
    'placeholders'  => [
        'attitude'  => '-100 tot 100, waarbij 100 zeer positief is',
        'relation'  => 'Rivaal, Beste Vriend, Broer of Zus',
        'target'    => 'Kies een entiteit',
    ],
    'show'          => [
        'title' => 'Relaties voor :name',
    ],
    'teaser'        => 'Geef de campaign een boost om toegang te krijgen tot de relatiesverkenner. Klik voor meer informatie over boosted campaigns.',
    'types'         => [
        'family_member'         => 'Familielid',
        'organisation_member'   => 'Organisatie Lid',
    ],
    'update'        => [
        'success'   => 'Relatie :target bijgewerkt voor :entity.',
        'title'     => 'Werk relaties bij voor :name',
    ],
];
