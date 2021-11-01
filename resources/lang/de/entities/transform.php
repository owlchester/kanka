<?php

return [
    'actions'   => [
        'transform' => 'umwandeln',
    ],
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
        'description'       => 'Haben Sie dieses Objekt als einen Typ erstellt, aber festgestellt, dass ein anderer Typ besser dazu passt? Keine Sorge, Sie können den Typ des Objekts jederzeit ändern. Bitte beachten Sie, dass aufgrund der unterschiedlichen Felder zwischen den Objekten einige Daten verloren gehen können.',
        'title'             => 'wandle ein Objekt um',
    ],
    'success'   => 'Objekt :name umgewandelt',
    'title'     => ':name umwandeln',
];
