<?php

return [
    'avatar'        => [
        'success'   => 'Avatar aktualisiert.',
    ],
    'description'   => 'Aktualisiere deine Profildetails',
    'edit'          => [
        'success'   => 'Profil aktualisert',
    ],
    'editors'       => [
        'default'       => 'Standard (TinyMCE 4)',
        'summernote'    => 'Summernote (experimentell)',
    ],
    'fields'        => [
        'avatar'                    => 'Avatar',
        'email'                     => 'Email',
        'last_login_share'          => 'Teile mit anderen Kampagnenmitgliedern, wann ich mich zuletzt angemeldet habe.',
        'name'                      => 'Name',
        'new_password'              => 'Neues Passwort (optional)',
        'new_password_confirmation' => 'Neues Passwort bestätigen',
        'newsletter'                => 'Ich würde gern manchmal per Email kontaktiert werden.',
        'password'                  => 'Aktuelles Passwort',
        'settings'                  => 'Einstellungen',
        'theme'                     => 'Theme',
    ],
    'newsletter'    => [
        'links'     => [
            'community-vote'    => 'Community Votes',
            'news'              => 'News',
        ],
        'settings'  => [
            'news'          => 'Nachrichten - benachrichtigt werden, wenn es :news gibt.',
            'newsletter'    => 'Newsletter - Erhalten Sie den Kanka Newsletter.',
            'votes'         => 'Community-Abstimmungen - benachrichtigt werden, sobald ein neuer :vote  verfügbar ist.',
        ],
        'title'     => 'Newsletter',
    ],
    'password'      => [
        'success'   => 'Passwort aktualisiert',
    ],
    'placeholders'  => [
        'email'                     => 'Deine Email Adresse',
        'name'                      => 'Dein Name, wie er dargestellt wird',
        'new_password'              => 'Dein neues Passwort',
        'new_password_confirmation' => 'Bestätige dein neues Passwort',
        'password'                  => 'Gib dein aktuelles Passwort für Änderungen ein',
    ],
    'sections'      => [
        'delete'    => [
            'delete'    => 'Lösche meinen Account',
            'title'     => 'Lösche deinen Account',
            'warning'   => 'Wenn du deinen Account löschst, werden alle Daten gelöscht. Bist du sicher?',
        ],
        'password'  => [
            'title' => 'Ändere dein Passwort',
        ],
    ],
    'settings'      => [
        'fields'    => [
            'advanced_mentions'     => 'Fortgeschrittene Erwähnungen',
            'date_format'           => 'Datenformatierung',
            'default_nested'        => 'Verschachtelte Ansicht als Standard',
            'editor'                => 'Texteditor',
            'new_entity_workflow'   => 'Neuer Objektworkflow',
            'pagination'            => 'Seitennummerierung (Objekte pro Seite)',
        ],
        'helpers'   => [
            'editor'    => 'Der Standardeditor (TinyMCE 4) ist veraltet, funktioniert aber immer noch gut auf dem Desktop, nicht aber auf Mobilengeräten. Summernote ist ein neuerer Editor, der auf allen Geräten funktioniert, aber wir befinden uns noch in der Testphase.',
        ],
        'hints'     => [
            'advanced_mentions'     => 'Wenn diese Option aktiviert ist, werden Erwähnungen beim Bearbeiten eines Objektes immer als [entity: 123] angezeigt.',
            'default_nested'        => 'Aktivier diese Option, wenn du Listen im Standard in der verschachtelten Ansicht sehen möchtest (soweit verfügbar).',
            'new_entity_workflow'   => 'Beim Erstellen eines neuen Objektes wird standardmäßig zur Liste der Objekte gewechselt. Sie können dies ändern, um stattdessen das neu erstellte Objekt anzuzeigen.',
        ],
        'success'   => 'Einstellungen geändert.',
    ],
    'theme'         => [
        'success'   => 'Theme geändert.',
        'themes'    => [
            'dark'      => 'Dunkel',
            'default'   => 'Standard',
            'future'    => 'Zukunft',
            'midnight'  => 'Mitternacht Blau',
        ],
    ],
    'title'         => 'Aktualisiere dein Profil',
    'workflows'     => [
        'created'   => 'Gehe zum erstellten Objekt',
        'default'   => 'Liste der Objekte',
    ],
];
