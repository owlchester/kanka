<?php

return [
    'create'        => [],
    'destroy'       => [
        'success'   => 'Relatie :target verwijderd voor :entity',
    ],
    'fields'        => [
        'attitude'  => 'Attitude',
        'target'    => 'Doel',
        'two_way'   => 'Maak spiegelrelatie',
    ],
    'helper'        => 'Zet relaties op tussen entiteiten met attitudes en zichtbaarheid. Relaties kunnen ook worden vastgemaakt aan het menu van de entiteit.',
    'hints'         => [
        'attitude'  => 'Dit optionele veld kan worden gebruikt om de standaardvolgorde in relaties in aflopende volgorde te definiëren.',
        'two_way'   => 'Als je ervoor kiest om een spiegelrelatie te maken, wordt dezelfde relatie op het doel gemaakt. Als je er echter een bewerkt, wordt de spiegel niet bijgewerkt.',
    ],
    'placeholders'  => [
        'attitude'  => '-100 tot 100, waarbij 100 zeer positief is',
    ],
    'show'          => [
        'title' => 'Relaties voor :name',
    ],
    'types'         => [
        'family_member'         => 'Familielid',
        'organisation_member'   => 'Organisatie Lid',
    ],
    'update'        => [
        'success'   => 'Relatie :target bijgewerkt voor :entity.',
        'title'     => 'Werk relaties bij voor :name',
    ],
];
