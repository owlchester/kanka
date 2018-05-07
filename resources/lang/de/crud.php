<?php

return [
    'actions'       => [
        'back'      => 'Zurück',
        'copy'      => 'Kopieren',
        'move'      => 'Verschieben',
        'new'       => 'Neu',
        'private'   => 'Privat',
        'public'    => 'Öffentlich',
    ],
    'add'           => 'Hinzufügen',
    'attributes'    => [
        'actions'       => [
            'add'               => 'Attribut hinzufügen',
            'apply_template'    => 'Eine Attributvorlage anwenden',
            'manage'            => 'Verwalten',
        ],
        'create'        => [
            'description'   => 'Erstelle ein neues Attribut',
            'success'       => 'Attribut :name zu :entity hinzugefügt',
            'title'         => 'Neues Attribute für :name',
        ],
        'destroy'       => [
            'success'   => 'Attribut :name für :entity entfernt',
        ],
        'edit'          => [
            'description'   => 'Aktualisiere ein bestehendes Attribut',
            'success'       => 'Attribut :name für :entity aktualisiert',
            'title'         => 'Aktualisiere Attribut für :name',
        ],
        'fields'        => [
            'attribute' => 'Attribut',
            'template'  => 'Vorlage',
            'value'     => 'Wert',
        ],
        'index'         => [
            'success'   => 'Attribute für :entity aktualisiert',
            'title'     => 'Attribute für :name',
        ],
        'placeholders'  => [
            'attribute' => 'Anzahl der Eroberungen, Challenge Rating, Initiative, Bevölkerung',
            'template'  => 'Wähle eine Vorlage',
            'value'     => 'Wert des Attributs',
        ],
        'template'      => [
            'success'   => 'Attributvorlage :name wird auf :entity angewendet',
            'title'     => 'Wende eine Attributvorlage auf :name an',
        ],
    ],
    'bulk'          => [
        'errors'    => [
            'admin' => 'Nur Kampagnenadmins können den "Privat" Status eines Objektes ändern.',
        ],
        'success'   => [
            'private'   => ':count Objekt ist jetzt privat.|:count Objekte sind jetzt privat.',
            'public'    => ':count Objekt ist jetzt sichtbar.|:count Objekte sind jetzt sichtbar.',
        ],
    ],
    'cancel'        => 'Abbrechen',
    'clear_filters' => 'Filter zurücksetzen',
    'click_modal'   => [
        'close'     => 'Schließen',
        'confirm'   => 'Bestätigen',
        'title'     => 'Bestätige deine Aktion',
    ],
    'create'        => 'Erstellen',
    'delete_modal'  => [
        'close'         => 'Schließen',
        'delete'        => 'Löschen',
        'description'   => 'Bist du sicher das du :tag entfernen möchtest?',
        'title'         => 'Löschen bestätigen',
    ],
    'destroy_many'  => [
        'success'   => ':count Objekt gelöscht|:count Objekte gelöscht',
    ],
    'edit'          => 'Bearbeiten',
    'errors'        => [
        'node_must_not_be_a_descendant' => 'Ungültiges Objekt (Kategorie, Ort): es würde ein Nachkomme von sich selbst sein.',
    ],
    'events'        => [
        'hint'  => 'Kalenderereignisse, die mit diesem Objekt verknüpft sind, werden hier dargestellt.',
    ],
    'fields'        => [
        'character'     => 'Charakter',
        'description'   => 'Beschreibung',
        'entity'        => 'Objekt',
        'entry'         => 'Eintrag',
        'event'         => 'Ereignis',
        'family'        => 'Familie',
        'history'       => 'Geschichte',
        'image'         => 'Bild',
        'is_private'    => 'Privat',
        'location'      => 'Ort',
        'name'          => 'Name',
        'organisation'  => 'Organisation',
        'section'       => 'Kategorie',
    ],
    'filter'        => 'Filter',
    'filters'       => 'Filter',
    'hidden'        => 'Versteckt',
    'hints'         => [
        'is_private'    => 'Vor \'Zuschauern\' verbergen',
    ],
    'image'         => [
        'error' => 'Wir konnten das von dir angeforderte Bild nicht laden. Es könnte sein, dass die Website nicht erlaubt, Bilder herunterzuladen (typisch für Squarespace und DeviantArt) oder dass der Link nicht mehr gültig ist.',
    ],
    'is_private'    => 'Dieses Objekt ist privat und nicht von Zuschauern einsehbar.',
    'linking_help'  => 'Wie kann ich zu anderen Objekten verlinken?',
    'manage'        => 'Verwalten',
    'move'          => [
        'description'   => 'Verschiebe diese Objekt an einen anderen Ort',
        'errors'        => [
            'permission'        => 'Du hast keine Berechtigung, Objekte diesen Typs in dieser Kampagne zu erstellen.',
            'same_campaign'     => 'Du musst eine andere Kampagne auswählen, in welche du das Objekt verschieben willst.',
            'unknown_campaign'  => 'Unbekannte Kampagne.',
        ],
        'fields'        => [
            'campaign'  => 'Neue Kampagne',
            'target'    => 'Neuer Typ',
        ],
        'hints'         => [
            'campaign'  => 'Du kannst auch versuchen, diese Objekt in eine andere Kampagne zu verschieben.',
            'target'    => 'Bitte beachte, das einige Daten verloren gehen können, wenn ein Objekt von einem Typ zu einem anderen verschoben wird.',
        ],
        'success'       => 'Objekt :name verschoben',
        'title'         => 'Verschiebe :name an einen anderen Ort',
    ],
    'new_entity'    => [
        'error' => 'Bitte überprüfe deine Eingabe.',
        'fields'=> [
            'name'  => 'Name',
        ],
        'title' => 'Neues Objekt',
    ],
    'notes'         => [
        'actions'       => [
            'add'   => 'Notiz hinzufügen',
        ],
        'create'        => [
            'description'   => 'Erstelle eine neue Notiz',
            'success'       => 'Notiz \':name\' zu :entity hinzugefügt.',
            'title'         => 'Neue Notiz für :name',
        ],
        'destroy'       => [
            'success'   => 'Notiz \':name\' von :entity entfernt.',
        ],
        'edit'          => [
            'description'   => 'Aktualisiere eine bestehende Notiz',
            'success'       => 'Notiz \':name\' für :entity aktualisiert.',
            'title'         => 'Aktualisiere Notiz für :name',
        ],
        'fields'        => [
            'creator'   => 'Ersteller',
            'entry'     => 'Eintrag',
            'name'      => 'Name',
        ],
        'hint'          => 'Informationen, die nicht ganz in die Standardfelder eines Objektes passen oder privat bleiben sollen, können als Notiz hinzugefügt werden.',
        'index'         => [
            'title' => 'Notizen für :name',
        ],
        'placeholders'  => [
            'name'  => 'Name der Notiz, Beobachtung oder Anmerkung',
        ],
    ],
    'or_cancel'     => 'oder <a href=":url">abbrechen</a>',
    'panels'        => [
        'appearance'            => 'Aussehen',
        'description'           => 'Beschreibung',
        'general_information'   => 'Allgemeine Informationen',
        'history'               => 'Geschichte',
        'move'                  => 'Verschieben',
    ],
    'permissions'   => [
        'action'    => 'Aktion',
        'actions'   => [
            'delete'    => 'Löschen',
            'edit'      => 'Bearbeiten',
            'read'      => 'Lesen',
        ],
        'allowed'   => 'Erlaubt',
        'fields'    => [
            'member'    => 'Mitglied',
            'role'      => 'Rolle',
        ],
        'helper'    => 'Benutze dieses Interface um die Berechtigungen von Nutzern und Rollen mit diesem Objekt  fein zu justieren.',
        'success'   => 'Berechtigungen gespeichert.',
        'title'     => 'Berechtigungen',
    ],
    'placeholders'  => [
        'character'     => 'Wähle einen Character',
        'entity'        => 'Objekt',
        'event'         => 'Wähle ein Ereignis',
        'family'        => 'Wähle eine Familie',
        'image_url'     => 'Du kannst ein Bild auch von einer URL hochladen',
        'location'      => 'Wähle einen Ort',
        'organisation'  => 'Wähle eine Organisation',
        'section'       => 'Wähle eine Kategorie',
    ],
    'relations'     => [
        'actions'   => [
            'add'   => 'Füge eine Beziehung hinzu',
        ],
        'fields'    => [
            'location'  => 'Ort',
            'name'      => 'Name',
            'relation'  => 'Beziehung',
        ],
        'hint'      => 'Beziehungen zwischen Objekten können erstellt werden, um deren Verbindung darzustellen.',
    ],
    'remove'        => 'Löschen',
    'save'          => 'Speichern',
    'save_and_new'  => 'Speichern und neu',
    'search'        => 'Suchen',
    'select'        => 'Auswählen',
    'tabs'          => [
        'attributes'    => 'Attribute',
        'events'        => 'Ereignisse',
        'notes'         => 'Notizen',
        'permissions'   => 'Berechtigungen',
        'relations'     => 'Beziehungen',
    ],
    'update'        => 'Aktualisieren',
    'view'          => 'Ansehen',
];
