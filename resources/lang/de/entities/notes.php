<?php

return [
    'actions'       => [
        'add'       => 'Notiz hinzufügen',
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
        'is_pinned' => 'gepinnt',
        'name'      => 'Name',
        'position'  => 'gepinnte Position',
    ],
    'hint'          => 'Informationen, die nicht ganz in die Standardfelder eines Objektes passen oder privat bleiben sollen, können als Notiz hinzugefügt werden.',
    'hints'         => [
        'is_pinned' => 'Angeheftete Objektnotizen werden unter dem Objekttext in der primären Objektansicht angezeigt. Kombinieren Sie mit dem Positionsfeld, um zu steuern, in welcher Reihenfolge angeheftete Objektnotizen angezeigt werden.',
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
