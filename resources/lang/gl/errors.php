<?php

return [
    '403'       => [
        'body'  => 'Parece que non tes permisos para acceder a esta páxina.',
        'title' => 'Permiso denegado',
    ],
    '403-form'  => [
        'help'  => 'Pode se que a túa sesión caducase. Intenta iniciar sesión de novo noutra xanela antes de gardar.',
    ],
    '404'       => [
        'body'  => 'Desculpas, a páxina que estás buscando non poido ser encontrada.',
        'title' => 'Páxina non encontrada',
    ],
    '500'       => [
        'body'  => [
            '1' => 'Mmh, parece que algo foi mal.',
            '2' => 'Enviouse un informe co erro, mais ás veces axudános saber máis sobre o que estabas a facer.',
        ],
        'title' => 'Erro',
    ],
    '503'       => [
        'body'  => [
            '1' => 'Kanka está en mantemento agora mesmo, o que normalmente significa que unha nova actualización está en camiño!',
            '2' => 'Desculpa polas molestias. Todo volverá á normalidade nuns poucos minutos.',
        ],
        'title' => 'Mantemento',
    ],
    '503-form'  => [
        'body'  => 'Non poidemos gardar os teus datos correctamente, o que xeralmente ocorre por unha das seguintes razóns. Por favor, abre Kanka nun :link. Se a aplicación está en mantemento, por favor, garda os teus datos nalgún outro sitio ata que volte estar en funcionamento. Se che saiu unha mensaxe dicindo "Checking your browser"/"Verificando o seu navegador", intenta facer clic en Gardar de novo.',
        'link'  => 'Nova xanela',
        'title' => 'Acorreu algo inesperado',
    ],
    'footer'    => 'Se precisas máis asistencia, contáctanos en hello@kanka.io ou no :discord',
];
