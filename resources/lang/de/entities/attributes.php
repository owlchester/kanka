<?php

return [
    'actions'       => [
        'apply_template'    => 'Eine Attributvorlage anwenden',
        'manage'            => 'Verwalten',
        'more'              => 'Mehr Optionen',
        'remove_all'        => 'Alles löschen',
    ],
    'create'        => [],
    'destroy'       => [],
    'edit'          => [],
    'errors'        => [
        'loop'      => 'Diese Attributberechnung enthält eine Endlosschleife!',
        'too_many'  => 'Dieses Objekt enthält zu viele Felder. Weitere Attribute können nicht hinzugefügt werden. Löschen Sie zuerst einige Attribute, bevor Sie weitere hinzufügen können.',
    ],
    'fields'        => [
        'attribute'             => 'Attribut',
        'community_templates'   => 'Community Vorlagen',
        'is_private'            => 'Private Attribute',
        'is_star'               => 'Angepinnt',
        'template'              => 'Vorlage',
        'value'                 => 'Wert',
    ],
    'filters'       => [
        'name'  => 'Attributname',
        'value' => 'Attributwert',
    ],
    'helpers'       => [
        'delete_all'    => 'Möchten Sie wirklich alle Attribute dieses Objekts löschen?',
        'setup'         => 'Sie können Elemente wie TP oder Intelligenz eines Objekts mittels Attributen darstellen. Attribute können Sie manuell hinzufügen, indem sie auf den :manage Button klicken oder Sie wenden eine Attributsvorlage an.',
    ],
    'hints'         => [
        'is_private2'   => 'Wenn diese Option ausgewählt ist, können nur Mitglieder der Rolle :admin-role die Attribute dieses Objekts sehen.',
    ],
    'index'         => [
        'success'   => 'Attribute für :entity aktualisiert',
        'title'     => 'Attribute für :name',
    ],
    'placeholders'  => [
        'attribute' => 'Anzahl der Eroberungen, Challenge Rating, Initiative, Bevölkerung',
        'block'     => 'Blockname',
        'checkbox'  => 'Checkbox Name',
        'icon'      => [
            'class' => 'FontAwesome oder RPG Awesome class: fas fa-users',
            'name'  => 'Symbolname',
        ],
        'random'    => [
            'name'  => 'Attributname',
            'value' => '1-100 oder Liste von Werten, die durch ein Komma getrennt sind',
        ],
        'section'   => 'Abteilungsname',
        'template'  => 'Wähle eine Vorlage',
        'value'     => 'Wert des Attributs',
    ],
    'show'          => [
        'title' => ':name Attribut',
    ],
    'template'      => [
        'success'   => 'Attributvorlage :name wird auf :entity angewendet',
        'title'     => 'Wende eine Attributvorlage auf :name an',
    ],
    'types'         => [
        'attribute' => 'Attribute',
        'block'     => 'Block',
        'checkbox'  => 'Checkbox',
        'icon'      => 'Symbol',
        'random'    => 'Zufällig',
        'section'   => 'Abteilung',
        'text'      => 'Mehrzeiliger Text',
    ],
    'update'        => [
        'success'   => 'Attribut von :entity aktualisiert',
    ],
    'visibility'    => [
        'entry'     => 'Das Attribut wird im Objektmenü angezeigt.',
        'private'   => 'Attribut nur für Mitglieder der Rolle "Admin" sichtbar.',
        'public'    => 'Attribut für alle Mitglieder sichtbar.',
        'tab'       => 'Das Attribut wird nur im Attribute-Reiter angezeigt.',
    ],
];
