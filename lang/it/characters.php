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
    'fields'        => [
        'age'                       => 'Età',
        'is_appearance_pinned'      => 'Aspetto fissato',
        'is_dead'                   => 'Morto',
        'is_personality_pinned'     => 'Personalità fissata',
        'is_personality_visible'    => 'Personalità visibile',
        'life'                      => 'Vita',
        'physical'                  => 'Caratteristiche fisiche',
        'pronouns'                  => 'Pronomi',
        'sex'                       => 'Sesso',
        'title'                     => 'Titolo',
        'traits'                    => 'Tratti',
    ],
    'helpers'       => [
        'age'   => 'Puoi collegare questa entità con un calendario della tua campagna per calcolare automaticamente l\'età.',
    ],
    'hints'         => [
        'is_appearance_pinned'      => 'Se selezionati, i tratti fisici del personaggio appariranno sotto la voce principale della pagina.',
        'is_dead'                   => 'Questo personaggio è morto',
        'is_personality_pinned'     => 'Se selezionati, i tratti caratteriali del personaggio appariranno sotto la voce principale della pagina.',
        'is_personality_visible'    => 'Puoi nascondere l\'intera sezione inerente la personalità per le utenze non "Admin".',
        'personality_not_visible'   => 'Solo gli amministratori possono vedere i tratti caratteriali di questo personaggio.',
        'personality_visible'       => 'Tutti possono vedere i tratti carattieriali di questo personaggio.',
    ],
    'index'         => [],
    'items'         => [],
    'journals'      => [],
    'maps'          => [],
    'organisations' => [
        'create'    => [
            'success'   => 'Personaggio aggiunto all\'organizzazione.',
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
        'appearance_name'   => 'Capelli, Occhi, Pelle, Altezza',
        'name'              => 'Nome del personaggio',
        'personality_entry' => 'Dettagli',
        'personality_name'  => 'Obbiettivi, Vezzi, Paure, Vincoli',
        'physical'          => 'Caratteristiche Fisiche',
        'pronouns'          => 'Lui, Lei',
        'sex'               => 'Sesso',
        'title'             => 'Titolo',
        'traits'            => 'Tratti',
        'type'              => 'NPC, Personaggio Giocante, Divinità',
    ],
    'quests'        => [
        'helpers'   => [
            'quest_giver'   => 'Missioni per cui il personaggio è il committente.',
            'quest_member'  => 'Missioni di cui il personaggio fa parte.',
        ],
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
