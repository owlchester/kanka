<?php

return [
    'actions'       => [
        'add_appearance'    => 'Aggiungi un dettaglio dell\'aspetto fisico',
        'add_personality'   => 'Aggiungi un tratto della personalità',
    ],
    'conversations' => [],
    'create'        => [
        'title' => 'Nuovo Personaggio',
    ],
    'destroy'       => [],
    'dice_rolls'    => [],
    'edit'          => [],
    'families'      => [
        'reorder'   => [
            'success'   => 'Famiglie del personaggio aggiornate con successo.',
        ],
        'title'     => 'Gestisci le famiglie di :name',
    ],
    'fields'        => [
        'age'                       => 'Età',
        'is_appearance_pinned'      => 'Aspetto fissato',
        'is_dead'                   => 'Morto',
        'is_personality_pinned'     => 'Personalità fissata',
        'is_personality_visible'    => 'Personalità visibile',
        'life'                      => 'Vita',
        'physical'                  => 'Caratteristiche fisiche',
        'pronouns'                  => 'Pronomi',
        'sex'                       => 'Genere',
        'title'                     => 'Titolo',
        'traits'                    => 'Tratti',
    ],
    'helpers'       => [
        'age'   => 'Puoi collegare questa entità con un calendario della tua campagna per calcolare automaticamente l\'età. :more',
    ],
    'hints'         => [
        'is_appearance_pinned'      => 'Se selezionati, i tratti fisici del personaggio appariranno sotto la voce principale della pagina.',
        'is_dead'                   => 'Questo personaggio è morto',
        'is_personality_pinned'     => 'Se selezionati, i tratti caratteriali del personaggio appariranno sotto la voce principale della pagina.',
        'is_personality_visible'    => 'I tratti della personalità sono visibili a tutti, non solo ai membri del ruolo di :admin.',
        'personality_not_visible'   => 'Solo gli amministratori possono vedere i tratti caratteriali di questo personaggio.',
        'personality_visible'       => 'Tutti possono vedere i tratti carattieriali di questo personaggio.',
    ],
    'index'         => [],
    'items'         => [],
    'journals'      => [],
    'labels'        => [
        'appearance'    => [
            'entry' => 'Descrizione dell\'aspetto',
            'name'  => 'Nome dell\'aspetto',
        ],
        'personality'   => [
            'entry' => 'Descrizione dei tratti della personalità',
            'name'  => 'Nome dei tratti della personalità',
        ],
    ],
    'maps'          => [],
    'organisations' => [
        'create'    => [
            'success'   => ':character aggiunto a :organisation.',
            'title'     => 'Nuova organizzazione per :name',
        ],
        'destroy'   => [
            'success'   => 'Organizzazione del personaggio rimossa.',
        ],
        'edit'      => [
            'success'   => 'Organizzazione del personaggio aggiornata.',
            'title'     => 'Organizzazione aggiornata per :name',
        ],
        'fields'    => [
            'role'  => 'Ruolo',
        ],
    ],
    'placeholders'  => [
        'age'               => 'Età',
        'appearance_entry'  => 'Descrizione',
        'appearance_name'   => 'Capelli, Occhi, Carnagione, Altezza',
        'name'              => 'Nome del personaggio',
        'personality_entry' => 'Dettagli',
        'personality_name'  => 'Obbiettivi, Vezzi, Paure, Legami',
        'physical'          => 'Caratteristiche Fisiche',
        'pronouns'          => 'Lui, Lei, Loro',
        'sex'               => 'Genere',
        'title'             => 'Titolo',
        'traits'            => 'Tratti',
        'type'              => 'PNG, Personaggio Giocante, Divinità',
    ],
    'quests'        => [
        'helpers'   => [
            'quest_giver'   => 'Missioni per cui il personaggio è il committente.',
            'quest_member'  => 'Missioni di cui il personaggio fa parte.',
        ],
    ],
    'races'         => [
        'reorder'   => [
            'success'   => 'Stirpi del personaggio aggiornate con successo',
        ],
        'title'     => 'Gestisci le stirpi di :name',
    ],
    'sections'      => [
        'appearance'    => 'Aspetto',
        'personality'   => 'Personalità',
    ],
    'show'          => [],
    'warnings'      => [
        'personality_hidden'    => 'Non puoi modificare i tratti della personalità di questo personaggio.',
    ],
];
