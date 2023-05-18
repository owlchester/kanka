<?php

return [
    'actions'   => [
        'export'    => 'Exportar los datos de la campaña',
    ],
    'errors'    => [
        'limit' => 'La campaña ya se ha exportado una vez hoy. Vuelva a intentarlo mañana.',
    ],
    'helpers'   => [
        'import'    => 'Estas exportaciones no se pueden reimportar y están pensadas para tu propia tranquilidad o si ya no piensas utilizar Kanka. Para una experiencia de exportación e importación más robusta, por favor mira la :api.',
        'intro'     => 'Los administradores de una campaña pueden exportarla una vez al día. Esto generará dos archivos zip en segundo plano. El primer archivo zip contiene todas las entidades de la campaña, mientras que el segundo contiene todas las imágenes. Recibirás una notificación en Kanka en cuanto los archivos zip estén listos para ser descargados.',
        'json'      => 'El contenido exportado se proporciona en formato de archivo JSON. JSON es un formato basado en texto, y puedes abrirlo en un editor de texto o en el navegador.',
    ],
    'success'   => 'Se está preparando la exportación de la campaña. Recibirás una notificación en Kanka cuando esté lista para descargar.',
    'title'     => 'Exportación de campaña',
];
