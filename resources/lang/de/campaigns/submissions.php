<?php

return [
    'actions'       => [
        'accept'    => 'akzeptieren',
        'reject'    => 'ablehnen',
    ],
    'apply'         => [
        'apply'         => 'anwenden',
        'help'          => 'Diese Kampagne steht neuen Mitgliedern offen. Um sich anzumelden, füllen Sie das Formular aus. Sie werden benachrichtigt, wenn die Kampagnenadministratoren Ihre Bewerbung überprüfen.',
        'remove_text'   => 'Ihre Einreichung',
        'success'       => [
            'apply' => 'Ihre Bewerbung wurde gespeichert. Sie können sie jederzeit ändern oder abbrechen. Sie werden benachrichtigt, wenn die Kampagnenadministratoren dies überprüfen.',
            'remove'=> 'Ihre Bewerbung wurde entfernt.',
            'update'=> 'Ihre Bewerbung wurde aktualisiert. Sie können sie jederzeit ändern oder abbrechen. Sie werden benachrichtigt, wenn die Kampagnenadministratoren dies überprüfen.',
        ],
        'title'         => 'beitreten :name',
    ],
    'errors'        => [
        'not_open'  => 'Die Kampagne ist nicht öffentlich für neue Mitglieder. Bearbeiten Sie die Einstellungen der Kampagne, wenn Sie zulassen möchten, dass Benutzer sich für die Kampagne bewerben.',
    ],
    'fields'        => [
        'application'   => 'Bewerbung',
        'rejection'     => 'Ablehnungsgrund',
    ],
    'helpers'       => [
        'open_and_public'   => 'Die Kampagne akzeptiert Bewerbungen für die Teilnahme. Um dies zu beenden, bearbeiten Sie die Kampagne und ändern Sie die offene Einstellung auf der Registerkarte :tab.',
    ],
    'placeholders'  => [
        'note'  => 'Notieren Sie Ihre Bewerbung für die Teilnahme an der Kampagne',
    ],
    'title'         => 'Kampagnenbewerbung',
    'update'        => [
        'approve'   => 'Wählen Sie die Rolle aus, die dem Benutzer in Ihrer Kampagne hinzugefügt werden soll.',
        'approved'  => 'Bewerbung genehmigt',
        'reject'    => 'Schreiben Sie dem Benutzer eine optionale Nachricht, warum Sie seine Bewerbung ablehnen.',
        'rejected'  => 'Bewerbung abgelehnt',
    ],
];
