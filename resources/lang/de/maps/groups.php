<?php

return [
    'actions'       => [
        'add'   => 'neue Gruppe hinzufügen',
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
        'amount'            => 'Eine Gruppe kann mit einem Marker versehen werden, mit dem Sie alle Geschäfte einer Stadt ein- oder ausblenden können. Eine Karte kann bis zu :amount Gruppen haben.',
        'boosted_campaign'  => ':boosted können :amount Gruppen besitzen.',
    ],
    'hints'         => [
        'is_shown'  => 'Wenn diese Option aktiviert ist, werden die Gruppenmarker standardmäßig auf der Karte angezeigt.',
    ],
    'placeholders'  => [
        'name'      => 'Geschäfte, Schatz, NSC,',
        'position'  => 'Optionales Feld zum Festlegen der Reihenfolge, in der die Gruppen angezeigt werden.',
    ],
];
