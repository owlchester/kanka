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
        'price'     => 'Prezzo',
        'relation'  => 'Relazione',
        'size'      => 'Taglia',
        'type'      => 'Tipo',
    ],
    'index'         => [
        'add'           => 'Nuovo Oggetto',
        'description'   => 'Gestisci gli oggetti di :name.',
        'header'        => 'Oggetti di :name',
        'title'         => 'Oggetti',
    ],
    'inventories'   => [
        'description'   => 'Inventari delle entità in cui si trova l\'oggetto.',
        'title'         => 'Inventari dell\'oggetto :name',
    ],
    'placeholders'  => [
        'character' => 'Scegli un personaggio',
        'location'  => 'Scegli un luogo',
        'name'      => 'Nome dell\'oggetto',
        'price'     => 'Prezzo dell\'oggetto',
        'size'      => 'Taglia, Peso, Dimensioni',
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
            'inventories'   => 'Inventari',
            'quests'        => 'Missione',
        ],
        'title'         => 'Oggetto :name',
    ],
];
