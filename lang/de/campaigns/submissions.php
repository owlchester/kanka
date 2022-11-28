<?php

return [
    'actions'       => [
        'accept'        => 'akzeptieren',
        'applications'  => 'Bewerbungen: :status',
        'change'        => 'Änderung',
        'reject'        => 'ablehnen',
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
        'approval'      => 'Genehmigungsgrund',
        'rejection'     => 'Ablehnungsgrund',
    ],
    'helpers'       => [
        'filter-helper'     => 'Diese Kampagne ist offen für Bewerbungen!',
        'modal'             => 'Bei einer Kampagne, die für Bewerbungen offen und öffentlich ist, können sich Benutzer für die Teilnahme an der Kampagne bewerben.',
        'no_applications'   => 'Derzeit gibt es keine ausstehenden Bewerbungen zur Teilnahme an Ihrer Kampagne. Benutzer können sich für die Teilnahme an Ihrer Kampagne bewerben, indem sie das Dashboard besuchen und auf die Schaltfläche :button klicken.',
        'not_open'          => 'Die Kampagne nimmt derzeit keine Bewerbungen an.',
        'open_not_public'   => 'Die Kampagne ist offen für Bewerbungen, aber nicht öffentlich, was bedeutet, dass sich niemand bewerben kann, um daran teilzunehmen. Dies kann geändert werden, indem du die Einstellungen der Kampagne bearbeitest.',
    ],
    'placeholders'  => [
        'note'  => 'Notieren Sie Ihre Bewerbung für die Teilnahme an der Kampagne',
    ],
    'statuses'      => [
        'closed'    => 'geschlossen',
        'open'      => 'offen',
    ],
    'toggle'        => [
        'closed'    => 'Anwendung geschlossen',
        'label'     => 'Status',
        'open'      => 'Anwendung offen',
        'success'   => 'Anwendungsstatus der Kampagne aktualisiert.',
        'title'     => 'Anwendungsstatus',
    ],
    'update'        => [
        'approve'   => 'Wählen Sie die Rolle aus, die dem Benutzer in Ihrer Kampagne hinzugefügt werden soll.',
        'approved'  => 'Bewerbung genehmigt',
        'reject'    => 'Schreiben Sie dem Benutzer eine optionale Nachricht, warum Sie seine Bewerbung ablehnen.',
        'rejected'  => 'Bewerbung abgelehnt',
    ],
];
