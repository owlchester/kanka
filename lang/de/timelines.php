<?php

return [
    'actions'       => [
        'add_element'   => 'Fügen Sie der Epoche ein Element hinzu :era',
        'back'          => 'zurück zu :name',
        'edit'          => 'Zeitstrahl editieren',
        'save_order'    => 'neue Reihenfolge speichern',
    ],
    'create'        => [
        'title' => 'neuer Zeitstrahl',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'copy_elements' => 'Elemente kopieren',
        'copy_eras'     => 'Epoche kopieren',
        'eras'          => 'Epochen',
        'name'          => 'Name',
        'reverse_order' => 'Reihenfolge der Epochen umkehren',
        'timeline'      => 'übergeordneter Zeitstrahl',
        'timelines'     => 'Zeitstrahlen',
        'type'          => 'Typ',
    ],
    'helpers'       => [
        'nested_without'    => 'Anzeigen aller Zeitleisten ohne übergeordnete Zeitleiste. Klicken Sie auf eine Zeile, um die untergeordneten Zeitleisten anzuzeigen.',
        'no_era'            => 'Diese Zeitachse hat derzeit keine Epochen. Epochen können im Bearbeitungsbildschirm der Zeitstrahlen hinzugefügt werden, danach können Sie hier Elemente hinzufügen.',
        'reverse_order'     => 'Aktivieren Sie diese Option, um Epochen in umgekehrter chronologischer Reihenfolge anzuzeigen (ältere Epoche zuerst).',
    ],
    'index'         => [
        'title' => 'Zeitstrahl',
    ],
    'placeholders'  => [
        'name'  => 'Name des Zeitstrahls',
        'type'  => 'Grundschule, Weltchronik, Königreichserbe',
    ],
    'show'          => [
        'tabs'  => [
            'timelines' => 'Zeitstrahlen',
        ],
    ],
    'timelines'     => [
        'title' => 'Zeitstrahl :name Zeitstrahlen',
    ],
];
