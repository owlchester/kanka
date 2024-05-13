<?php

return [
    'actions'   => [
        'add'   => 'Füge eine Fähigkeit hinzu',
        'reset' => 'Fähigkeit zurücksetzen',
    ],
    'create'    => [
        'success'           => 'Fähigkeit :ability hinzugefügt zu :entity',
        'success_multiple'  => 'Fähigkeiten :abilities hinzugefügt zu :entity',
        'title'             => 'Fügen Sie eine Fähigkeit hinzu zu :name',
    ],
    'fields'    => [
        'note'      => 'Notiz',
        'position'  => 'Position',
    ],
    'helpers'   => [
        'note'  => 'Sie können Objekte mit erweiterten Erwähnungen (z. B. :code) und Attributen der Objekte (z. B. :attr) in diesem Feld referenzieren.',
    ],
    'import'    => [
        'errors'    => [
            'no_race'       => 'Der Charakter hat keine Spezies',
            'not_character' => 'Das Objekt ist kein Charakter',
        ],
        'success'   => '{1} :count Fähigkeit importiert. | [2, *] :count Fähigkeiten importieren.',
    ],
    'reorder'   => [
        'parentless'    => 'kein übergepordnetes Objekt',
        'success'       => 'Fähigkeiten erfolgreich neu geordnet.',
    ],
    'show'      => [
        'helper'    => 'Fügen Sie diesem Objekt Fähigkeiten hinzu. Sie können die Sichtbarkeit jederzeit bearbeiten oder eine Fähigkeit entfernen. Fähigkeiten, die zu derselben übergeordneten Fähigkeit gehören, werden als Filterfelder angezeigt.',
        'reorder'   => 'Fähigkeiten neu anordnen',
        'title'     => 'Objektfähigkeiten für :name',
    ],
    'update'    => [
        'success'   => 'Objektfähigkeit: Fähigkeit aktualisiert.',
        'title'     => 'Objektfähigkeit für :name',
    ],
];
