<?php

return [
    'actions'       => [
        'apply_template'    => 'Pas een Attribuutsjabloon toe',
        'manage'            => 'Beheer',
        'more'              => 'Meer opties',
        'remove_all'        => 'Verwijder Alles',
    ],
    'fields'        => [
        'attribute'             => 'Attribuut',
        'community_templates'   => 'Community Sjablonen',
        'is_private'            => 'Privé Attributen',
        'is_star'               => 'Vastgemaakt',
        'template'              => 'Sjabloon',
        'value'                 => 'Waarde',
    ],
    'helpers'       => [
        'delete_all'    => 'Weet je zeker dat je alle attributen van deze entiteit wilt verwijderen?',
    ],
    'hints'         => [
        'is_private'    => 'Je kunt alle kenmerken van een entiteit verbergen voor alle leden buiten de beheerder rol door deze privé te maken.',
    ],
    'index'         => [
        'success'   => 'Attributen voor :entity bijgewerkt.',
        'title'     => 'Attributen voor :name',
    ],
    'placeholders'  => [
        'attribute' => 'Aantal Conquests, Challenge Ratings, Initiatives, Populaties',
        'block'     => 'Blokkeer naam',
        'checkbox'  => 'Selectievak naam',
        'icon'      => [
            'class' => 'FontAwesome of RPG Awesome klasse: fas fa-gebruikers',
            'name'  => 'Pictogram naam',
        ],
        'section'   => 'Sectie naam',
        'template'  => 'Selecteer een sjabloon',
        'value'     => 'Waarde van het attribuut',
    ],
    'template'      => [
        'success'   => 'Attribuutsjabloon :name toegepast op :entity',
        'title'     => 'Pas een attribuutsjabloon toe voor :name',
    ],
    'types'         => [
        'attribute' => 'Attribuut',
        'block'     => 'Blokkeer',
        'checkbox'  => 'Selectievak',
        'icon'      => 'Pictogram',
        'section'   => 'Sectie',
        'text'      => 'Multiline Tekst',
    ],
    'visibility'    => [
        'entry'     => 'Attribuut wordt weergegeven in het entiteit menu.',
        'private'   => 'Attribuut alleen zichtbaar voor leden van de rol "Beheerder".',
        'public'    => 'Attribuut zichtbaar voor alle leden.',
        'tab'       => 'Attribuut wordt alleen weergegeven op het tabblad Attributen.',
    ],
];
