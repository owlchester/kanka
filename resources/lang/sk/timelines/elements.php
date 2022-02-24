<?php

return [
    'create'        => [
        'success'   => 'Prvok pridaný na časovú os.',
        'title'     => 'Nový prvok na časovej osi',
    ],
    'delete'        => [
        'success'   => 'Prvok :name odstránený.',
    ],
    'edit'          => [
        'success'   => 'Prvok aktualizovaný.',
        'title'     => 'Upraviť prvok na časovej osi',
    ],
    'fields'        => [
        'date'              => 'Dátum',
        'era'               => 'Vek',
        'icon'              => 'Symbol',
        'use_entity_entry'  => 'Zobraziť záznam priradeného objektu nižšie. Text tohto prvku bude zobrazený ako prvý, ak nejaký existuje.',
    ],
    'helpers'       => [
        'entity_is_private' => 'Objekt tohto prvku je súkromný.',
        'icon'              => 'Skopíruj HTML kód nejakého symbolu z :fontawesome alebo :rpgawesome.',
        'is_collapsed'      => 'Prvok sa zobrazuje štandardne zbalený.',
    ],
    'placeholders'  => [
        'date'      => 'napr. 42. marec alebo 1332-1337',
        'name'      => 'Vyžadované, ak nie je vybraný žiaden objekt',
        'position'  => 'Pozícia v zozname prvkov pre daný vek. Ponechaj prázdnu, ak ju chceš pridať nakoniec.',
    ],
];
