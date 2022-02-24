<?php

return [
    'create'        => [
        'success'       => 'Missione \':name\' creata.',
        'title'         => 'Nuova Missione',
    ],
    'destroy'       => [
        'success'   => 'Missione \':name\' rimossa.',
    ],
    'edit'          => [
        'success'       => 'Missione \':name\' aggiornata.',
        'title'         => 'Modifica la missione :name',
    ],
    'fields'        => [
        'character'     => 'Istigatore',
        'date'          => 'Data',
        'description'   => 'Descrizione',
        'image'         => 'Immagine',
        'is_completed'  => 'Completata',
        'name'          => 'Nome',
        'quest'         => 'Missione Padre',
        'quests'        => 'Sotto-Missioni',
        'role'          => 'Ruolo',
        'type'          => 'Tipo',
    ],
    'helpers'       => [
        'nested'    => 'Quando ci si trova nella vista annidata puoi vedere le tue Missioni in maniera annidata. Missioni senza genitori saranno mostrate in maniera predefinita. Missioni con discendenti potranno essere premute per vederne i figli. Potrai continuare ad espandere le missioni fino a quando non ci saranno più figli da mostrare.',
    ],
    'hints'         => [
        'quests'    => 'Una ragnatela di missioni interconnesse può essere costruita utilizzando il campo "Missione Padre".',
    ],
    'index'         => [
        'add'           => 'Nuova Missione',
        'header'        => 'Missioni di :name',
        'title'         => 'Missioni',
    ],
    'placeholders'  => [
        'date'  => 'Data del mondo reale per la missione',
        'name'  => 'Nome della missione',
        'quest' => 'Missione Padre',
        'role'  => 'Il ruolo dell\'entità nella missione',
        'type'  => 'Personaggio, Missione Secondaria, Missione Principale',
    ],
    'show'          => [
        'actions'       => [

        ],
        'tabs'          => [
            'quests'        => 'Missioni',
        ],
        'title'         => 'Missione :name',
    ],
];
