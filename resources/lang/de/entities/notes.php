<?php

return [
    'actions'       => [
        'add'   => 'Notiz hinzufügen',
    ],
    'create'        => [
        'description'   => 'Erstelle eine neue Notiz',
        'success'       => 'Notiz \':name\' zu :entity hinzugefügt.',
        'title'         => 'Neue Notiz für :name',
    ],
    'destroy'       => [
        'success'   => 'Notiz \':name\' von :entity entfernt.',
    ],
    'edit'          => [
        'description'   => 'Aktualisiere eine bestehende Notiz',
        'success'       => 'Notiz \':name\' für :entity aktualisiert.',
        'title'         => 'Aktualisiere Notiz für :name',
    ],
    'fields'        => [
        'creator'   => 'Ersteller',
        'entry'     => 'Eintrag',
        'name'      => 'Name',
    ],
    'hint'          => 'Informationen, die nicht ganz in die Standardfelder eines Objektes passen oder privat bleiben sollen, können als Notiz hinzugefügt werden.',
    'index'         => [
        'title' => 'Notizen für :name',
    ],
    'placeholders'  => [
        'name'  => 'Name der Notiz, Beobachtung oder Anmerkung',
    ],
    'show'          => [
        'title' => 'Objektnotiz :name für :entity',
    ],
];
