<?php

return [
    'actions'       => [
        'add'   => 'neue Gruppe hinzufügen',
    ],
    'bulks'         => [
        'delete'    => '{1} entfernt :count Gruppe .|[2,*] entfernt :count Gruppen.',
        'patch'     => '{1} aktualisiere :count group.|[2,*] aktualisiere :count groups.',
    ],
    'create'        => [
        'success'   => 'Gruppe :name erzeugen',
        'title'     => 'neue Gruppe',
    ],
    'delete'        => [
        'success'   => 'Gruppe :name gelöscht',
    ],
    'edit'          => [
        'success'   => 'Gruppe :name aktualisiert',
        'title'     => 'Gruppe :name editieren',
    ],
    'fields'        => [
        'is_shown'  => 'Zeige Gruppenmarker',
        'position'  => 'Position',
    ],
    'helper'        => [
        'amount_v3' => 'Markierungen können mithilfe von Kartengruppen gruppiert werden. Jede Gruppe kann dann beim Erkunden einer Karte angeklickt werden, um schnell alle Markierungen darin ein- oder auszublenden.',
    ],
    'hints'         => [
        'is_shown'  => 'Wenn diese Option aktiviert ist, werden die Gruppenmarker standardmäßig auf der Karte angezeigt.',
    ],
    'index'         => [
        'title' => 'Gruppe von :name',
    ],
    'pitch'         => [],
    'placeholders'  => [
        'name'          => 'Geschäfte, Schatz, NSC,',
        'position'      => 'Optionales Feld zum Festlegen der Reihenfolge, in der die Gruppen angezeigt werden.',
        'position_list' => 'nach :name',
    ],
    'reorder'       => [
        'save'      => 'neue Reihenfolge speichern',
        'success'   => '{1} ordne neu :count group.|[2,*] ordne neu :count groups.',
        'title'     => 'Gruppe neu ordnen',
    ],
];
