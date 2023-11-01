<?php

return [
    'actions'   => [
        'customise' => 'Anpassen',
    ],
    'fields'    => [
        'icon'      => 'Modulsymbol',
        'plural'    => 'Modul Mehrzahl Name',
        'singular'  => 'Modul Einzal Name',
    ],
    'helpers'   => [
        'info'  => 'Eine Kampagne ist in mehrere Module aufgeteilt, die miteinander interagieren. Aktiviere oder deaktiviere diejenigen, die du nicht benötigst. Das Deaktivieren eines Moduls löscht keine seiner Daten, sondern blendet sie nur aus.',
    ],
    'pitch'     => 'Benenne das diesem Modul zugeordnete Symbol für die gesamte Kampagne um und ändere es.',
    'rename'    => [
        'helper'    => 'Ändere den Namen und das Symbol des Moduls im Laufe der Kampagne. Lasse das Feld leer, um die Standardeinstellung von Kanka zu verwenden.',
        'success'   => 'Modul angepasst',
        'title'     => 'Passe das Modul :module an',
    ],
    'reset'     => [
        'success'   => 'Die Kampagnenmodule wurden zurückgesetzt.',
        'title'     => 'Benutzerdefinierte Modulnamen und -symbole zurücksetzen',
        'warning'   => 'Bist du sicher, dass du die Kampagnenmodule auf ihre ursprünglichen Namen und Symbole zurücksetzen möchtest?',
    ],
    'states'    => [
        'disable'   => 'Deaktivieren',
        'enable'    => 'Aktivieren',
    ],
];
