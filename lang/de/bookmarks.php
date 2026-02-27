<?php

return [
    'actions'           => [
        'customise' => 'Passe die Seitenleiste an',
    ],
    'create'            => [
        'title' => 'Neuer Menü Link',
    ],
    'destroy'           => [],
    'edit'              => [
        'title' => 'Menü Link :name',
    ],
    'fields'            => [
        'active'            => 'Aktiv',
        'dashboard'         => 'Dashboard',
        'default_dashboard' => 'Standard-Dashboard',
        'filters'           => 'Filter',
        'menu'              => 'Menü',
        'position'          => 'Position',
        'random_type'       => 'zufälliger Objekttyp',
        'selector'          => 'Quick Link-Konfiguration',
        'target'            => 'Ziel',
    ],
    'helpers'           => [
        'active'            => 'Inaktive Quicklinks werden nicht in der Seitenleiste angezeigt.',
        'css'               => 'Füge eine CSS-Klasse hinzu, die zum Link des Lesezeichens in der Seitenleiste hinzugefügt wird.',
        'dashboard'         => 'Lassen Sie den Quick Link auf eines der benutzerdefinierten Dashboards der Kampagne abzielen. Diese Funktion ist nur verfügbar für :boosted.',
        'default_dashboard' => 'Verknüpfen Sie stattdessen mit dem Standard-Dashboard der Kampagne. Es muss noch ein benutzerdefiniertes Dashboard ausgewählt werden.',
        'entity'            => 'Richten Sie diesen Menülink ein, um direkt zu einem Objekt zu gelangen. Das Feld :tab steuert, welche der Registerkarten fokussiert ist. Das :menu Feld steuert, welche Unterseite des Objekts geöffnet wird.',
        'position'          => 'Dieses Feld kann genutzt werden um die Linkreihenfolge im Menü festzulegen.',
        'random'            => 'Verwenden Sie dieses Feld, um einen Schnelllink zu einem zufälligen Objekt zu erhalten. Sie können den Link filtern, um nur zu einem bestimmten Objekttyp zu gelangen.',
        'selector'          => 'Konfigurieren Sie, wohin dieser Quicklink führt, wenn ein Benutzer in der Seitenleiste darauf klickt.',
        'type'              => 'Richten Sie diesen Menülink ein, um direkt zu einer Liste von Objekten zu gelangen. Kopieren Sie zum Filtern der Ergebnisse Teile der URL in die Liste der gefilterten Objekte nach :? Melden Sie sich im Feld :filter an',
    ],
    'index'             => [],
    'lists'             => [
        'empty' => 'Speicher Lesezeichen für Ihre am häufigsten verwendeten Objekte oder gefilterten Listen, um schneller darauf zugreifen zu können.',
    ],
    'placeholders'      => [
        'filters'   => 'location_id=15&type=city',
        'menu'      => 'Menü Unterseite (Nutze den letzten Text der URL)',
        'tab'       => 'Geschichte, Beziehungen, Notizen',
    ],
    'random_no_entity'  => 'Keine zufälligen Objekte gefunden.',
    'random_types'      => [
        'any'   => 'jedes Objekt',
    ],
    'reorder'           => [
        'success'   => 'Menü Links neu geordnet.',
        'title'     => 'Menü Links neu anordnen',
    ],
    'show'              => [],
    'targets'           => [
        'dashboard' => 'Eines der Dashboards der Kampagne',
        'entity'    => 'ein einzelnes Objekt',
        'random'    => 'ein zufälliges Objekt',
        'select'    => 'wähle eine Option',
        'type'      => 'Liste der Objekte eines bestimmten Objekttyps/Moduls',
    ],
    'visibilities'      => [
        'is_active' => <<<'TEXT'
Zeige den Quicklink
in der Seitenleiste an
TEXT
,
    ],
];
