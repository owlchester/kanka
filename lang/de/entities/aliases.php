<?php

return [
    'actions'       => [
        'add'   => 'Alias hinzufügen',
    ],
    'create'        => [
        'helper'    => 'Erstelle einen Alias für :name, damit er in der globalen Suche und durch :code-Erwähnungen gefunden werden kann.',
        'success'   => 'Alias ​​:name zu :entity hinzugefügt.',
        'title'     => 'Add an alias to :name',
    ],
    'destroy'       => [
        'success'   => 'Aliasname: Name entfernt.',
    ],
    'fields'        => [
        'name'  => 'Name',
    ],
    'helpers'       => [
        'primary'   => 'Das Festlegen eines oder mehrerer Aliase für das Objekt macht sie in der globalen Suche (obere Leiste) und durch Erwähnungen auffindbar.',
    ],
    'pitch'         => 'Erstelle Aliase für dieses Objekt, um es einfach über die Suche und Erwähnungen zu finden.',
    'placeholders'  => [
        'name'  => 'Neuer Alias',
    ],
    'unboosted'     => [],
    'update'        => [
        'success'   => 'Alias ​​:name für :entity aktualisiert.',
        'title'     => 'Alias ​​für :name aktualisieren',
    ],
];
