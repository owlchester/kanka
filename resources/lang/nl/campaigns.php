<?php

return [
    'create'                            => [
        'description'           => 'Maak een nieuwe campaign',
        'helper'                => [
            'title'     => 'Welkom :name',
            'welcome'   => <<<'TEXT'
Voordat je verder gaat, moet je een campaign naam kiezen. Dit is de naam van jouw wereld. Als je nog geen goede naam hebt, hoef je je geen zorgen te maken, je kunt deze altijd later wijzigen of meerdere campaigns maken.

Bedankt dat je lid bent geworden van Kanka en welkom bij onze bloeiende gemeenschap!
TEXT
,
        ],
        'success'               => 'Campaign gemaakt.',
        'success_first_time'    => 'Je campaign is gemaakt! Aangezien het je eerste campaign is, hebben we een paar dingen bedacht om je op weg te helpen en hopelijk een beetje inspiratie te bieden voor wat je kunt doen.',
        'title'                 => 'Nieuwe Campaign',
    ],
    'destroy'                           => [
        'success'   => 'Campaign verwijderd.',
    ],
    'edit'                              => [
        'description'   => 'Campaign wijzigen',
        'success'       => 'Campaign bijgewerkt.',
        'title'         => 'Wijzig Campaign :campaign',
    ],
    'entity_note_visibility'            => [
        'pinned'    => 'Zet nieuwe entiteit notities vast',
    ],
    'entity_personality_visibilities'   => [
        'private'   => 'Nieuwe personages hebben standaard hun persoonlijkheid privé.',
    ],
    'entity_visibilities'               => [
        'private'   => 'Nieuwe entiteiten zijn privé',
    ],
    'errors'                            => [
        'access'        => 'Je hebt geen toegang tot deze campaign.',
        'superboosted'  => 'Deze functie is alleen beschikbaar voor superboost-campaigns.',
        'unknown_id'    => 'Onbekende Campaign.',
    ],
    'export'                            => [
        'description'   => 'Exporteer Campaign.',
        'errors'        => [
            'limit' => 'Je hebt je maximum van één export per dag overschreden. Probeer het morgen opnieuw.',
        ],
        'helper'        => 'Exporteer je campaign. Een melding met een downloadlink wordt beschikbaar gesteld.',
        'success'       => 'Je campaign-export wordt voorbereid. Je ontvangt een melding in Kanka voor een downloadbare zip zodra deze klaar is.',
        'title'         => 'Campaign :name Exporteren',
    ],
    'fields'                            => [
        'css'                           => 'CSS',
        'description'                   => 'Omschrijving',
        'entity_count'                  => 'Entiteit Telling',
        'entity_note_visibility'        => 'Entiteit Notities Vastgemaakt',
        'entity_personality_visibility' => 'Personage Persoonlijkheid Zichtbaarheid',
        'entity_visibility'             => 'Entiteit Zichtbaarheid',
        'excerpt'                       => 'Excerpt',
        'followers'                     => 'Volgers',
        'header_image'                  => 'Header Afbeelding',
        'hide_history'                  => 'Verberg entiteit geschiedenis',
        'hide_members'                  => 'Verberg campaign leden',
        'image'                         => 'Afbeelding',
        'locale'                        => 'Lokale',
        'name'                          => 'Naam',
        'public_campaign_filters'       => 'Openbare Campaign Filters',
        'related_visibility'            => 'Gerelateerde Elementen Zichtbaarheid',
        'rpg_system'                    => 'RPG Systemen',
        'system'                        => 'Systeem',
        'theme'                         => 'Thema',
        'visibility'                    => 'Zichtbaarheid',
    ],
    'following'                         => 'Volgend',
];
