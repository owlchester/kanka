<?php

return [
    'actions'       => [
        'add_appearance'    => 'Lägg till ett utseende',
        'add_organisation'  => 'Lägg till en oranisation',
        'add_personality'   => 'Lägg till en personlighet',
    ],
    'conversations' => [
        'title' => 'Karaktär :name Konversationer',
    ],
    'create'        => [
        'success'   => 'Karaktär \':name\' skapad.',
        'title'     => 'Ny Karaktär',
    ],
    'destroy'       => [
        'success'   => 'Karaktär \':name\' borttagen.',
    ],
    'dice_rolls'    => [
        'hint'  => 'Tärningskast kan tilldelas till en karaktär för användning i spel.',
        'title' => 'Karaktär :name Tärningskast',
    ],
    'edit'          => [
        'success'   => 'Karaktär \':name\' uppdaterad.',
        'title'     => 'Redigera Karaktär :name',
    ],
    'fields'        => [
        'age'                       => 'Ålder',
        'family'                    => 'Familj',
        'image'                     => 'Bild',
        'is_dead'                   => 'Död',
        'is_personality_visible'    => 'Personlighet synlig',
        'life'                      => 'Liv',
        'location'                  => 'Plats',
        'name'                      => 'Namn',
        'physical'                  => 'Fysiskt',
        'race'                      => 'Ras',
        'relation'                  => 'Förbindelse',
        'sex'                       => 'Kön',
        'title'                     => 'Titel',
        'traits'                    => 'Karaktärsdrag',
        'type'                      => 'Typ',
    ],
    'helpers'       => [
        'age'   => 'Du kan länka denna entitet med en kalender för att istället automatiskt räkna ut dennes ålder. :more.',
    ],
    'hints'         => [
        'is_dead'                   => 'Denna karaktär är död',
        'is_personality_visible'    => 'Bocka ur det här alternativet för att dölja hela personlighets sektionen för icke-Admin användare.',
        'personality_not_visible'   => 'Personlighetsdrag för den här karaktären är för tillfället bara synliga för Admin användare.',
        'personality_visible'       => 'Personlighetsdrag för denna karaktär är synliga för alla.',
    ],
    'index'         => [
        'actions'   => [
            'random'    => 'Ny Slumpad Karaktär',
        ],
        'add'       => 'Ny Karaktär',
        'header'    => 'Karaktärer i :name',
        'title'     => 'Karktärer',
    ],
    'items'         => [
        'hint'  => 'Föremål kan tilldelas till karaktärer och kommer visas här.',
        'title' => 'Karaktär :name Föremål',
    ],
    'journals'      => [
        'title' => 'Karaktär :name Journaler',
    ],
    'maps'          => [
        'title' => 'Karaktär :name Förbindelse Karta',
    ],
    'organisations' => [
        'actions'       => [
            'add'   => 'Lägg till organisation',
        ],
        'create'        => [
            'success'   => 'Karaktär tillagd till organisation.',
            'title'     => 'Ny Organisation för :name',
        ],
        'destroy'       => [
            'success'   => 'Karaktär organisation borttagen.',
        ],
        'edit'          => [
            'success'   => 'Karaktär organisation uppdaterad.',
            'title'     => 'Uppdatera Organisation för :name',
        ],
        'fields'        => [
            'organisation'  => 'Organisation',
            'role'          => 'Roll',
        ],
        'hint'          => 'Karaktärer kan vara en del av många organisationer, det representerar vilka de arbetar för eller vilket hemligt sällskap dom är en del av.',
        'placeholders'  => [
            'organisation'  => 'Välj en organisation...',
        ],
        'title'         => 'Karaktär :name Organisationer',
    ],
    'placeholders'  => [
        'age'               => 'Ålder',
        'appearance_entry'  => 'Beskrivning',
        'appearance_name'   => 'Hår, Ögon, Hud, Längd',
        'family'            => 'Välj en karaktär',
        'image'             => 'Bild',
        'location'          => 'Välj en plats',
        'name'              => 'Namn',
        'personality_entry' => 'Detaljer',
        'personality_name'  => 'Mål, Manér, Rädslor, Tillgivenheter',
        'physical'          => 'Fysiskt',
        'race'              => 'Ras',
        'sex'               => 'Kön',
        'title'             => 'Titel',
        'traits'            => 'Kraktärsdrag',
        'type'              => 'SLP, Spelarkaraktär, Gudomlighet',
    ],
    'quests'        => [
        'helpers'   => [
            'quest_giver'   => 'Uppdrag som karaktären är en uppdragsgivare för.',
            'quest_member'  => 'Uppdrag som karaktären är en medlem av.',
        ],
    ],
    'sections'      => [
        'appearance'    => 'Utseende',
        'general'       => 'Generell information',
        'personality'   => 'Personlighet',
    ],
    'show'          => [
        'tabs'  => [
            'map'           => 'Förbindelse Karta',
            'organisations' => 'Organisationer',
        ],
        'title' => 'Karaktär :name',
    ],
    'warnings'      => [
        'personality_hidden'    => 'Du är inte tillåten att redigera personlighetsdrag på denna karaktär.',
    ],
];
