<?php

return [
    'campaign'          => [
        'application'           => [
            'approved'  => 'Ihre Bewerbung für die Kampagne :campaign wurde genehmigt.',
            'new'       => 'Neue Bewerbung für :campaign',
            'rejected'  => 'Ihr Bewerbung für die :campaign Kampagne wurde abgelehnt. Grund dafür ist :reason',
        ],
        'asset_export'          => 'Ein Export eines Kampagnen-Assets ist verfügbar. Der Link ist verfügbar für :time Minuten.',
        'asset_export_error'    => 'Beim Exportieren der Kampagnenassets ist ein Fehler aufgetreten. Dies geschieht bei großen Kampagnen.',
        'boost'                 => [
            'add'           => 'Kampagne :campaign wird geboosted durch :user.',
            'remove'        => ':user boosted die :campaign  nicht mehr.',
            'superboost'    => 'Die Kampagne :campaigne wird von :user superboosted.',
        ],
        'deleted'               => 'Die Kampagne :campaign wurde gelöscht.',
        'export'                => 'Ein Export der Kampagne steht zur Verfügung. Der Link ist :time Minuten gültig.',
        'export_error'          => 'Beim Export deiner Kampagne ist ein Fehler aufgetreten. Bitte kontaktiere uns, wenn das Problem weiterhin besteht.',
        'join'                  => ':user ist der Kampagne :campaign beigetreten.',
        'leave'                 => ':user hat die Kampagne :campaign verlassen.',
        'plugin'                => [
            'deleted'   => 'Das Plugin :plugin wurde vom Marktplatz gelöscht und aus Ihrer Kampagne :campaign entfernt.',
        ],
        'role'                  => [
            'add'       => 'Du wurdest zur Rolle :role in der Kampagne :campaign hinzugefügt.',
            'remove'    => 'Du wurdest aus der Rolle :role in der Kampagne :campaign entfernt.',
        ],
        'troubleshooting'       => [
            'joined'    => 'Das Kanka Teammitglied :user ist der Kampagne :campaign beigetreten.',
        ],
    ],
    'clear'             => [
        'action'    => 'Clear all',
        'confirm'   => 'Möchten Sie wirklich alle Benachrichtigungen entfernen? Diese Aktion kann nicht rückgängig gemacht werden.',
        'success'   => 'Benachrichtigungen entfernt.',
    ],
    'header'            => 'Du hast :count Benachrichtigungen.',
    'index'             => [
        'title' => 'Benachrichtigungen',
    ],
    'no_notifications'  => 'Es gibt aktuell keine Benachrichtigungen.',
    'permissions'       => [],
    'subscriptions'     => [
        'charge_fail'   => 'Bei der Verarbeitung Ihrer Zahlungsmethode ist ein Fehler aufgetreten. Bitte warten Sie einen Moment, während wir es erneut versuchen. Wenn sich nichts ändert, kontaktieren Sie uns bitte.',
        'deleted'       => 'Ihr Abonnement für Kanka wurde nach zu vielen fehlgeschlagenen Versuchen, Ihre Karte zu belasten, gekündigt. Bitte gehen Sie zu Ihren Abonnementeinstellungen und versuchen Sie, Ihre Zahlungsdetails zu aktualisieren.',
        'ended'         => 'Ihr Abonnement für Kanka ist beendet. Ihre Kampagnen-Boosts und Discord-Rollen wurden entfernt. Wir hoffen, Sie bald wieder zu sehen!',
        'failed'        => 'Ihr Abonnement für Kanka wurde nach zu vielen fehlgeschlagenen Versuchen, Ihre Zahlungsmethode zu belasten, gekündigt. Bitte gehen Sie zu Ihren Abonnementeinstellungen und versuchen Sie, Ihre Zahlungsdetails zu aktualisieren.',
        'started'       => 'Ihr Abonnement wurde gestartet',
    ],
    'unread'            => 'Neue Benachrichtigung',
];
