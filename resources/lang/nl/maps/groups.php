<?php

return [
    'actions'       => [
        'add'   => 'Voeg een nieuwe groep toe',
    ],
    'create'        => [
        'success'   => 'Groep :name gemaakt',
        'title'     => 'Nieuwe Groep',
    ],
    'delete'        => [
        'success'   => 'Groep :name verwijderd',
    ],
    'edit'          => [
        'success'   => 'Groep :name bijgewerkt',
        'title'     => 'Wijzig Groep :name',
    ],
    'fields'        => [
        'is_shown'  => 'Toon groepsmarkeringen',
        'position'  => 'Positie',
    ],
    'helper'        => [
        'amount'            => 'Een markering kan aan een groep worden toegevoegd, zodat je alle Winkels van een stad kunt tonen of verbergen. Een kaart kan maximaal :amount groepen hebben.',
        'boosted_campaign'  => ':boosted kan maximaal :amount groepen bevatten.',
    ],
    'hints'         => [
        'is_shown'  => 'Indien aangevinkt, worden de groepsmarkeringen standaard op de kaart getoond.',
    ],
    'placeholders'  => [
        'name'      => 'Winkels, Schatten, NPCs',
        'position'  => 'Optioneel veld om de volgorde in te stellen waarin de groepen verschijnen.',
    ],
];
