<?php

return [
    'call-to-action'    => [
        'max'       => [
            'helper'    => 'Du kannst keine weiteren Dateien anhängen, es sei denn, du entfernst eine vorhandene Datei.',
            'limit'     => 'Dieses Objekt hat sein Dateilimit erreicht.',
        ],
        'upgrade'   => [
            'limit'     => 'Du hast das Limit von :limit Dateien für dieses Objekt erreicht.',
            'premium'   => 'Upgrade auf eine Premium-Kampagne, um unbegrenzt Dateien anzuhängen und noch mehr kreative Flexibilität zu erhalten.',
            'upgrade'   => 'Upgrade auf eine Premium-Kampagne, um bis zu :limit Dateien anzuhängen und noch mehr kreative Flexibilität zu erhalten.',
        ],
    ],
    'create'            => [
        'helper'            => 'Füge eine Datei zu :name hinzu. Die Datei wird auf das Speicherlimit der Galerie angerechnet.',
        'success_plural'    => '{1} Datei :name hinzugefügt.|[2,*] :count der hinzugefügten Dateien.',
        'title'             => 'Neue Datei für :entity',
    ],
    'destroy'           => [
        'success'   => 'Datei :file entfernt',
    ],
    'fields'            => [
        'file'  => 'Datei',
        'files' => 'Dateien',
        'name'  => 'Dateiname',
    ],
    'max'               => [
        'title' => 'Limit erreicht',
    ],
    'update'            => [
        'success'   => 'Datei :file aktualisiert',
        'title'     => 'Objektdatei aktualisiert',
    ],
];
