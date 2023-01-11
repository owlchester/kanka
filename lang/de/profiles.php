<?php

return [
    'appearance'                    => [
        'helpers'   => [
            'campaign-order'    => 'Ändere die Reihenfolge, in der Kampagnen im Kampagnenwechsler aufgelistet werden.',
            'date-format'       => 'Kontrolliere das Datumsformat für das Datum im wahren Leben.',
            'pagination'        => 'Änderne die Anzahl der angezeigten Elemente in verschiedenen Listen.',
        ],
    ],
    'avatar'                        => [
        'success'   => 'Avatar aktualisiert.',
    ],
    'campaign_switcher_order_by'    => [
        'alphabetical'      => 'Alphabetisch',
        'date_created'      => 'Erstellungsdatum',
        'date_joined'       => 'Beitrittsdatum',
        'default'           => 'Standard',
        'r_alphabetical'    => 'umgekehrt Alphabetisch',
        'r_date_created'    => 'umgekehrt Erstellungsdatum',
        'r_date_joined'     => 'umgekehrt Beitrittsdatum',
    ],
    'edit'                          => [
        'success'   => 'Profil aktualisert',
    ],
    'editors'                       => [
        'legacy'        => 'Legacy (TinyMCE 4)',
        'summernote'    => 'Summernote',
    ],
    'fields'                        => [
        'avatar'                    => 'Avatar',
        'bio'                       => 'Biografie',
        'email'                     => 'Email',
        'hide_subscription'         => 'Verstecke meinen Namen in der :hall_of_fame',
        'last_login_share'          => 'Teile mit anderen Kampagnenmitgliedern, wann ich mich zuletzt angemeldet habe.',
        'name'                      => 'Name',
        'new_password'              => 'Neues Passwort (optional)',
        'new_password_confirmation' => 'Neues Passwort bestätigen',
        'newsletter'                => 'Ich würde gern manchmal per Email kontaktiert werden.',
        'password'                  => 'Aktuelles Passwort',
        'profile-name'              => 'Profilname',
        'settings'                  => 'Einstellungen',
        'theme'                     => 'Theme',
    ],
    'helpers'                       => [
        'profile-name'  => 'Ändere die Art und Weise, wie dein Name in deinem :profile und dem :marketplace erscheint. Wenn du das Feld leer lässt, wird stattdessen dein Kontoname verwendet.',
    ],
    'newsletter'                    => [
        'helpers'   => [
            'header'    => 'Abonnieren Sie die folgenden E-Mail-Newsletter, um über Kanka informiert zu werden.',
        ],
        'options'   => [
            'monthly'   => 'Kanka Newsletter',
        ],
        'title'     => 'Newsletter',
        'updated'   => 'Newsletter-Einstellungen aktualisiert.',
    ],
    'password'                      => [
        'success'   => 'Passwort aktualisiert',
    ],
    'placeholders'                  => [
        'bio'                       => 'Eine kurze Biografie von Ihnen, die in Ihrem öffentlichen Profil angezeigt wird.',
        'email'                     => 'Deine Email Adresse',
        'name'                      => 'Dein Name, wie er dargestellt wird',
        'new_password'              => 'Dein neues Passwort',
        'new_password_confirmation' => 'Bestätige dein neues Passwort',
        'password'                  => 'Gib dein aktuelles Passwort für Änderungen ein',
    ],
    'sections'                      => [
        'dangerzone'    => 'Gefahrenzone',
        'delete'        => [
            'confirm'       => 'Ja, lösche meinen Account',
            'delete'        => 'Lösche meinen Account',
            'goodbye'       => 'Wenn ja, schreiben Sie bitte :code in das Feld unten.',
            'helper'        => 'Durch das Löschen Ihres Kontos werden auch alle Kampagnen gelöscht, bei denen Sie das einzige Mitglied sind. Diese Aktion ist permanent und kann nicht rückgängig gemacht werden.',
            'subscribed'    => 'Bitte kündige dein :subscription , bevor du dein Konto löschst.',
            'title'         => 'Lösche deinen Account',
            'warning'       => 'Wenn du deinen Account löschst, werden alle Daten gelöscht. Bist du sicher?',
        ],
        'password'      => [
            'title' => 'Ändere dein Passwort',
        ],
    ],
    'settings'                      => [
        'fields'    => [
            'advanced_mentions'             => 'Fortgeschrittene Erwähnungen',
            'campaign_switcher_order_by'    => 'Sortierreihenfolge für Kampagnenwechsler',
            'date_format'                   => 'Datenformatierung',
            'default_nested'                => 'Verschachtelte Ansicht als Standard',
            'editor'                        => 'Texteditor',
            'new_entity_workflow'           => 'Neuer Objektworkflow',
            'pagination'                    => 'Seitennummerierung (Objekte pro Seite)',
        ],
        'helpers'   => [
            'bio'       => 'Die Biografie ist auf Ihrem :link sichtbar.',
            'editor_v2' => 'Die Verwendung des Legacy-Texteditors (TinyMCE) unterstützt keine Erwähnungen auf Mobilgeräten und unterstützt einige Funktionen wie die Kampagnengalerie nicht.',
            'profile'   => 'öffentliches Profil',
        ],
        'hints'     => [
            'advanced_mentions'     => 'Wenn diese Option aktiviert ist, werden Erwähnungen beim Bearbeiten eines Objektes immer als [entity: 123] angezeigt.',
            'default_nested'        => 'Aktivier diese Option, wenn du Listen im Standard in der verschachtelten Ansicht sehen möchtest (soweit verfügbar).',
            'new_entity_workflow'   => 'Beim Erstellen eines neuen Objektes wird standardmäßig zur Liste der Objekte gewechselt. Sie können dies ändern, um stattdessen das neu erstellte Objekt anzuzeigen.',
        ],
        'success'   => 'Einstellungen geändert.',
    ],
    'theme'                         => [
        'helper'    => 'Eine Kampagne mit einem festgelegten Thema überschreibt deine Präferenz.',
        'success'   => 'Theme geändert.',
        'themes'    => [
            'dark'      => 'Dunkel',
            'default'   => 'Standard',
            'future'    => 'Zukunft',
            'midnight'  => 'Mitternacht Blau',
        ],
    ],
    'title'                         => 'Aktualisiere dein Profil',
    'workflows'                     => [
        'created'   => 'Gehe zum erstellten Objekt',
        'default'   => 'Liste der Objekte',
    ],
];
