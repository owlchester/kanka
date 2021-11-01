<?php

return [
    'actions'       => [
        'add'       => 'Notiz hinzufügen',
        'add_role'  => 'Rolle hinzufügen',
        'add_user'  => 'Benutzer hinzufügen',
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
        'collapsed' => 'Schließen Sie die angeheftete Objektnotiz standardmäßig',
        'creator'   => 'Ersteller',
        'entry'     => 'Eintrag',
        'name'      => 'Name',
    ],
    'footer'        => [
        'created'   => 'Erstellt von :user am :date',
        'updated'   => 'Aktualisiert von :user am :date',
    ],
    'hint'          => 'Informationen, die nicht ganz in die Standardfelder eines Objektes passen oder privat bleiben sollen, können als Notiz hinzugefügt werden.',
    'hints'         => [
        'reorder'   => 'Sie können Objektnotizen eines Objekts neu anordnen, indem Sie im Menü des Objekts auf das :icon-Symbol neben der Story klicken.',
    ],
    'index'         => [
        'title' => 'Notizen für :name',
    ],
    'placeholders'  => [
        'name'  => 'Name der Notiz, Beobachtung oder Anmerkung',
    ],
    'show'          => [
        'advanced'  => 'Erweiterte Berechtigungen',
        'title'     => 'Objektnotiz :name für :entity',
    ],
];
