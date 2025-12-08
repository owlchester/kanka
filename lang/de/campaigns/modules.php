<?php

return [
    'actions'       => [
        'create'    => 'Modul erstellen',
        'customise' => 'Anpassen',
    ],
    'create'        => [
        'helper'    => 'Erstelle ein neues benutzerdefiniertes Modul, um Objekte zu speichern, die nicht in andere Module passen.',
        'success'   => 'Neues Modul erstellt.',
        'title'     => 'Neues Modul',
    ],
    'delete'        => [
        'confirm'   => 'Schreibe :code, wenn du sicher sind, dass du das benutzerdefinierte Modul :name dauerhaft löschen willst.',
        'helper'    => 'Bist du sicher, dass du das benutzerdefinierte Modul :name entfernen möchtest? Dadurch werden auch alle Objekte, Lesezeichen und Widgets, die mit diesem Modul verknüpft sind, dauerhaft gelöscht.',
        'success'   => 'Modul :name gelöscht',
        'title'     => 'Modul löschen',
    ],
    'errors'        => [
        'disabled'  => 'Das Modul :name ist deaktiviert. :fix',
        'limit'     => 'Kampagnen sind derzeit nur auf :max benutzerdefinierte Module beschränkt, während wir diese neue Funktion ausbauen.',
    ],
    'fields'        => [
        'icon'      => 'Modulsymbol',
        'plural'    => 'Modul Mehrzahl Name',
        'singular'  => 'Modul Einzal Name',
    ],
    'helpers'       => [
        'custom'    => 'Dies ist ein benutzerdefiniertes Modul.',
        'icon'      => 'Das Symbol :fontawesome, zum Beispiel :example.',
        'plural'    => 'Der Pluralname für Objekte des neuen Moduls. Zum Beispiel, Tränke',
        'roles'     => 'Wähle die Rollen aus, die die Berechtigung haben sollen, Objekte dieses neuen Moduls anzuzeigen. Dies kann später in den Rollenberechtigungen geändert werden.',
        'singular'  => 'Der Einzahlname für ein Objekt des neuen Moduls. Zum Beispiel, Trank',
    ],
    'pitch'         => 'Benenne das diesem Modul zugeordnete Symbol für die gesamte Kampagne um und ändere es.',
    'pitch-custom'  => 'Erstelle benutzerdefinierte Module, um einzigartige Objekte zu speichern.',
    'rename'        => [
        'helper'    => 'Ändere den Namen und das Symbol des Moduls im Laufe der Kampagne. Lasse das Feld leer, um die Standardeinstellung von Kanka zu verwenden.',
        'success'   => 'Modul angepasst',
        'title'     => 'Passe das Modul :module an',
    ],
    'reset'         => [
        'default'   => 'Dadurch werden nur die Standardmodule zurückgesetzt, nicht aber die benutzerdefinierten Module.',
        'success'   => 'Die Kampagnenmodule wurden zurückgesetzt.',
        'title'     => 'Benutzerdefinierte Modulnamen und -symbole zurücksetzen',
        'warning'   => 'Bist du sicher, dass du die Kampagnenmodule auf ihre ursprünglichen Namen und Symbole zurücksetzen möchtest?',
    ],
    'sections'      => [
        'custom'    => 'Benutzerdefinierte Module',
        'default'   => 'Standard-Module',
        'features'  => 'Funktionen',
    ],
    'states'        => [
        'disable'   => 'Deaktivieren',
        'enable'    => 'Aktivieren',
    ],
];
