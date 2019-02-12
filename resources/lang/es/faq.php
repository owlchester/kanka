<?php

return [
    'fields'    => [
        'answer'    => 'Respuesta',
        'category'  => 'Categoría',
        'question'  => 'Pregunta',
    ],
    'show'      => [
        'return'    => 'Volver a las FAQ',
        'timestamp' => 'Última actualización el :date',
        'title'     => 'FAQ :name',
    ],
    'free' => [
        'question' => '¿La app seguirá siendo gratis?',
        'answer' => '¡Sí! Creemos que tu situación económica no debería impedir que disfrutes de los juegos de rol y de la creación de mundos, y por eso siempre mantendremos gratis la aplicación. ¡Gracias a nuestros generosos mecenas en Patreon podemos cubrir los gastos mensuales del servidor y mantener la app libre de anuncios!'
    ],
    'multiworld' => [
        'question' => 'Estoy construyendo varios mundos en escenarios diferentes. ¿Necesito una cuenta diferente para cada mundo?',
        'answer' => '¡No hace falta! Puedes crear tantas “campañas” como quieras en la aplicación, y hacer que cada una represente mundos, escenarios o cualquier cosa que quieras. Una vez tengas varias campañas, puedes cambiar fácilmente entre ellas.'
    ],
    'visibility' => [
        'question' => '¿Quién puede ver mi mundo?',
        'answer' => 'Solo las personas que invites a tu campaña pueden verla e interactuar con ella. Tus datos son privados y siempre están bajo tu control.'
    ],
    'permissions' => [
        'question' => 'Quiero usar Kanka para construir mi mundo de rol, pero quiero que mis jugadores tengan acceso a algunas de las entidades y editar sus personajes. ¿Es posible?',
        'answer' => '¡Por supuesto, para eso hemos creado Kanka! Puedes invitar a todos tus jugadores a tus campañas, y darles roles y permisos. Hemos construido el sistema para que sea extremadamente flexible (con opción de incluir o de excluir) para cubrir las máximas necesidades y situaciones posibles.'
    ],
    'attribute-templates' => [
        'question' => '¿Qué son las “Plantillas de atributos”?',
        'answer' => 'La mejor forma de explicártelo es con un ejemplo. Imagina que tu mundo tiene montones de localizaciones, y en muchas de ellas quieres acordarte de crear un atributo personalizado de “Población”, “Clima”, “Nivel de criminalidad”...

Podrías incluirlos manualmente en cada localización, pero puede ser un proceso tedioso y a veces se te puede olvidar el “Nivel de criminalidad”. Aquí es donde las plantillas de atributos resultan útiles.

Puedes crear una plantilla de atributos con aquellos atributos (población, clima, nivel de criminalidad, etc.) y aplicar después esa plantilla a tus localizaciones. De este modo, se aplicarán los atributos de la plantilla a las localizaciones, y todo lo que tendrás que hacer es cambiar los valores sin tener que acordarte de los atributos!'
    ],
];
