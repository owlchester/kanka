<?php

return [
    'actions'       => [
        'apply_template'    => 'Eine Attributvorlage anwenden',
        'load'              => 'Laden',
        'manage'            => 'Verwalten',
        'more'              => 'Mehr Optionen',
        'remove_all'        => 'Alles löschen',
        'save_and_edit'     => 'Bestätigen und Bearbeiten',
        'save_and_story'    => 'Bestätigen und Ansehen',
        'show_hidden'       => 'Ausgeblendete Attribute anzeigen',
        'toggle_privacy'    => 'Privat/öffentlich',
    ],
    'create'        => [],
    'destroy'       => [],
    'edit'          => [],
    'errors'        => [
        'loop'                  => 'Diese Attributberechnung enthält eine Endlosschleife!',
        'no_attribute_selected' => 'Wähle zunächst ein oder mehrere Eigenschaften aus.',
        'too_many_v2'           => 'Maximale Felder erreicht (:count/:max). Lösche zuerst einige Eigenschaften, bevor du weitere hinzufügen kannst.',
    ],
    'fields'        => [
        'attribute'             => 'Attribut',
        'community_templates'   => 'Community Vorlagen',
        'is_private'            => 'Private Attribute',
        'is_star'               => 'Angepinnt',
        'preferences'           => 'Einstellungen',
        'template'              => 'Vorlage',
        'value'                 => 'Wert',
    ],
    'filters'       => [
        'name'  => 'Attributname',
        'value' => 'Attributwert',
    ],
    'helpers'       => [
        'delete_all'    => 'Möchten Sie wirklich alle Attribute dieses Objekts löschen?',
        'is_private'    => 'Erlaube nur Mitgliedern der Rolle :admin-role, die Attribute dieses Objekts zu sehen.',
        'setup'         => 'Sie können Elemente wie TP oder Intelligenz eines Objekts mittels Attributen darstellen. Attribute können Sie manuell hinzufügen, indem sie auf den :manage Button klicken oder Sie wenden eine Attributsvorlage an.',
    ],
    'hints'         => [],
    'index'         => [
        'success'   => 'Attribute für :entity aktualisiert',
        'title'     => 'Attribute für :name',
    ],
    'labels'        => [
        'checkbox'  => 'Checkbox Name',
        'name'      => 'Attributsname',
        'section'   => 'Abteilungsname',
        'value'     => 'Attributswert',
    ],
    'live'          => [
        'success'   => 'Attribute :attribute aktualisiert',
        'title'     => ':attribute aktualisieren',
    ],
    'placeholders'  => [
        'attribute' => 'Anzahl der Eroberungen, Challenge Rating, Initiative, Bevölkerung',
        'block'     => 'Blockname',
        'checkbox'  => 'Checkbox Name',
        'icon'      => [
            'class' => 'FontAwesome oder RPG Awesome class: fas fa-users',
            'name'  => 'Symbolname',
        ],
        'number'    => 'Nummernname',
        'random'    => [
            'name'  => 'Attributname',
            'value' => '1-100 oder Liste von Werten, die durch ein Komma getrennt sind',
        ],
        'section'   => 'Abteilungsname',
        'template'  => 'Wähle eine Vorlage',
        'value'     => 'Wert des Attributs',
    ],
    'ranges'        => [
        'text'  => 'Verfügbare Optionen: :options',
    ],
    'sections'      => [
        'unorganised'   => 'Unorganisiert',
    ],
    'show'          => [
        'hidden'    => 'Ausgeblendete Attribute',
        'title'     => ':name Attribut',
    ],
    'template'      => [
        'load'      => [
            'success'   => 'Vorlage geladen',
            'title'     => 'Aus Vorlage laden',
        ],
        'success'   => 'Attributvorlage :name wird auf :entity angewendet',
        'title'     => 'Wende eine Attributvorlage auf :name an',
    ],
    'title'         => 'Eigenschaften',
    'toasts'        => [
        'bulk_deleted'  => 'Eigenschaften gelöscht',
        'bulk_privacy'  => 'Eigenschaften Privatsphäre umgeschaltet',
        'lock'          => 'Attribut gesperrt',
        'pin'           => 'Attribut angepinnt',
        'unlock'        => 'Attribut freigeschaltet',
        'unpin'         => 'Attribut nicht angepinnt',
    ],
    'tutorials'     => [
        'character' => 'Sie können zum Beispiel die Eigenschaften :hp und :str haben.',
        'general'   => 'Attribute sind kleine Informationen, die mit :name verbunden sind.',
        'location'  => 'Sie könnten zum Beispiel eine Eigenschaft :pop. haben.',
    ],
    'types'         => [
        'attribute' => 'Attribute',
        'block'     => 'Block',
        'checkbox'  => 'Checkbox',
        'icon'      => 'Symbol',
        'number'    => 'Nummer',
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
