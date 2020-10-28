<?php

return [
    'actions'       => [
        'return'        => 'zurück zu allen Events',
        'send'          => 'Teilnehmen',
        'show_ongoing'  => 'Event anzeigen & teilnehmen',
        'show_past'     => 'Zeige Event & Gewinner',
        'update'        => 'Einsendung aktualisieren',
        'view'          => 'Einsendungen anzeigen',
    ],
    'description'   => 'Wir veranstalten regelmäßig Worldbuilding-Events für unsere Community, bei denen unsere Lieblingsbeiträge präsentiert werden.',
    'fields'        => [
        'comment'       => 'Kommentar',
        'entity_link'   => 'Link zum Objekt',
        'rank'          => 'Rang',
        'submitter'     => 'Einsender',
    ],
    'index'         => [
        'ongoing'   => 'Laufende Events',
        'past'      => 'vergangene Events',
    ],
    'participate'   => [
        'description'   => 'Fühlen Sie sich von diesem Ereignis inspiriert? Erstellen Sie ein Objekt in einer Ihrer öffentlichen Kampagnen und senden Sie uns den Link zum Objekt im folgenden Formular. Sie können Ihre Einreichung jederzeit ändern oder löschen.',
        'login'         => 'Melden Sie sich in Ihrem Konto an, um an dem Event teilzunehmen',
        'participated'  => 'Sie haben bereits eine Einsendung für dieses Event gesendet. Sie können es bearbeiten oder entfernen.',
        'success'       => [
            'modified'  => 'Änderungen an Ihrer Einsendung wurden gespeichert.',
            'removed'   => 'Ihre Einsendung wurde entfernt.',
            'submit'    => 'Ihre Einsendung wurde gesendet. Sie können sie jederzeit bearbeiten oder entfernen.',
        ],
        'title'         => 'Nehmen Sie an dem Event teil',
    ],
    'placeholders'  => [
        'comment'       => 'Kommentar zu Ihrer Einsendung (optional)',
        'entity_link'   => 'Kopieren Sie den Link zum Objekt und fügen Sie ihn hier ein',
    ],
    'results'       => [
        'description'       => 'Unsere Jury hat die folgenden Beiträge als Gewinner für das Event ausgewählt.',
        'title'             => 'Event Gewinner',
        'waiting_results'   => 'Das Event ist vorbei! Die Jury des Events prüft die Einsendungen und sobald die Gewinner ausgewählt sind, werden sie hier angezeigt.',
    ],
    'show'          => [
        'participants'  => '{1} :number entry submitted.|[2,*] :number entries submitted.',
        'title'         => 'Event :name',
    ],
    'title'         => 'Events',
];
