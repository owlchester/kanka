<?php

return [
    'create'        => [
        'helper'                => [
            'first' => 'Danke, dass du unsere App ausprobierst! Bevor es losgehen kann, brauchen wir nur eine Kleinigkeit von dir, deinen <b>Kampagnennamen</b>. Das ist der Name deiner Welt, der sie von anderen unterscheidet, also muss er einzigartig sein. Wenn du noch keinen geeigneten Namen hast, mach dir keine Sorgen, du kannst ihn <b>jederzeit ändern</b>, oder weitere Kampagnen erstellen.',
            'second'=> 'Aber genug Geplauder! Was soll es sein?',
            'title' => 'Willkommen bei :name!',
        ],
        'success'               => 'Kampagne erstellt.',
        'success_first_time'    => 'Deine Kampagne wurde erstellt! Da es deine erste Kampagne ist, haben wir ein paar Dinge für dich erstellt, die dir helfen sollen, loszulegen und hoffentlich ein bisschen Inspiration liefern, was du alles machen kannst.',
        'title'                 => 'Neue Kampagne erstellen',
    ],
    'destroy'       => [
        'success'   => 'Kampagne gelöscht',
    ],
    'edit'          => [
        'success'   => 'Kampagne aktualisiert',
        'title'     => 'Kampagne :campaign bearbeiten',
    ],
    'fields'        => [
        'description'   => 'Beschreibung',
        'image'         => 'Bild',
        'locale'        => 'Schauplatz',
        'name'          => 'Name',
    ],
    'index'         => [
        'actions'       => [
            'new'   => [
                'description'   => 'Neue Kampagne erstellen',
                'title'         => 'Neue Kampagne',
            ],
        ],
        'add'           => 'Neue Kampagne',
        'description'   => 'Verwalte deine Kampagnen',
        'list'          => 'Deine Kampagnen',
        'select'        => 'Wähle eine Kampagne',
        'title'         => 'Kampagnen',
    ],
    'invites'       => [
        'actions'       => [
            'add'   => 'Einladung',
        ],
        'create'        => [
            'button'    => 'Einladen',
            'success'   => 'Einladung verschickt.',
            'title'     => 'Lade jemanden zu deiner Kampagne ein',
        ],
        'destroy'       => [
            'success'   => 'Einladung entfernt.',
        ],
        'email'         => [
            'link'      => '<a href=":link">Trete :name\'s Kampagne bei</a>',
            'subject'   => ':name hat dich eingeladen, seiner Kampagne \':campaign\' auf kanka.io beizutreten! Nutze den folgenden Link, um die Einladung anzunehmen.',
            'title'     => 'Einladung von :name',
        ],
        'error'         => [
            'already_member'    => 'Du bist bereits Mitglied dieser Kampagne',
            'inactive_token'    => 'Dieses Token wurde bereits genutzt oder die Kampagne existiert nicht mehr.',
            'invalid_token'     => 'Dieser Token ist nicht mehr gültig.',
            'login'             => 'Bitte logge dich ein oder registriere dich, um der Kampagne beizutreten.',
        ],
        'fields'        => [
            'created'   => 'Senden',
            'email'     => 'Email',
        ],
        'placeholders'  => [
            'email' => 'Email Adresse der Person, die du zu der Kampagne einladen möchtest',
        ],
    ],
    'leave'         => [
        'confirm'   => 'Bist du sicher, dass du die Kampagne :name verlassen möchtest? Du hast danach keinen Zugang mehr, außer ein Besitzer der Kampagne lädt dich erneut ein.',
        'error'     => 'Kann die Kampagne nicht verlassen.',
        'success'   => 'Du hast die Kampagne verlassen.',
    ],
    'members'       => [
        'create'    => [
            'title' => 'Füge ein Mitglied zu deiner Kampagne hinzu.',
        ],
        'edit'      => [
            'title' => 'Bearbeite Mitglied :name',
        ],
        'fields'    => [
            'joined'    => 'Beigetreten',
            'name'      => 'Nutzer',
            'role'      => 'Rolle',
        ],
        'invite'    => [
            'description'   => 'Du kannst deine Freunde zu deiner Kampagne einladen, in dem du ihre Email Adresse eingibst. Wenn sie die Einladung annehmen, werden sie als \'Zuschauer\' hinzugefügt. Du kannst die Einladung auch jederzeit abbrechen.',
            'title'         => 'Einladen',
        ],
        'roles'     => [
            'member'    => 'Mitglied',
            'owner'     => 'Besitzer',
            'viewer'    => 'Zuschauer',
        ],
        'your_role' => 'Du bist ein <i>:role</i>',
    ],
    'placeholders'  => [
        'description'   => 'Eine kurze Zusammenfassung deiner Kampagne',
        'locale'        => 'Sprachcode',
        'name'          => 'Dein Kampagnenname',
    ],
    'roles'         => [
        'actions'       => [
            'add'   => 'Rolle hinzufügen',
        ],
        'create'        => [
            'success'   => 'Rolle erstellt.',
            'title'     => 'Erstelle eine neue Rolle für :name',
        ],
        'destroy'       => [
            'success'   => 'Rolle entfernt.',
        ],
        'edit'          => [
            'success'   => 'Rolle aktualisiert.',
            'title'     => 'Rolle :name bearbeiten',
        ],
        'fields'        => [
            'name'          => 'Name',
            'permissions'   => 'Berechtigungen',
            'users'         => 'Nutzer',
        ],
        'members'       => 'Mitglieder',
        'permissions'   => [
            'hint'  => 'Diese Rolle hat automatisch Zugriff auf alles.',
        ],
        'placeholders'  => [
            'name'  => 'Name der Rolle',
        ],
        'show'          => [
            'title' => 'Rolle \':role\' für Kampagne \':campaign\'',
        ],
        'users'         => [
            'actions'   => [
                'add'   => 'Hinzufügen',
            ],
            'create'    => [
                'success'   => 'Benutzer zu Rolle hinzugefügt.',
                'title'     => 'Füge ein Mitglied zur Rolle :name hinzu',
            ],
            'destroy'   => [
                'success'   => 'Benutzer aus Rolle entfernt',
            ],
            'fields'    => [
                'name'  => 'Name',
            ],
        ],
    ],
    'settings'      => [
        'edit'      => [
            'success'   => 'Kampagnen Einstellungen aktualisiert.',
        ],
        'helper'    => 'Du kannst einfach Elemente von deiner Kampagne abschalten, die dann versteckt werden. Wenn du bereits Objekte in dieser Kategorie angelegt hast, werden diese nicht gelöscht, nur versteckt.',
    ],
    'show'          => [
        'actions'       => [
            'leave' => 'Kampagne verlassen',
        ],
        'description'   => 'Eine detaillierte Ansicht der Kampagne',
        'tabs'          => [
            'information'   => 'Informationen',
            'members'       => 'Mitglieder',
            'roles'         => 'Rollen',
            'settings'      => 'Einstellungen',
        ],
        'title'         => 'Kampagne :name',
    ],
];
