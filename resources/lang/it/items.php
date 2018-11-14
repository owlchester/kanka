<?php

return [
    'create'        => [
        'description'   => 'Crea un nuovo oggetto',
        'success'       => 'Oggetto \':name\' creato.',
        'title'         => 'Nuovo Oggetto',
    ],
    'destroy'       => [
        'success'   => 'Oggetto \':name\' rimosso.',
    ],
    'edit'          => [
        'success'   => 'Oggetto \':name\' aggiornato.',
        'title'     => 'Modifica Oggetto :name',
    ],
    'fields'        => [
        'character' => 'Personaggio',
        'image'     => 'Immagine',
        'location'  => 'Luogo',
        'name'      => 'Nome',
        'relation'  => 'Relazione',
        'type'      => 'Tipo',
    ],
    'index'         => [
        'add'           => 'Nuovo Oggetto',
        'description'   => 'Gestisci gli oggetti di :name.',
        'header'        => 'Oggetti di :name',
        'title'         => 'Oggetti',
    ],
    'placeholders'  => [
        'character' => 'Scegli un personaggio',
        'location'  => 'Scegli un luogo',
        'name'      => 'Nome dell\'oggetto',
        'type'      => 'Arma, Pozione, Artefatto',
    ],
    'quests'        => [
        'description'   => 'Missioni delle quali l\'oggetto fa parte',
        'title'         => 'Missioni per l\'oggetto :name',
    ],
    'show'          => [
        'description'   => 'Una vista dettagliata dell\'oggetto',
        'tabs'          => [
            'information'   => 'Informazioni',
            'quests'        => 'Missione',
        ],
        'title'         => 'Oggetto :name',
    ],
];
