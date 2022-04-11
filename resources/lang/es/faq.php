<?php

return [
    'account-deletion'      => [
        'account_settings'  => 'Ajustes de la cuenta',
        'answer'            => 'Para eliminar tu cuenta, dirígete a la página de :account y baja hasta la sección de eliminación de la cuenta. Esto eliminará tu cuenta y todas las campañas de las que seas el único miembro.',
        'question'          => '¿Cómo puedo eliminar mi cuenta?',
    ],
    'app_backup'            => [
        'answer'    => 'Realizamos dos copias de seguridad al día para evitar cualquier pérdida de datos. Nuestras propias campañas están en el servidor, así que no queremos correr ningún riesgo!',
        'question'  => '¿Cada cuánto tiempo se hace una copia de seguridad de los datos de Kanka?',
    ],
    'attribute-templates'   => [
        'answer'    => <<<'TEXT'
La mejor forma de explicártelo es con un ejemplo. Imagina que tu mundo tiene montones de localizaciones, y en muchas de ellas quieres acordarte de crear un atributo personalizado de “Población”, “Clima”, “Nivel de criminalidad”...

Podrías incluirlos manualmente en cada localización, pero puede ser un proceso tedioso y a veces se te puede olvidar el “Nivel de criminalidad”. Aquí es donde las plantillas de atributos resultan útiles.

Puedes crear una plantilla de atributos con aquellos atributos (población, clima, nivel de criminalidad, etc.) y aplicar después esa plantilla a tus localizaciones. De este modo, se aplicarán los atributos de la plantilla a las localizaciones, y todo lo que tendrás que hacer es cambiar los valores sin tener que acordarte de los atributos!
TEXT
,
        'question'  => '¿Qué son las “Plantillas de atributos”?',
    ],
    'backup'                => [
        'answer'    => 'Una vez al día, puedes exportar todos los datos de tu campaña en un archivo ZIP. En la app, haz clic en "Campaña", en el menú de la izquierda, y dale a "Exportar". No podrás subir este archivo a Kanka, sino que está pensado para que estés tranquilo si no vas a usar más la app.',
        'question'  => '¿Cómo puedo hacer una copia de seguridad o exportar mi campaña?',
    ],
    'bugs'                  => [
        'answer'    => 'Simplemente únete a nuestro :discord e informa del error en el canal #errors-and-bugs.',
        'question'  => '¿Cómo puedo informar de un error?',
    ],
    'campaign-sync'         => [
        'answer'    => 'Kanka no tiene esta funcionalidad. Sin embargo, si quieres tener varios grupos en el mismo mundo, puedes usar la misma campaña y separar a los grupos mediante etiquetas, misiones y permisos.',
        'question'  => '¿Puedo sincronizar entidades entre varias campañas?',
    ],
    'conversations'         => [],
    'custom'                => [
        'answer'    => 'Kanka viene con un conjunto de entidades predefinidas que interactúan entre ellas. Permitir tipos de entidad personalizados requeriría volver a reconstruir la app desde cero y le quitaría su propósito como herramienta de creación. Además, la flexibilidad de Kanka permite que puedas representar cualquier tipo de entidad con las Etiquetas.',
        'question'  => '¿Puedo crear tipos de entidad personalizados?',
    ],
    'delete-campaign'       => [
        'answer'    => 'Ve al tablero de campaña y haz clic en "Campaña" en el menú de la izquierda. Si eres el administrador de la campaña, te aparecerá el botón de "Eliminar". Ten en cuenta que eliminar una campaña es una acción permanente que eliminará todos los datos almacenados en nuestros servidores, incluyendo las imágenes.',
        'question'  => '¿Cómo puedo eliminar una campaña?',
    ],
    'discord'               => [
        'answer'    => 'Para vincular tu cuenta de Kanka con :discord, primero has de hacer clic sobre tu avatar en la esquina superior derecha de la página e ir al Perfil. Desde ahí, navega hasta la subpágina de :apps y haz clic en Conectar.',
        'question'  => '¿Cómo vinculo mi cuenta de Kanka con Discord?',
    ],
    'early-access'          => [
        'answer'    => 'El acceso anticipado es nuestra manera de recompensar a nuestros increíbles suscriptores, dándoles un periodo exclusivo de 30 días en el que pueden probar las últimas novedades antes que el resto.',
        'question'  => '¿Qué es el acceso anticipado?',
    ],
    'entity-notes'          => [
        'answer'    => 'Todas las entidades tienen una pestaña de "Notas", que son pequeños fragmentos de texto que se pueden configurar para que solo sean visibles para ti (genial para los co-másters), solo para administradores o visibles para todos. También puedes dar permiso a tus jugadores para crear y editar estas notas sin darles acceso también a editar la entidad completa.',
        'question'  => '¿Como gestiona Kanka la información oculta?',
    ],
    'fields'                => [
        'answer'    => 'Respuesta',
        'category'  => 'Categoría',
        'locale'    => 'Locale',
        'order'     => 'Order',
        'question'  => 'Pregunta',
    ],
    'free'                  => [
        'answer'    => <<<'TEXT'

Además de votar sobre la dirección que tomará Kanka, al apoyarnos obtendrás un aumento en el tamaño de los archivos que puedes subir, añadiremos tu nombre en el muro de la fama, recibirás bonitos iconos predefinidos, podrás votar qué funciones se priorizan y mucho más!
TEXT
,
        'question'  => '¿La app seguirá siendo gratis?',
    ],
    'gods-and-religions'    => [
        'answer'    => 'Recomendamos que crees los dioses como Personajes y las religiones como Organizaciones. Para encontrar a tus deidades rápidamente, puedes etiquetarlas con la Etiqueta o el tipo apropiados.',
        'question'  => '¿Dónde puedo crear dioses y religiones?',
    ],
    'help'                  => [
        'answer'    => 'Antes de nada, ¡gracias por ofrecerte! Siempre estamos interesados en aceptar ayuda con las traducciones, probar nuevas funciones, o ayudar a nuevos usuarios. También nos encanta cuando la gente promociona Kanka para que llegue a nuevos usuarios en lugares que nunca habíamos pensado. Tu mejor curso de acción es unirte a nosotros en el :discord, donde hay un canal dedicado a ofrecer ayuda. ¡También amamos a nuestros patrones en :patreon, si quieres apoyarnos y acceder a algunos beneficios!',
        'question'  => '¡Quiero ayudar! ¿Qué puedo hacer?',
    ],
    'map'                   => [
        'answer'    => 'Cada localización puede contener un mapa (png, jpg o svg) al que se pueden añadir puntos, personalizando su tamaño, forma, icono y color; y que enlacen a otras entidades o que simplemente sean etiquetas.',
        'question'  => '¿Puedo subir mapas a Kanka?',
    ],
    'mobile'                => [
        'answer'    => 'Actualmente no hay ninguna app móvil para Kanka, pero la web funciona perfectamente en un dispositivo móvil. La única limitación es que la herramienta de menciones no funciona en el editor de textos :( Si el soporte de Patreon lo permite, espero poder pagar a alguien para que haga una app móvil algún día, pero no va a ocurrir en un futuro próximo.',
        'question'  => '¿Hay una app móvil? ¿Hay alguna planeada?',
    ],
    'monsters'              => [
        'answer'    => 'Recomendamos usar el módulo de Razas para etnias, especies, monstruos y cualquier ser viviente que no sea un personaje.',
        'question'  => '¿Dónde se crean los monstruos?',
    ],
    'multiworld'            => [
        'answer'    => '¡No hace falta! Puedes crear tantas “campañas” como quieras en la aplicación, y hacer que cada una represente mundos, escenarios o lo que quieras. Una vez tengas varias campañas, puedes cambiar fácilmente entre ellas.',
        'question'  => 'Estoy construyendo varios mundos en escenarios diferentes. ¿Necesito una cuenta diferente para cada mundo?',
    ],
    'nested'                => [
        'answer'    => 'Si prefieres ver tus entidades en vista anidada por defecto, puedes hacerlo desde las opciones de Diseño, dentro de tu Perfil. Allí puedes seleccionar la opción "Vista anidada por defecto". Esto solo afectará a tu cuenta.',
        'question'  => '¿Puedo configurar las listas para que aparezcan anidadas por defecto?',
    ],
    'organise_play'         => [],
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
    'public-campaigns'      => [
        'answer'    => 'Puedes ojear las :public-campaigns para ver cómo los demás usan Kanka en sus campañas.',
        'question'  => '¿Cómo usan Kanka otras personas?',
    ],
    'renaming-modules'      => [
        'answer'    => 'Aunque esto sería fácil de hacer en inglés y otros idiomas que no usan géneros, cambiar el nombre de los módulos rompería la corrección gramatical y la experiencia de usuario para la mayoría de idiomas de Kanka.',
        'question'  => '¿Puedo renombrar los módulos? Por ejemplo, Clanes en vez de Familias, o Facciones en lugar de Organizaciones.',
    ],
    'sections'              => [
        'community'     => 'Comunidad',
        'general'       => 'General',
        'other'         => 'Otros',
        'permissions'   => 'Permisos',
        'pricing'       => 'Tarifas',
        'worldbuilding' => 'Creación de mundos',
    ],
    'show'                  => [
        'return'    => 'Volver a las FAQ',
        'timestamp' => 'Última actualización el :date',
        'title'     => 'FAQ :name',
    ],
    'unboost'               => [
        'answer'    => 'Al dejar de mejorar una campaña, no se elimina ningún dato, sino que se esconde. Si vuelves a mejorar la campaña, toda la información y funcionalidades volverán a estar disponibles con la misma configuración de antes.',
        'question'  => '¿Qué pasa si dejo de mejorar una campaña?',
    ],
    'user-switch'           => [
        'answer'    => 'Manejar los permisos puede ser complicado, sobre todo en campañas grandes. Como administrador de campaña, puedes navegar por la página de miembros y hacer clic en el botón de "Ver como" junto a cada miembro. Así, podrás navegar por la campaña y verla como ellos lo harán. Esta es la manera más fácil de comprobar los permisos de tu campaña.',
        'question'  => 'Los permisos de mi campaña ya están configurados, ¿cómo puedo comprobarlos?',
    ],
    'visibility'            => [
        'answer'    => 'Solo las personas que invites a tu campaña pueden verla e interactuar con ella. Tus datos son privados y siempre están bajo tu control. Por otro lado, puedes configurar tu campaña como pública para que la vean los usuarios no registrados.',
        'question'  => '¿Quién puede ver mi mundo?',
    ],
];
