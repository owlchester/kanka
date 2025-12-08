<?php

return [
    'actions'   => [],
    'bulk'      => [
        'errors'    => [
            'unknown_type'  => 'Unbekannter oder unzulässige Objekttyp.',
        ],
        'success'   => '{1} :count Objekt zu neuem Typ umgewandelt: :type.|[2,*] :count Objekte zu neuem Typ umgewandelt: :type.',
    ],
    'fields'    => [
        'select_one'    => 'Eines auswählen',
        'target'        => 'Neuer Objekttyp',
    ],
    'panel'     => [
        'bulk_description'  => 'Verändere den Objekttyp mehrerer Objekte. Seien Sie sich bewusst, dass dadurch Daten verloren gehen könnten aufgrund unterschiedlicher Felder zwischen den Objekttypen.',
        'bulk_title'        => 'Massenumwandlung von Objekten',
        'title'             => 'wandle ein Objekt um',
    ],
    'success'   => 'Objekt :name umgewandelt',
    'title'     => ':name umwandeln',
];
