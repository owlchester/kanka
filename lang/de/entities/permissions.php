<?php

return [
    'quick' => [
        'empty-permissions' => 'Keine Rolle oder Benutzer außerhalb der Kampagnenadministratoren haben Zugriff auf dieses Objekt.',
        'field'             => 'Schnelle Bearbeitung',
        'options'           => [
            'private'   => 'Privat für alle außer Administratoren',
            'visible'   => 'Sichtbar für Folgende',
        ],
        'private'           => 'Nur Mitglieder der Administratorrolle der Kampagne können dieses Objekt derzeit sehen.',
        'public'            => 'Dieses Objekt ist derzeit von jedem Benutzer oder jeder Rolle mit Zugriff darauf sichtbar.',
        'success'           => [
            'private'   => ':entity ist jetzt versteckt.',
            'public'    => ':entity ist jetzt sichtbar.',
        ],
        'title'             => 'Berechtigungen',
        'viewable-by'       => 'Sichtbar für',
    ],
];
