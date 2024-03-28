<?php

return [
    'actions'   => [
        'boost_name'    => 'Mejora :name',
    ],
    'available' => ':amount/:total potenciadores disponibles',
    'benefits'  => [
        'boosted'       => 'Al mejorar una campaña con :one potenciador se desbloqueará el acceso al :marketplace, opciones de temas, un mayor tamaño de archivos para todos los miembros, recuperación de entidades eliminadas, y :more.',
        'more'          => 'más funciones sorprendentes',
        'superboosted'  => 'Al potenciar una campaña con :amount potenciadores se desbloquearán todas las ventajas de una campaña potenciada, así como una galería de la campaña, los registros completos de los cambios realizados en las entidades y :more.',
    ],
    'boost'     => [
        'actions'   => [
            'confirm'   => '¡Mejórala!',
            'remove'    => 'Deja de potenciar :campaign',
            'subscribe' => 'Suscríbete a Kanka',
            'upgrade'   => 'Actualiza tu suscripción',
        ],
        'confirm'   => '¡Qué emoción! Estás a punto de potenciar :campaign. Esto asignará uno (:cost) de tus potenciadores de campaña disponibles.',
        'duration'  => 'Los potenciadores asignados permanecen asignados hasta que los elimines manualmente o cuando tu suscripción finalice.',
        'errors'    => [
            'boosted'           => 'Oh oh, ¡Parece que :campaign ya está impulsada!',
            'out-of-boosters'   => '¡Oh, no! No tienes suficientes potenciadores disponibles. Tienes :available y necesitas :cost. Deja de impulsar otras campañas, o :upgrade.',
        ],
        'pitch'     => 'Hazte suscriptor para desbloquear potenciadores de campaña.',
        'success'   => 'La campaña :campaign ahora está potenciada. ¡Disfruta de todas las nuevas e increíbles funciones!',
        'title'     => 'Potenciar :campaign',
        'upgrade'   => 'actualiza tu suscripción',
    ],
    'campaign'  => [
        'boosted'       => 'Potenciado por :user desde :time',
        'premium'       => 'Premium gracias a :user desde :time',
        'standard'      => 'Estándar',
        'superboosted'  => 'Superpotenciado por :user desde :time',
        'unboosted'     => 'Sin potenciar',
    ],
    'intro'     => [
        'anyone'    => 'No estás limitado a impulsar campañas que hayas creado. Puedes impulsar cualquier campaña en la que participes o que puedas ver. Esto incluye campañas en las que seas jugador o :public que disfrutes.',
        'data'      => 'Cuando una campaña deja de estar potenciada, se elimina el acceso a las funciones potenciadas. Sin embargo, no se elimina nada del contenido, por lo que al volver a impulsar la campaña en el futuro se recupera el acceso a este.',
        'first'     => 'Las funciones avanzadas se desbloquean asignando tus potenciadores para potenciar o superpotenciar una campaña. La cantidad de potenciadores que tienes viene determinada por tu :subscription. Este número está a tu disposición en todo momento mientras seas suscriptor. Al potenciar una campaña le asignarás uno de tus potenciadores, mientras que al superpotenciar una campaña le asignarás tres.',
    ],
    'pitch'     => [
        'benefits'      => [
            'backup'        => 'Recupera una entidad previamente eliminada durante un máximo de :amount días',
            'customisable'  => 'Personalización total del aspecto de una campaña',
            'entities'      => 'Mejor control sobre el comportamiento y la apariencia de las entidades',
            'icons'         => 'Acceso a miles de hermosos iconos para mapas y líneas de tiempo',
            'relations'     => 'Explorar visualmente las relaciones de una entidad en el explorador visual',
            'title'         => 'Las campañas potenciadas obtienen',
            'upload'        => 'Mayor capacidad de carga de archivos para todos los miembros de la campaña',
        ],
        'description'   => 'Asigna potenciadores a las campañas y ayuda a desbloquear funciones increíbles para todos los participantes. ¿No te impresionan las campañas potenciadas? ¡Tenemos campañas superpotenciadas para ti!',
        'more'          => 'Consulta la lista completa de ventajas en nuestra página :boosters.',
        'title'         => 'Lleva una campaña al siguiente nivel con personalización y ventajas para todos sus miembros',
    ],
    'ready'     => [
        'available'         => 'Tus potenciadores de campaña disponibles.',
        'pricing'           => 'Todos nuestros niveles de suscripción incluyen al menos un potenciador de campaña y comienzan a partir de :amount al mes.',
        'pricing-amount'    => ':currency:amount',
        'title'             => 'Potenciar una campaña',
    ],
    'superboost'=> [
        'actions'   => [
            'confirm'   => '¡Superpotenciala!',
            'instead'   => '¡Superpotenciala por :count!',
            'remove'    => 'Dejar de superpotenciar :campaign',
        ],
        'confirm'   => '¡Qué emocionante! Estás a punto de superpotenciar :campaign. Esto asignará tres (:cost) de tus potenciadores de campaña disponibles.',
        'errors'    => [
            'boosted'   => 'Oh oh, ¡Parece que :campaign ya está superpotenciada!',
        ],
        'success'   => 'La campaña :campaign está ahora superpotenciada. ¡Disfruta de todas las nuevas e increíbles funciones!',
        'title'     => 'Superpotenciar :campaign',
        'upgrade'   => '¿Listo para la experiencia Kanka definitiva? Superpotenciar :campaign asignará :cost potenciadores de campaña adicionales.',
    ],
    'title'     => 'Potenciadores de campaña',
    'unboost'   => [
        'confirm'   => 'Sí, estoy segur@',
        'status'    => [
            'boosting'      => 'potenciando',
            'superboosting' => 'superpotenciando',
        ],
        'success'   => 'La campaña :campaign ya no está potenciada y tus potenciadores vuelven a estar disponibles.',
        'title'     => 'De-potenciando una campaña',
        'warning'   => '¿Estás seguro de que quieres parar de :action :campaign? Esto liberará los potenciadores asignados y ocultará todo el contenido y las características relacionadas con las mejoras hasta que la campaña sea potenciada de nuevo.',
    ],
];
