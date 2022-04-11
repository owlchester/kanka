<?php

return [
    'actions'       => [
        'follow'    => 'Folgen',
        'join'      => 'beitreten',
        'unfollow'  => 'Nicht mehr folgen',
    ],
    'campaigns'     => [
        'tabs'  => [
            'modules'   => ':count Module',
            'roles'     => ':count Rollen',
            'users'     => ':count Users',
        ],
    ],
    'dashboards'    => [
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
    'helpers'       => [
        'follow'    => 'Wenn du einer Kampagne folgst, wird sie im Kampagnenwähler (oben rechts) unter deinen Kampagnen angezeigt.',
        'join'      => 'Diese Kampagne steht neuen Mitgliedern offen. Klicken Sie, um sich zu bewerben, um daran teilzunehmen.',
        'setup'     => 'Richte dein Kampagnen Dashboard ein.',
    ],
    'notifications' => [
        'modal' => [
            'confirm'   => 'Verstanden',
            'title'     => 'Wichtige Mitteilung',
        ],
    ],
    'recent'        => [
        'title' => 'Vor kurzem bearbeitete :name',
    ],
    'settings'      => [
        'title' => 'Dashboard Einstellungen',
    ],
    'setup'         => [
        'actions'   => [
            'add'               => 'Widget hinzufügen',
            'back_to_dashboard' => 'Zurück zum Dashboard.',
            'edit'              => 'Widget bearbeiten.',
        ],
        'title'     => 'Kampagnen Dashboard Einrichtung',
        'tutorial'  => [
            'blog'  => 'unser Tutorial',
            'text'  => 'Benötigen Sie Hilfe beim Einrichten Ihres Kampagnen-Dashboards? Lesen Sie :blog für Hilfe und Inspiration.',
        ],
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
    'title'         => 'Dashboard',
    'welcome'       => [],
    'widgets'       => [
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
            'class'             => 'CSS-Klasse',
            'dashboard'         => 'Dashboard',
            'name'              => 'Benutzerdefinierter Widget-Name',
            'optional-entity'   => 'Link zum Objekt',
            'order'             => 'Bestellung',
            'text'              => 'Text',
            'width'             => 'Breite',
        ],
        'helpers'                   => [
            'class' => 'Definieren Sie eine benutzerdefinierte CSS-Klasse, die dem Widget hinzugefügt wird.',
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
            'advanced_filter'   => 'Erweiterter Filter',
            'advanced_filters'  => [
                'mentionless'   => 'Erwähnungslos (Objekte, die andere Objekte nicht erwähnen)',
                'unmentioned'   => 'Nicht erwähnt (Objekte, die von anderen Objekten nicht erwähnt werden)',
            ],
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
        'tabs'                      => [
            'advanced'  => 'Erweitert',
            'setup'     => 'Setup',
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
