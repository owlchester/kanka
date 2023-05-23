<?php

return [
    'privacy'   => [
        'text'      => 'Dieses Objekt ist auf privat gesetzt. Benutzerdefinierte Berechtigungen können weiterhin definiert werden, aber solange das Objekt privat ist, werden diese ignoriert, und nur Mitglieder der :admin-Rolle der Kampagne können das Objekt sehen.',
        'warning'   => 'Warning',
    ],
    'quick'     => [
        'empty-permissions' => 'Keine Rolle oder Benutzer außerhalb der Kampagnenadministratoren haben Zugriff auf dieses Objekt.',
        'field'             => 'Schnelle Bearbeitung',
        'options'           => [
            'private'   => 'Privat für alle außer Administratoren',
            'visible'   => 'Sichtbar für Folgende',
        ],
        'private'           => 'Nur Mitglieder der Administratorrolle der Kampagne können dieses Objekt derzeit sehen.',
        'public'            => 'Dieses Objekt ist derzeit von jedem Benutzer oder jeder Rolle mit Zugriff darauf sichtbar.',
        'screen-reader'     => 'Datenschutzeinstellungen öffnen',
        'success'           => [
            'private'   => ':entity ist jetzt versteckt.',
            'public'    => ':entity ist jetzt sichtbar.',
        ],
        'title'             => 'Berechtigungen',
        'viewable-by'       => 'Sichtbar für',
    ],
];
