<?php

return [
    'attribute-templates'   => [
        'answer'    => <<<'TEXT'
La mejor forma de explicártelo es con un ejemplo. Imagina que tu mundo tiene montones de localizaciones, y en muchas de ellas quieres acordarte de crear un atributo personalizado de “Población”, “Clima”, “Nivel de criminalidad”...

Podrías incluirlos manualmente en cada localización, pero puede ser un proceso tedioso y a veces se te puede olvidar el “Nivel de criminalidad”. Aquí es donde las plantillas de atributos resultan útiles.

Puedes crear una plantilla de atributos con aquellos atributos (población, clima, nivel de criminalidad, etc.) y aplicar después esa plantilla a tus localizaciones. De este modo, se aplicarán los atributos de la plantilla a las localizaciones, y todo lo que tendrás que hacer es cambiar los valores sin tener que acordarte de los atributos!
TEXT
,
        'question'  => '¿Qué son las “Plantillas de atributos”?',
    ],
    'conversations'         => [
        'answer'    => 'Se pueden crear conversaciones entre personajes o entre miembros de la campaña. Por ejemplo, si quieres documentar una charla importante entre PNJs y PJs, puedes hacerlo en este módulo. También se puede usar para jugar campañas online.',
        'question'  => '¿Qué son las conversaciones?',
    ],
    'fields'                => [
        'answer'    => 'Respuesta',
        'category'  => 'Categoría',
        'question'  => 'Pregunta',
    ],
    'free'                  => [
        'answer'    => '¡Sí! Creemos que tu situación económica no debería impedir que disfrutes de los juegos de rol y de la creación de mundos, y por eso siempre mantendremos gratis la aplicación. ¡Gracias a nuestros generosos mecenas en Patreon podemos cubrir los gastos mensuales del servidor y mantener la app libre de anuncios!',
        'question'  => '¿La app seguirá siendo gratis?',
    ],
    'help'                  => [
        'answer'    => 'Antes de nada, ¡gracias por ofrecerte! Siempre estamos interesados en aceptar ayuda con las traducciones, probar nuevas funciones, o ayudar a nuevos usuarios. También nos encanta cuando la gente promociona Kanka para que llegue a nuevos usuarios en lugares que nunca habíamos pensado. Tu mejor curso de acción es unirte a nosotros en el :discord, donde hay un canal dedicado a ofrecer ayuda. ¡También amamos a nuestros patrones en :patreon, si quieres apoyarnos y acceder a algunos beneficios!',
        'question'  => '¡Quiero ayudar! ¿Qué puedo hacer?',
    ],
    'map'                   => [
        'answer'    => <<<'TEXT'
Cada localización puede contener un mapa (png, jpg o svg) con puntos que se pueden colocar sobre él, personalizando el tamaño, forma, icono y color; y que enlacen a otras entidades o simplemente sean etiquetas.

Ten en cuenta que los mapas generados en sitios como Azgaar o Medieval Fantasy Town Generator comprimen los archivos, de forma que son incompatibles con Kanka. Para arreglar esto puedes abrir los archivos en Inskape o Photoshop y volver a guardar los archivos SGV antes de subirlos a Kanka.
TEXT
,
        'question'  => '¿Puedo subir mapas a Kanka?',
    ],
    'mobile'                => [
        'answer'    => 'Actualmente no hay ninguna app móvil para Kanka, pero la web funciona perfectamente en un dispositivo móvil. La única limitación es que la herramienta de menciones no funciona en el editor de textos :( Si el soporte de Patreon lo permite, espero poder pagar a alguien para que haga una app móvil algún día, pero no va a ocurrir en un futuro próximo.',
        'question'  => '¿Hay una app móvil? ¿Hay alguna planeada?',
    ],
    'multiworld'            => [
        'answer'    => '¡No hace falta! Puedes crear tantas “campañas” como quieras en la aplicación, y hacer que cada una represente mundos, escenarios o lo que quieras. Una vez tengas varias campañas, puedes cambiar fácilmente entre ellas.',
        'question'  => 'Estoy construyendo varios mundos en escenarios diferentes. ¿Necesito una cuenta diferente para cada mundo?',
    ],
    'permissions'           => [
        'answer'    => '¡Por supuesto, para eso hemos creado Kanka! Puedes invitar a todos tus jugadores a tus campañas, y darles roles y permisos. Hemos construido el sistema para que sea extremadamente flexible (con opción de incluir o de excluir) para cubrir las máximas necesidades y situaciones posibles.',
        'question'  => 'Quiero usar Kanka para construir mi mundo de rol, pero quiero que mis jugadores tengan acceso a algunas de las entidades y editar sus personajes. ¿Es posible?',
    ],
    'plans'                 => [
        'answer'    => <<<'TEXT'
Los planes a largo plazo para Kanka incluyen construir del todo esta herramienta versátil de worldbuilding y gestión de campañas RPG, manteniéndonos agnósticos (sin un sistema concreto de RPG). La comunidad puede añadir contenido específico mediante las Plantillas de la Comunidad. Un objetivo más ambicioso es llegar a integrar Kanka con otras plataformas, como las de rol virtual.

Por otro lado, muchos proyectos hobby acaban quemando y el creador los abandona. El Patreon está precisamente para ayudarme a reducir mis horas de trabajo y dedicar más tiempo a Kanka sin sacrificar la seguridad financiera de mi familia, además de cubrir los costes del servidor. Además, el proyecto es "open source" y la comunidad lo puede continuar en caso de que algo me ocurriera. Todos los datos de las campañas se pueden exportar una vez al día, en caso de que te preocupe perder todo tu contenido.
TEXT
,
        'question'  => '¿Qué planes hay a largo plazo? ¿Qué pasa si Ilestis se aburre de trabajar en Kanka?',
    ],
    'show'                  => [
        'return'    => 'Volver a las FAQ',
        'timestamp' => 'Última actualización el :date',
        'title'     => 'FAQ :name',
    ],
    'visibility'            => [
        'answer'    => 'Solo las personas que invites a tu campaña pueden verla e interactuar con ella. Tus datos son privados y siempre están bajo tu control.',
        'question'  => '¿Quién puede ver mi mundo?',
    ],
];
