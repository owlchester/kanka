<?php

return [
    'apps'              => [
        'discord'   => [
            'invalid'   => 'Dein Discord-Token ist abgelaufen. Bitte synchronisiere dein Discord- und Kanka-Konto erneut.',
        ],
    ],
    'campaign'          => [
        'application'           => [
            'approved'              => 'Ihre Bewerbung für die Kampagne :campaign wurde genehmigt.',
            'approved_message'      => 'Deiner Bewerbung für die :campaign Kampagne wurde zugestimmt. Nachricht bereitgestellt: :reason',
            'new'                   => 'Neue Bewerbung für :campaign',
            'rejected'              => 'Ihr Bewerbung für die :campaign Kampagne wurde abgelehnt. Grund dafür ist :reason',
            'rejected_no_message'   => 'Deiner Bewerbung für die Kampagne :campaign wurde widersprochen.',
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
        'hidden'                => 'Die Kampagne :campaign ist jetzt auf der Seite „Öffentliche Kampagnen“ ausgeblendet.',
        'import'                => [
            'failed'    => 'Der Import für Kampagne :campaign ist fehlgeschlagen.',
            'success'   => 'Der Import der Kampagne :campaign wurde abgeschlossen.',
        ],
        'join'                  => ':user ist der Kampagne :campaign beigetreten.',
        'leave'                 => ':user hat die Kampagne :campaign verlassen.',
        'new_owner'             => 'Du wurdest zum Administrator von :campaign ernannt.',
        'plugin'                => [
            'deleted'   => 'Das Plugin :plugin wurde vom Marktplatz gelöscht und aus Ihrer Kampagne :campaign entfernt.',
        ],
        'premium'               => [
            'add'       => 'Premium-Funktionen wurden für die :campaign-Kampagne von :user freigeschaltet.',
            'remove'    => ':user schaltet keine Premiumfunktionen mehr für die :campaign-Kampagne frei.',
        ],
        'removed-image'         => 'Das Bild oder der Header von :entity wurde aufgrund eines Urheberrechtsanspruchs entfernt.',
        'role'                  => [
            'add'       => 'Du wurdest zur Rolle :role in der Kampagne :campaign hinzugefügt.',
            'remove'    => 'Du wurdest aus der Rolle :role in der Kampagne :campaign entfernt.',
        ],
        'shown'                 => 'Die Kampagne :campaign ist jetzt auf der Seite „Öffentliche Kampagnen“ sichtbar.',
        'troubleshooting'       => [
            'joined'    => 'Das Kanka Teammitglied :user ist der Kampagne :campaign beigetreten.',
        ],
    ],
    'clear'             => [
        'action'    => 'Clear all',
        'success'   => 'Benachrichtigungen entfernt.',
        'title'     => 'lösche Benachrichtigungen',
    ],
    'features'          => [
        'approved'  => 'Deine Idee :feature wurde genehmigt.',
        'finished'  => 'Ihre Idee :feature ist jetzt in Kanka verfügbar!',
        'rejected'  => 'Deine Idee :feature wurde abgelehnt, Grund: :reason.',
    ],
    'header'            => 'Du hast :count Benachrichtigungen.',
    'index'             => [
        'title' => 'Benachrichtigungen',
    ],
    'map'               => [
        'chunked'   => 'Karte :name ist mit dem aufteilen fertig und kann jetzt verwendet werden.',
    ],
    'no_notifications'  => 'Es gibt aktuell keine Benachrichtigungen.',
    'plugins'           => [
        'comments'  => [
            'new_comment'   => ':user hat einen neuen Kommentar zu dem Plugin :plugin hinterlassen.',
            'new_reply'     => ':user hat auf Ihren Kommentar in :plugin geantwortet.',
        ],
    ],
    'subscriptions'     => [
        'charge_fail'   => 'Bei der Verarbeitung Ihrer Zahlungsmethode ist ein Fehler aufgetreten. Bitte warten Sie einen Moment, während wir es erneut versuchen. Wenn sich nichts ändert, kontaktieren Sie uns bitte.',
        'deleted'       => 'Ihr Abonnement für Kanka wurde nach zu vielen fehlgeschlagenen Versuchen, Ihre Karte zu belasten, gekündigt. Bitte gehen Sie zu Ihren Abonnementeinstellungen und versuchen Sie, Ihre Zahlungsdetails zu aktualisieren.',
        'ended'         => 'Ihr Abonnement für Kanka ist beendet. Ihre Kampagnen-Boosts und Discord-Rollen wurden entfernt. Wir hoffen, Sie bald wieder zu sehen!',
        'failed'        => 'Ihr Abonnement für Kanka wurde nach zu vielen fehlgeschlagenen Versuchen, Ihre Zahlungsmethode zu belasten, gekündigt. Bitte gehen Sie zu Ihren Abonnementeinstellungen und versuchen Sie, Ihre Zahlungsdetails zu aktualisieren.',
        'started'       => 'Ihr Abonnement wurde gestartet',
    ],
    'unread'            => 'Neue Benachrichtigung',
];
