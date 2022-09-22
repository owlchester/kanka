<?php

return [
    'actions'   => [
        'export'    => 'Exportar os datos da campaña',
    ],
    'errors'    => [
        'limit' => 'A campaña xa foi exportada unha vez hoxe. Proba de novo mañá.',
    ],
    'helpers'   => [
        'import'    => 'Estas exportacións non poden ser reimportadas, só son para a túa propia paz mental e por se planexas deixar de usar Kanka. Para unha experiencia de exportación/importación máis robusta, podes usar a :api.',
        'intro'     => 'Unha campaña pode ser exportada unha vez ao día pola administración da campaña. Isto xerará dous ficheiros zip. O primeiro ficheiro contén todas as entidades da campaña, mentres que o segundo contén todas as imaxes. Recibirás unha notificación en Kanka tan pronto como os ficheiros estean preparados para ser descargados.',
        'json'      => 'O contido exportado está en formato JSON. JSON é un formato baseado en texto, e podes abrilo cun editor de texto ou no navegador.',
    ],
    'success'   => 'A exportación da campaña está sendo preparada. Recibirás unha notificación cando a descarga estea dispoñible.',
    'title'     => 'Exportación da campaña',
];
