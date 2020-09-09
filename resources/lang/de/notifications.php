<?php

return [
    'campaign'          => [
        'boost'         => [
            'add'           => 'Kampagne :campaign wird geboosted durch :user.',
            'remove'        => ':user boosted die :campaign  nicht mehr.',
            'superboost'    => 'Die Kampagne :campaigne wird von :user superboosted.',
        ],
        'export'        => 'Ein Export der Kampagne steht zur Verfügung. Du kannst ihn herunterladen, indem du <a href=":link">hier</a> klickst. Der Link ist 30 Minuten gültig.',
        'export_error'  => 'Beim Export deiner Kampagne ist ein Fehler aufgetreten. Bitte kontaktiere uns, wenn das Problem weiterhin besteht.',
        'join'          => ':user ist der Kampagne :campaign beigetreten.',
        'leave'         => ':user hat die Kampagne :campaign verlassen.',
        'role'          => [
            'add'       => 'Du wurdest zur Rolle :role in der Kampagne :campaign hinzugefügt.',
            'remove'    => 'Du wurdest aus der Rolle :role in der Kampagne :campaign entfernt.',
        ],
    ],
    'header'            => 'Du hast :count Benachrichtigungen.',
    'index'             => [
        'description'   => 'Deine neuste Benachrichtigung.',
        'title'         => 'Benachrichtigungen',
    ],
    'no_notifications'  => 'Es gibt aktuell keine Benachrichtigungen.',
    'permissions'       => [
        'body'  => 'Hey, wir wollten dir mitteilen, dass wir das Berechtigungssystem für jede Kampagne komplett überarbeitet haben!</p><p>Kampagnen können jetzt Rollen haben und jede Rolle kann Zugriff auf Objekte haben, um diese zu lesen, bearbeiten oder zu löschen.Jedes Objekt kann auch mit nutzerspezifischen Berechtigungen feinjustiert werden, was bedeutet, dass Becky und Alfred ihren eigenen Character bearbeiten können!</p><p>Der einzige Nachteil ist, dass Kampagnen mit mehreren Benutzern ihre neuen Berechtigungen setzen müssen. Wenn du der Admin einer Kampagne bist, kannst du das in den Kampagneneinstellungen machen. Wenn du Teil einer Kampagne bist, wirst du nichts sehen, bis der Besitzer sich darum gekümmert hat.',
        'title' => 'Berechtigungssystem Änderungen',
    ],
    'subscriptions'     => [
        'charge_fail'   => 'Bei der Verarbeitung Ihrer Zahlungsmethode ist ein Fehler aufgetreten. Bitte warten Sie einen Moment, während wir es erneut versuchen. Wenn sich nichts ändert, kontaktieren Sie uns bitte.',
        'deleted'       => 'Ihr Abonnement für Kanka wurde nach zu vielen fehlgeschlagenen Versuchen, Ihre Karte zu belasten, gekündigt. Bitte gehen Sie zu Ihren Abonnementeinstellungen und versuchen Sie, Ihre Zahlungsdetails zu aktualisieren.',
        'ended'         => 'Ihr Abonnement für Kanka ist beendet. Ihre Kampagnen-Boosts und Discord-Rollen wurden entfernt. Wir hoffen, Sie bald wieder zu sehen!',
        'failed'        => 'Ihr Abonnement für Kanka wurde nach zu vielen fehlgeschlagenen Versuchen, Ihre Zahlungsmethode zu belasten, gekündigt. Bitte gehen Sie zu Ihren Abonnementeinstellungen und versuchen Sie, Ihre Zahlungsdetails zu aktualisieren.',
        'started'       => 'Ihr Abonnement wurde gestartet',
    ],
];
