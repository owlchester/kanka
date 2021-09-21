<?php

return [
    'actions'           => [
        'follow'    => 'Folgen',
        'join'      => 'beitreten',
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
    'dashboards'        => [
        'actions'       => [
            'edit'      => 'Editieren',
            'new'       => 'neues Dashboard',
            'switch'    => 'zum Dashboard wechseln',
        ],
        'boosted'       => ':boosted_campaigns kann benutzerdefinierte Dashboards für jede der Kampagnenrollen erstellen.',
        'create'        => [
            'success'   => 'Neues Kampagnen Dashboard :name erstellt',
            'title'     => 'Neues Kampagnen Dashboard',
        ],
        'custom'        => [
            'text'  => 'Sie bearbeiten derzeit das Dashboard :name der Kampagne.',
        ],
        'default'       => [
            'text'  => 'Sie bearbeiten derzeit das Standard Dashboard der Kampagne.',
            'title' => 'Standard Dashboard',
        ],
        'delete'        => [
            'success'   => 'Dashboard :name entfernt',
        ],
        'fields'        => [
            'copy_widgets'  => 'Widgets kopieren',
            'name'          => 'Dashboard Name',
            'visibility'    => 'Sichtbarkeit',
        ],
        'helpers'       => [
            'copy_widgets'  => 'Duplizieren Sie die Widgets aus dem :name -Dashboard in dieses neue.',
        ],
        'placeholders'  => [
            'name'  => 'Name des Dashboards',
        ],
        'update'        => [
            'success'   => 'Kampagnen Dashboard :name aktualisiert',
            'title'     => 'Kampagnen Dashboard :name aktualisieren',
        ],
        'visibility'    => [
            'default'   => 'Standard',
            'none'      => 'keiner',
            'visible'   => 'Sichtbar',
        ],
    ],
    'description'       => 'Das Zuhause deiner Kreativität',
    'helpers'           => [
        'follow'    => 'Wenn du einer Kampagne folgst, wird sie im Kampagnenwähler (oben rechts) unter deinen Kampagnen angezeigt.',
        'join'      => 'Diese Kampagne steht neuen Mitgliedern offen. Klicken Sie, um sich zu bewerben, um daran teilzunehmen.',
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
            'campaign'      => 'Kampagnenüberschrift',
            'header'        => 'Überschrift',
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
        'actions'                   => [
            'advanced-options'  => 'Erweiterte Optionen',
            'delete-confirm'    => 'dieses Widget',
        ],
        'advanced_options_boosted'  => ':boosted_campaigns verfügt über erweiterte Optionen wie das Anzeigen von Mitgliedern einer Familie oder der Attribute der Objekt im Dashboard.',
        'calendar'                  => [
            'actions'           => [
                'next'      => 'Datum auf nächsten Tag ändern',
                'previous'  => 'Datum auf vorigen Tag ändern',
            ],
            'events_today'      => 'Heute',
            'previous_events'   => 'Vorige',
            'upcoming_events'   => 'Bevorstehende',
        ],
        'campaign'                  => [
            'helper'    => 'Dieses Widget zeigte den Kampagnenkopf an. Dieses Widget wird immer im Standard-Dashboard angezeigt.',
        ],
        'create'                    => [
            'success'   => 'Widget zum Dashboard hinzugefügt.',
        ],
        'delete'                    => [
            'success'   => 'Widget vom Dashboard entfernt.',
        ],
        'fields'                    => [
            'dashboard'         => 'Dashboard',
            'name'              => 'Benutzerdefinierter Widget-Name',
            'optional-entity'   => 'Link zum Objekt',
            'order'             => 'Bestellung',
            'text'              => 'Text',
            'width'             => 'Breite',
        ],
        'orders'                    => [
            'name_asc'  => 'Name aufsteigend',
            'name_desc' => 'Name absteigend',
            'recent'    => 'Kürzlich modifiziert',
        ],
        'random'                    => [
            'helpers'   => [
                'name'  => 'Sie können den Namen der zufälligen Objekte mit {name} referenzieren',
            ],
        ],
        'recent'                    => [
            'entity-header'     => 'Verwenden Sie den Objekt-Header als Bild',
            'filters'           => 'Filter',
            'full'              => 'Voll',
            'help'              => 'Nur das zuletzt aktualisierte Objekt anzeigen, aber eine vollständige Vorschau des Objektes anzeigen',
            'helpers'           => [
                'entity-header'     => 'Wenn Ihr Objekt über einen Objekt-Header verfügt (erweiterte Kampagnenfunktion), stellen Sie dieses Widget so ein, dass dieses Bild anstelle des Bilds des Objektes verwendet wird.',
                'filters'           => 'Sie können die Art der angezeigten Objekte filtern. Erfahren Sie, wie Sie dieses Feld verwenden, indem Sie die Hilfeseite :link besuchen.',
                'full'              => 'Zeigen Sie standardmäßig den Eintrag des gesamten Objektes anstelle einer Vorschau an.',
                'show_attributes'   => 'Zeigen Sie die Attribute der Objekte unter dem Eintrag an.',
                'show_members'      => 'Wenn es sich bei dem Objekt um eine Familie oder Organisation handelt, zeigen Sie ihre Mitglieder unter dem Eintrag an.',
                'show_relations'    => 'Zeigen Sie die angehefteten Beziehungen des Objekts unter dem Eintrag an.',
            ],
            'show_attributes'   => 'Zeige Attribute',
            'show_members'      => 'Zeige Mitglieder',
            'show_relations'    => 'Zeige angepinnte Beziehungen',
            'singular'          => 'Einzelnes Objekt',
            'tags'              => 'Filtern Sie die Liste der zuletzt geänderten Objekte nach bestimmten Tags.',
            'title'             => 'Vor kurzem aktualisiert',
        ],
        'unmentioned'               => [
            'title' => 'Unerwähnte Objekte',
        ],
        'update'                    => [
            'success'   => 'Widget angepasst.',
        ],
        'widths'                    => [
            '0' => 'automatisch',
            '12'=> 'Komplett (100%)',
            '3' => 'winzig (25%)',
            '4' => 'Klein (33%)',
            '6' => 'Halb (50%)',
            '8' => 'Weit (66%)',
            '9' => 'Groß (75%)',
        ],
    ],
];
