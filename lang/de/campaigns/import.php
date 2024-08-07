<?php

return [
    'actions'       => [
        'import'    => 'Lade den Export hoch',
    ],
    'description'   => 'Importiere das Objekt, Beiträge, Attribute, die Galerie und andere Elemente aus einem Kampagnenexport in diese Kampagnen. Dies geschieht im backend und kann eine Weile dauern, also hole dir einen Kaffee. Du und die anderen Kampagnenadministratoren werden benachrichtigt, wenn der Importvorgang abgeschlossen ist.',
    'fields'        => [
        'file'      => 'ZIP-Datei exportieren',
        'updated'   => 'Letztes Update',
    ],
    'form'          => 'Formular hochladen',
    'limitation'    => 'Es werden nur ZIP-Dateien akzeptiert. Maximal :size.',
    'progress'      => [
        'uploading' => 'Hochladen',
        'validating'=> 'Validierung',
    ],
    'status'        => [
        'failed'    => 'Fehlgeschlagen',
        'finished'  => 'Beendet',
        'queued'    => 'In Warteschlange',
        'running'   => 'Laufend',
    ],
    'title'         => 'Importieren',
];
