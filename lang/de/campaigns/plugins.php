<?php

return [
    'actions'       => [
        'bulks'             => [
            'disable'   => 'deaktiviere plugins',
            'enable'    => 'aktiviere plugins',
            'update'    => 'aktualisiere plugins',
        ],
        'changelog'         => 'Änderungsprotokoll',
        'disable'           => 'Plugin deaktivieren',
        'enable'            => 'Plugin aktivieren',
        'go_to_marketplace' => 'Gehe zum Marktplatz',
        'import'            => 'Importieren',
        'update'            => 'Plugin aktualisieren',
        'update_available'  => 'Update verfügbar!',
    ],
    'bulks'         => [
        'delete'    => '{1} entferne :count plugin.|[2,*] entferte :count plugins',
        'disable'   => '{1} deaktiviere :count plugin.|[2,*] deaktivierte :count plugins.',
        'enable'    => '{1} aktiviere :count plugin.|[2,*] aktivierte :count plugins.',
        'update'    => '{1} aktualisiere :count plugin.|[2,*] aktualisierte :count plugins.',
    ],
    'destroy'       => [
        'success'   => 'Plugin :plugin entfernt.',
    ],
    'disabled'      => [
        'success'   => 'Plugin :plugin deaktiviert',
    ],
    'empty_list'    => 'Die Kampagne hat derzeit keine Plugins. Gehen Sie zum Marktplatz, um einige zu installieren, und kehren Sie zurück, um sie zu aktivieren.',
    'enabled'       => [
        'success'   => 'Plugin :plugin aktiviert',
    ],
    'errors'        => [
        'invalid_plugin'    => 'Ungültiges Plugin.',
    ],
    'fields'        => [
        'name'      => 'Plugin Name',
        'obsolete'  => 'Dieses Plugin wurde vom Kanka-Team als veraltet markiert, was bedeutet, dass es nicht mehr so funktioniert, wie es ursprünglich von seinem Ersteller beabsichtigt war.',
        'status'    => 'Status',
        'type'      => 'Plugin Typ',
    ],
    'import'        => [
        'button'                => 'Importieren',
        'created'               => 'Folgende Objekte wurden erstellt:',
        'helper'                => 'Sie sind im Begriff, :count Objekte aus dem :plugin -Plugin zu importieren. Wenn dieses Plugin zuvor importiert wurde, können Änderungen, die Sie an den importierten Objekten vorgenommen haben, verloren gehen.',
        'no_new_entities'       => 'Es müssen keine neuen Objekte importiert werden.',
        'option_only_import'    => 'Importieren Sie nur neue Objekte und überspringen Sie zuvor importierte Objekte.',
        'option_private'        => 'Importieren Sie alle Objekte als privat.',
        'success'               => '{1} Importiert :count Objekt aus dem Plugin :plugin. |[2,*] Importiert :count  Objekte aus dem Plugin zählen :plugin.',
        'title'                 => 'Importieren :plugin',
        'updated'               => 'Folgende Objekte wurden aktualisiert:',
    ],
    'info'          => [
        'helper'        => 'Wenn eine neue Version eines Plugins veröffentlicht wird, können Sie es auf die neueste Version für Ihre Kampagne aktualisieren.',
        'title'         => 'Plugin :plugin Aktualisierungen',
        'updates'       => 'Aktualisierungen',
        'your_version'  => 'Deine Version',
    ],
    'pitch'         => 'Installiere und verwalte Plug-ins vom :marketplace.',
    'status'        => [
        'always'    => 'Dieser Plugin-Typ ist immer aktiv, es sei denn, er wird entfernt.',
        'disabled'  => 'Deaktiviert',
        'enabled'   => 'Aktviert',
    ],
    'templates'     => [
        'name'  => ':name von :user',
    ],
    'title'         => 'Kampagne :name Plugin',
    'types'         => [
        'attribute' => 'Attributvorlage',
        'pack'      => 'Inhaltspaket',
        'theme'     => 'Thema',
    ],
    'update'        => [
        'success'   => 'Plugin :plugin aktualisiert.',
    ],
];
