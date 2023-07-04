<?php

return [
    'privacy'   => [
        'text'      => 'Questa entità è impostata come privata. È ancora possibile definire autorizzazioni personalizzate, ma finché l\'entità è privata, queste saranno ignorate e solo i membri del ruolo :admin della campagna potranno vedere l\'entità.',
        'warning'   => 'Attenzione',
    ],
    'quick'     => [
        'empty-permissions' => 'Nessun ruolo o utente fuori dagli amministratori della campagna hanno accesso a questa entità.',
        'field'             => 'Modifica rapida',
        'manage'            => 'Gestisci i Permessi',
        'options'           => [
            'private'   => 'Privato a tutti tranne agli amministratori',
            'visible'   => 'Visibile ai seguenti',
        ],
        'private'           => 'Solo i membri del ruolo di amministratore della campagna possono attualmente vedere questa entità.',
        'public'            => 'Questa entità è attualmente visibile da qualsiasi utente o ruolo che vi abbia accesso.',
        'screen-reader'     => 'Apri impostazioni della privacy',
        'success'           => [
            'private'   => ':entity è attualmente nascosto.',
            'public'    => ':entity è attualmente visibile.',
        ],
        'title'             => 'Panoramica dei Permessi',
        'viewable-by'       => 'Visibile da',
    ],
];
