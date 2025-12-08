<?php

return [
    'actions'       => [
        'copy'  => 'Kopiere',
    ],
    'errors'        => [
        'permission'        => 'Sie dürfen keine Objekte dieses Typs in der Zielkampagne erstellen.',
        'permission_update' => 'Sie dürfen dieses Objekt nicht verschieben.',
        'same_campaign'     => 'Sie müssen eine andere Kampagne auswählen, in die das Objekt verschoben werden soll.',
        'unknown_campaign'  => 'Unbekennt Kamapgne',
    ],
    'fields'        => [
        'campaign'      => 'Zielkampagne',
        'copy'          => 'Kopiere',
        'select_one'    => 'Kampagne auswählen',
    ],
    'helpers'       => [
        'copy'  => 'Erstelle eine Kopie des Objekts in der Zielkampagne.',
    ],
    'panel'         => [
        'description'           => 'Wählen Sie eine Kampagne aus, in die Sie verschieben möchten, oder erstellen Sie eine Kopie dieses Objekts.',
        'description_bulk_copy' => 'Wählen Sie eine Kampagne aus, in die Sie die ausgewählten Objekte kopieren möchten.',
        'title'                 => 'Verschieben oder kopieren Sie ein Objekt in eine andere Kampagne',
    ],
    'success'       => 'Objekt :name verschoben',
    'success_copy'  => 'Objekt :name kopiert',
    'title'         => 'Bewege :name',
    'warnings'      => [
        'custom'    => 'Dieses Objekt gehört nicht zu einem Standardmodul, sondern zu einem benutzerdefinierten „:module“-Objekttyp. Sie wird als Notiz-Objekt in der Zielkampagne erstellt.',
    ],
];
