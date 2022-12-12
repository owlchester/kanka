<?php

return [
    'actions'       => [
        'add_appearance'    => 'Aggiungi un dettaglio dell\'aspetto fisico',
        'add_organisation'  => 'Aggiungi un\'organizzazione',
        'add_personality'   => 'Aggiungi un tratto della personalità',
    ],
    'conversations' => [
        'title' => 'Conversazioni del Personaggio :name',
    ],
    'create'        => [
        'title' => 'Nuovo Personaggio',
    ],
    'destroy'       => [],
    'dice_rolls'    => [
        'hint'  => 'I tiri di dado possono essere assegnati ad un personaggio per essere utilizzati durante la partita.',
        'title' => 'Tiri di dado del Personaggio :name',
    ],
    'edit'          => [],
    'fields'        => [
        'age'                       => 'Età',
        'families'                  => 'Famiglie',
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
    'items'         => [
        'hint'  => 'Gli oggetti possono essere assegnati ai personaggi e risulteranno essere visibili nei loro dettagli.',
        'title' => 'Oggetti del Personaggio :name',
    ],
    'journals'      => [
        'title' => 'Pagine del Diario del Personaggio :name.',
    ],
    'maps'          => [
        'title' => 'Mappa delle Relazioni del Personaggio :name',
    ],
    'organisations' => [
        'actions'       => [
            'add'   => 'Aggiungi organizzazione',
        ],
        'create'        => [
            'success'   => 'Personaggio aggiunto all\'organizzazione.',
            'title'     => 'Nuova organizzazione per :name',
        ],
        'destroy'       => [
            'success'   => 'Organizzazione del personaggio rimossa.',
        ],
        'edit'          => [
            'success'   => 'Organizzazione del personaggio aggiornata.',
            'title'     => 'Organizzazione aggiornata per :name',
        ],
        'fields'        => [
            'organisation'  => 'Organizzazione',
            'role'          => 'Ruolo',
        ],
        'hint'          => 'I personaggi possono fare parte di più organizzazioni rappresentando per chi lavorano o di quale società segreta fanno parte.',
        'placeholders'  => [
            'organisation'  => 'Seleziona un\'organizzazione...',
        ],
        'title'         => 'Organizzazioni del Personaggio :name',
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
        'general'       => 'Informazioni generali',
        'personality'   => 'Personalità',
    ],
    'show'          => [
        'tabs'  => [
            'organisations' => 'Organizzazioni',
        ],
    ],
    'warnings'      => [
        'personality_hidden'    => 'Non puoi modificare i tratti della personalità di questo personaggio.',
    ],
];
