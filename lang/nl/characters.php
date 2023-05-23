<?php

return [
    'actions'       => [
        'add_appearance'    => 'Voeg een uiterlijk toe',
        'add_personality'   => 'Voeg een persoonlijkheid toe',
    ],
    'conversations' => [],
    'create'        => [
        'title' => 'Nieuw Personage',
    ],
    'destroy'       => [],
    'dice_rolls'    => [],
    'edit'          => [],
    'fields'        => [
        'age'                       => 'Leeftijd',
        'is_dead'                   => 'Dood',
        'is_personality_visible'    => 'Persoonlijkheid zichtbaar',
        'life'                      => 'Leven',
        'physical'                  => 'Fysiek',
        'sex'                       => 'Geslacht',
        'title'                     => 'Titel',
        'traits'                    => 'Eigenschappen',
    ],
    'helpers'       => [
        'age'   => 'Je kunt deze entiteit koppelen aan een kalender van je campaign om in plaats daarvan automatisch hun leeftijd te berekenen. :more.',
    ],
    'hints'         => [
        'is_dead'                   => 'Dit personage is dood',
        'is_personality_visible'    => 'Schakel deze optie uit om het hele persoonlijkheidsgedeelte te verbergen voor niet-beheerders.',
        'personality_not_visible'   => 'Persoonlijkheidskenmerken van dit personage zijn momenteel alleen zichtbaar voor Beheerders',
        'personality_visible'       => 'Persoonlijkheidskenmerken van dit personage zijn voor iedereen zichtbaar.',
    ],
    'index'         => [],
    'items'         => [],
    'journals'      => [],
    'maps'          => [],
    'organisations' => [
        'create'    => [
            'success'   => 'Personage toegevoegd aan organisatie.',
            'title'     => 'Nieuwe Organisatie voor :name',
        ],
        'destroy'   => [
            'success'   => 'Personage organisatie verwijderd.',
        ],
        'edit'      => [
            'success'   => 'Personage organisatie bijgewerkt.',
            'title'     => 'Werk organisatie voor :name bij',
        ],
        'fields'    => [
            'role'  => 'Rol',
        ],
    ],
    'placeholders'  => [
        'age'               => 'Leeftijd',
        'appearance_entry'  => 'Beschrijving',
        'appearance_name'   => 'Haar, Ogen, Huid, Lengte',
        'personality_entry' => 'Details',
        'personality_name'  => 'Doelen, Manieren, Angsten, Verplichtingen',
        'physical'          => 'Fysiek',
        'sex'               => 'Geslacht',
        'title'             => 'Titel',
        'traits'            => 'Eigenschappen',
        'type'              => 'NPC, Speler Personage, Godheid',
    ],
    'quests'        => [
        'helpers'   => [
            'quest_giver'   => 'Quests waarvan het personage een quest gever is.',
            'quest_member'  => 'Quests waarvan het personage lid is.',
        ],
    ],
    'sections'      => [
        'appearance'    => 'Uiterlijk',
        'personality'   => 'Persoonlijkheid',
    ],
    'show'          => [],
    'warnings'      => [
        'personality_hidden'    => 'Het is niet toegestaan om persoonlijkheidskenmerken van dit personage te bewerken.',
    ],
];
