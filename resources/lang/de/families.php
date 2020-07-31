<?php

return [
    'create'        => [
        'description'   => 'Erstelle eine neue Familie',
        'success'       => 'Familie \':name\' erstellt.',
        'title'         => 'Erstelle eine neue Familie',
    ],
    'destroy'       => [
        'success'   => 'Familie \':name\' entfernt.',
    ],
    'edit'          => [
        'success'   => 'Familie \':name\' aktualisiert.',
        'title'     => 'Bearbeite Familie :name',
    ],
    'families'      => [
        'title' => 'Familie :name Familien',
    ],
    'fields'        => [
        'families'  => 'Unterfamilien',
        'family'    => 'Übergeordnete Familie',
        'image'     => 'Bild',
        'location'  => 'Ort',
        'members'   => 'Mitglieder',
        'name'      => 'Name',
        'relation'  => 'Beziehung',
        'type'      => 'Typ',
    ],
    'helpers'       => [
        'descendants'   => 'Diese Liste enthält alle Familien, die der Familie untergeordnet sind, nicht nur die direkt unter ihr.',
        'nested'        => 'In der verschachtelten Ansicht kannst du deine Familien nach Oberfamilien sortiert sehen. Familien ohne übergeordneter Familie werden standardmäßig angezeigt. Familien mit Unterfamilien können angeklickt, werden damit man diese Familien sieht. Das geht so tief, bis es keine Unterfamilien mehr gibt.',
    ],
    'hints'         => [
        'members'   => 'Mitglieder einer Familie werden hier gelistet. Ein Charakter kann einer Familie hinzugefügt werden, in dem bei dem gewünschten Charakter das Familiendropdown genutzt wird.',
    ],
    'index'         => [
        'add'           => 'Neue Familie',
        'description'   => 'Verwalte die Familien von :name',
        'header'        => 'Familien von :name',
        'title'         => 'Familien',
    ],
    'members'       => [
        'helpers'   => [
            'all_members'       => 'Die folgende Liste zeigt alle Charaktere an, die Teil dieser Familie oder einer Unterfamilie sind.',
            'direct_members'    => 'Die meisten Familien haben Mitglieder, die sie anführen oder sie berühmt machen. Die folgenden Charaktere sind direkte Mitglieder der Familie.',
        ],
        'title'     => 'Familie :name Mitglieder',
    ],
    'placeholders'  => [
        'location'  => 'Wähle einen Ort',
        'name'      => 'Name der Familie',
        'type'      => 'königlich, edel, ausgestorben',
    ],
    'show'          => [
        'description'   => 'Eine detaillierte Ansicht der Familie',
        'tabs'          => [
            'all_members'   => 'Alle Mitglieder',
            'families'      => 'Familien',
            'members'       => 'Mitglieder',
            'relation'      => 'Beziehungen',
        ],
        'title'         => 'Familie :name',
    ],
];
