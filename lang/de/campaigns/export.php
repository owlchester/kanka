<?php

return [
    'actions'   => [
        'export'    => 'Exportieren Sie die Kampagnendaten',
    ],
    'errors'    => [
        'limit' => 'Die Kampagne wurde heute schon einmal exportiert. Bitte versuchen Sie es morgen erneut.',
    ],
    'helpers'   => [
        'import'    => 'Diese Exporte können nicht erneut importiert werden und dienen Ihrer eigenen Sicherheit oder wenn Sie Kanka nicht mehr verwenden möchten. Für eine robustere Export- und Importerfahrung schauen Sie sich bitte die :api an.',
        'intro'     => 'Eine Kampagne kann einmal täglich von den Administratoren der Kampagne exportiert werden. Dadurch werden im Hintergrund zwei ZIP-Dateien generiert. Die erste ZIP-Datei enthält alle Objekte der Kampagne, während die zweite ZIP-Datei alle Bilder enthält. Sie erhalten eine Benachrichtigung in Kanka, sobald die ZIP-Dateien zum Download bereitstehen.',
        'json'      => 'Der exportierte Inhalt wird im JSON-Dateiformat bereitgestellt. JSON ist ein textbasiertes Format und Sie können es in einem Texteditor oder im Browser öffnen.',
    ],
    'success'   => 'Der Kampagnenexport wird vorbereitet. Sie werden in Kanka benachrichtigt, sobald es zum Herunterladen bereit ist.',
    'title'     => 'Kampagnen-Export',
];
