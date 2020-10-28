<?php

return [
    'actions'           => [
        'follow'    => 'Folgen',
        'unfollow'  => 'Nicht mehr folgen',
    ],
    'campaigns'         => [
        'manage'    => 'Kampagnen verwalten',
        'tabs'      => [
            'modules'   => ':count Module',
            'roles'     => ':count Rollen',
            'users'     => ':count Users',
        ],
    ],
    'description'       => 'Das Zuhause deiner Kreativität',
    'helpers'           => [
        'follow'    => 'Wenn du einer Kampagne folgst, wird sie im Kampagnenwähler (oben rechts) unter deinen Kampagnen angezeigt.',
        'setup'     => 'Richte dein Kampagnen Dashboard ein.',
    ],
    'latest_release'    => 'Letztes Release',
    'notifications'     => [
        'modal' => [
            'confirm'   => 'Verstanden',
            'title'     => 'Wichtige Mitteilung',
        ],
    ],
    'recent'            => [
        'add'           => 'Erstelle :name',
        'no_entries'    => 'Es gibt keine Einträge zu diesem Typ.',
        'title'         => 'Vor kurzem bearbeitete :name',
        'view'          => 'Alle :name ansehen',
    ],
    'settings'          => [
        'description'   => 'Bearbeite, was du auf dem Dashboard siehst',
        'edit'          => [
            'success'   => 'Deine Änderungen wurden gespeichert.',
        ],
        'fields'        => [
            'helper'        => 'Du kannst einfach anpassen, was du auf dem Dashboard siehst. Beachte bitte, dass dies für all deine Kampagnen gilt, egal was in der Kampagne eingestellt ist.',
            'recent_count'  => 'Anzahl kürzlich hinzugefügter Objekte',
        ],
        'title'         => 'Dashboard Einstellungen',
    ],
    'setup'             => [
        'actions'   => [
            'add'               => 'Widget hinzufügen',
            'back_to_dashboard' => 'Zurück zum Dashboard.',
            'edit'              => 'Widget bearbeiten.',
        ],
        'title'     => 'Kampagnen Dashboard Einrichtung',
        'widgets'   => [
            'calendar'      => 'Kalender',
            'preview'       => 'Objekt Vorschau',
            'random'        => 'zufälliges Objekt',
            'recent'        => 'Kürzlich',
            'unmentioned'   => 'Unerwähntes Objekt',
        ],
    ],
    'title'             => 'Dashboard',
    'welcome'           => [
        'body'  => <<<'TEXT'
Willkommen bei Kanka! Deine erste Kampagne wurde erstellt und wir haben zur Inspiration ein paar Beispielobjekte mit angelegt (kannst du jederzeit löschen).

Du willst wahrscheinlich mit ein paar eigenen Objekten starten, also such dir links eine Kategorie aus und leg los. Kategorien, die du nicht brauchst lassen sich in den Kampagnen Einstellungen ausblenden.

Ein paar Tipps für den Anfang:
- Du kannst @Objektname tippen, um ein bestimmtes Objekt zu verlinken. Der angezeigte Linktext wird automatisch aktualisiert, wenn du den Objektnamen oder die Beschreibung anpasst.
- Du kannst Konto Einstellungen wie Design und Objekte pro Seite in deinem Profil oben rechts anpassen.
- Es gibt eine wachsende Anzahl an Tutorials auf :youtube. Unter anderem über Attribute und wie man die eigene Kampagne mit anderen teilt. Der :faq ist vielleicht auch hilfreich.
- Wenn du Fragen oder Vorschläge hast - oder einfach nur plaudern willst -, dann schau vorbei auf unserem :discord.
TEXT
,
    ],
    'widgets'           => [
        'calendar'      => [
            'actions'           => [
                'next'      => 'Datum auf nächsten Tag ändern',
                'previous'  => 'Datum auf vorigen Tag ändern',
            ],
            'events_today'      => 'Heute',
            'previous_events'   => 'Vorige',
            'upcoming_events'   => 'Bevorstehende',
        ],
        'create'        => [
            'success'   => 'Widget zum Dashboard hinzugefügt.',
        ],
        'delete'        => [
            'success'   => 'Widget vom Dashboard entfernt.',
        ],
        'fields'        => [
            'width' => 'Breite',
        ],
        'recent'        => [
            'entity-header' => 'Verwenden Sie den Objekt-Header als Bild',
            'full'          => 'Voll',
            'help'          => 'Nur das zuletzt aktualisierte Objekt anzeigen, aber eine vollständige Vorschau des Objektes anzeigen',
            'helpers'       => [
                'entity-header' => 'Wenn Ihr Objekt über einen Objekt-Header verfügt (erweiterte Kampagnenfunktion), stellen Sie dieses Widget so ein, dass dieses Bild anstelle des Bilds des Objektes verwendet wird.',
                'full'          => 'Zeigen Sie standardmäßig den Eintrag des gesamten Objektes anstelle einer Vorschau an.',
            ],
            'singular'      => 'Einzelnes Objekt',
            'tags'          => 'Filtern Sie die Liste der zuletzt geänderten Objekte nach bestimmten Tags.',
            'title'         => 'Vor kurzem aktualisiert',
        ],
        'unmentioned'   => [
            'title' => 'Unerwähnte Objekte',
        ],
        'update'        => [
            'success'   => 'Widget angepasst.',
        ],
        'widths'        => [
            '0' => 'automatisch',
            '12'=> 'Komplett (100%)',
            '3' => 'winzig (25%)',
            '4' => 'Klein (33%)',
            '6' => 'Halb (50%)',
            '8' => 'Weit (66%)',
        ],
    ],
];
