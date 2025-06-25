<?php

return [
    'actions'   => [
        'show-old'  => 'Changes',
    ],
    'cta'       => 'Zeige ein Protokoll aller letzten Änderungen an der Kampagne an.',
    'empty'     => 'Kein Wert',
    'fields'    => [
        'action'    => 'Aktion',
        'details'   => 'Details',
        'module'    => 'Modul',
        'when'      => 'Wann',
        'who'       => 'Wer',
    ],
    'filters'   => [
        'all-actions'   => 'Alle Aktionen',
        'all-users'     => 'Alle Mitglieder',
        'no-results'    => 'Keine Ergebnisse zum Anzeigen. Versuche es mit anderen Filtern oder kehre zurück, nachdem du Änderungen an den Objekten der Kampagne vorgenommen hast.',
    ],
    'helpers'   => [
        'base'      => 'Diese Oberfläche enthält die letzten Änderungen an Objekten der Kampagne für bis zu :amount Monate, wobei die neuesten Änderungen zuerst angezeigt werden.',
        'changes'   => 'Die folgenden Felder hatten zuvor diese Werte.',
    ],
    'log'       => [
        'create'        => ':user erstellt :entity',
        'create_post'   => ':user erstellte den Beitrag  ":post" zu :entity',
        'delete'        => ':user gelöscht :entity',
        'delete_post'   => ':user löschte den Beitrag zu :entity',
        'reorder_post'  => ':user ordnete den Beitrag zu :entity neu',
        'restore'       => ':user wiederhergestellt :entity',
        'update'        => ':user aktualisiert :entity',
        'update_post'   => ':user aktualisierte den Beitrag ":post" zu :entity',
    ],
    'title'     => 'Historie',
    'unknown'   => [
        'entity'    => 'ein unbekanntes Objekt',
    ],
];
