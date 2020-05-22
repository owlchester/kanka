<?php

return [
    'create'        => [
        'description'   => 'Erstelle einen neuen Menü Link',
        'success'       => 'Menü Link \':name\' created.',
        'title'         => 'Neuer Menü Link',
    ],
    'destroy'       => [
        'success'   => 'Menü Link \':name\' entfernt.',
    ],
    'edit'          => [
        'description'   => 'Verändere einen Menü Punkt.',
        'success'       => 'Menü Link \':name\' aktualisiert.',
        'title'         => 'Menü Link :name',
    ],
    'fields'        => [
        'entity'    => 'Objekt',
        'filters'   => 'Filter',
        'menu'      => 'Menü',
        'name'      => 'Name',
        'position'  => 'Position',
        'tab'       => 'Reiter',
        'type'      => 'Objekttyp',
    ],
    'helpers'       => [
        'entity'    => 'Richten Sie diesen Menülink ein, um direkt zu einem Objekt zu gelangen. Das Feld :tab steuert, welche der Registerkarten fokussiert ist. Das :menu Feld steuert, welche Unterseite des Objekts geöffnet wird.',
        'position'  => 'Dieses Feld kann genutzt werden um die Linkreihenfolge im Menü festzulegen.',
        'type'      => 'Richten Sie diesen Menülink ein, um direkt zu einer Liste von Objekten zu gelangen. Kopieren Sie zum Filtern der Ergebnisse Teile der URL in die Liste der gefilterten Objekte nach :? Melden Sie sich im Feld :filter an',
    ],
    'index'         => [
        'add'           => 'Neuer Menü Link',
        'description'   => 'Verwalte die Menü Links von :name',
        'header'        => 'Menü Link von :name',
        'title'         => 'Menü Links',
    ],
    'placeholders'  => [
        'entity'    => 'Wähle ein Objekt',
        'filters'   => 'location_id=15&type=city',
        'menu'      => 'Menü Unterseite (Nutze den letzten Text der URL)',
        'name'      => 'Name des Menü Links',
        'tab'       => 'Geschichte, Beziehungen, Notizen',
    ],
    'show'          => [
        'description'   => 'Eine detaillierte Ansicht eines Menü Links',
        'tabs'          => [
            'information'   => 'Informationen',
        ],
        'title'         => 'Menü Link :name',
    ],
];
