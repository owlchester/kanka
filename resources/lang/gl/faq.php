<?php

return [
    'app_backup'            => [
        'answer'    => 'Realizamos dúas copias de seguridade cada día para evitar pérdidas de datos. As nosas propias campañas están no servidor, así que non queremos correr riscos!',
        'question'  => 'Con que frecuencia se realizan copias de seguridade dos datos de Kanka?',
    ],
    'attribute-templates'   => [
        'answer'    => <<<'TEXT'
A mellor maneira de explicar os Padróns de atributos é con un exemplo: imaxina que o teu mundo ten un montón de entidades do tipo Lugar, e en moitos destes Lugares, queres crear un atributo para a populación, o clima e o nivel de criminalidade.

Poderías facer iso en cada un dos Lugares que crees, pero iso é moi tedioso e podes esquecerte facilmente de engadir todos eses atributos nalgunha das entidades. Para isto son útiles os Padróns de atributos.

Podes crear un Padrón de atributos con eses atributos (Populación, Clima, Nivel de criminalidade...) e despois aplicalo aos teus Lugares. Isto creará automáticamente eses atributos, permitíndote esquecerte de ter que crealos manualmente, e simplemente editar os seus valores na entidade!
TEXT
,
        'question'  => 'Que son os Padróns de atributos?',
    ],
    'backup'                => [
        'answer'    => 'Unha vez ao día, podes exportar todos os datos da túa campaña nun arquivo ZIP. Na aplicación, fai click en "Campaña" no menú da esquerda, e dalle a "Exportar". Durante os seguintes 30 minutos terás dispoñíbel a descarga dos datos da túa campaña. Este arquivo non pode ser subido a Kanka, só está pensado para uso personal, por se queres ter a túa propia copia, ou por se non queres volver usar Kanka.',
        'question'  => 'Como podo facer unha copia de seguridade ou exportar a miña campaña?',
    ],
    'bugs'                  => [
        'answer'    => 'Simplemente entra no noso :discord e informa do erro na canle #errors-and-bugs.',
        'question'  => 'Como podo informar dun erro?',
    ],
    'campaign-sync'         => [
        'answer'    => 'Kanka non ten esta funcionalidade. No seu lugar, se o que queres é ter múltiples grupos dentro do mesmo mundo, considera usar a mesma campaña e separar os grupos usando misións, etiquetas, ou permisos.',
        'question'  => 'Podo sincronizar entidades entre varias campañas?',
    ],
    'conversations'         => [
        'answer'    => 'As conversas poden ser conversas entre personaxes ou entre membras da campaña. Se, por exemplo, queres documentar unha conversa importante entre PNXs e PXs, podes facelo usando este módulo. Tamén poden ser usadas para xogar campañas de forma escrita.',
        'question'  => 'Que son as Conversas?',
    ],
    'custom'                => [
        'answer'    => 'Kanka vén con un conxunto de tipos de entidade predefinidos que interaccionan entre si. Permitir tipos de entidade personalizados requeriría unha reconstrución completa da aplicación e iría en contra do seu propósito de ter uns tipos predefinidos que axudan no proceso de creación de mundos. Dito isto, as Etiquetas que Kanka ofrece son o suficientemente flexibles como para ser usadas para representar tipos de entidade personalizados.',
        'question'  => 'Podo crear tipos de entidade personalizados?',
    ],
    'delete-campaign'       => [
        'answer'    => 'Vai ao taboleiro da campaña e fai click en "Campaña" no menú da esquerda. Se eres administradora da campaña, aparecerache un botón de "Eliminar". Eliminar unha campaña é unha acción permanente que borrará todos os datos dos nosos servidores, incluíndo as imaxes.',
        'question'  => 'Como podo eliminar unha campaña?',
    ],
    'early-access'          => [
        'answer'    => 'O Acceso Anticipado é o noso xeito de recompensar ás nosas incríbeis subscriptoras, dándolles un periodo de 30 días nos que poden probar as últimas novedades antes que calquera outra persoa.',
        'question'  => 'Que é o Acceso Anticipado?',
    ],
    'entity-notes'          => [
        'answer'    => 'Todas as entidades teñen unha lapela "Notas de entidade", que son pequenos fragmentos de texto aos cales se lles pode asignar permisos de visibilidade individualmente. Tamén podes darlle permiso ás túas xogadoras para crear e editar notas de entidade sen que teñan permiso para editar as entidades de forma completa.',
        'question'  => 'Como lidia Kanka con información parcialmente oculta?',
    ],
    'fields'                => [
        'answer'    => 'Resposta',
        'category'  => 'Categoría',
        'locale'    => 'Localización',
        'order'     => 'Orde',
        'question'  => 'Pregunta',
    ],
    'free'                  => [
        'answer'    => <<<'TEXT'
Si! Cremos firmemente que a túa situación económica non debería afectar ao teu disfrute dos xogos de rol ou da creación de mundos, así que sempre manteremos a parte principal da aplicación gratuita. Non obstante, se queres tomar un rol máis activo nesta viaxe, apóianos e vota nas funcionalidades que son máis relevantes para ti, o cal podes facer mediante unha subscripción.

Ademais de votar na dirección que toma Kanka, apoiarnos permitirache acceder a :boosters, aumentar o tamaño máximo dos arquivos subidos, engadir o teu nome ao salón da fama, ter mellores iconas, e moito máis!
TEXT
,
        'question'  => 'Seguirá a aplicación sendo de balde?',
    ],
    'gods-and-religions'    => [
        'answer'    => 'Recomendamos crear os deuses como Personaxes, e crear as relixións como Organizacións. Se queres atopar rapidamente as túas deidades, recomendamos etiquetalas cunha Etiqueta apropiada.',
        'question'  => 'Onde crear deuses e relixións?',
    ],
    'help'                  => [
        'answer'    => 'En primeiro lugar, grazas por querer axudar! Sempre estamos interesadas en xente que poida axudar coas traducións, probar novas funcionalidades, ou que poidan axudar a novas usuarias. Tamén nos encanta que a xente promocione Kanka para chegar a usuarias en lugares nos que nunca pensáramos. O mellor que podes facer é unirte a nós no :discord, onde hai unha canle dedicada a axudar.',
        'question'  => 'Como podo axudar?',
    ],
    'map'                   => [
        'answer'    => 'O módulo Mapas soporta imaxes PNG, JPG, e SVG. Estes mapas poden ter capas, grupos, e punteiros de varias formas e tamaños que ligan con outras entidades da campaña.',
        'question'  => 'Podo subir mapas a Kanka?',
    ],
    'mobile'                => [
        'answer'    => 'Actualmente non hai aplicación móbil de Kanka, pero a maioría da web funciona perfectamente nun dispositivo móbil. Esperamos que o apoio a través de subscricións nos permita crear unha aplicación móbil algún día, pero non é algo esperado no futuro próximo.',
        'question'  => 'Hai unha aplicación móbil? Hai unha planexada?',
    ],
    'monsters'              => [
        'answer'    => 'Recomendamos usar o módulo Razas para pobos, especies, monstros, e calquera ser vivo que non sexa unha personaxe.',
        'question'  => 'Onde crear monstros?',
    ],
    'multiworld'            => [
        'answer'    => 'Podes ser parte de tantas campañas como queiras, incluíndo as creadas por ti. Para crear ou cambiar a outra campaña, vai ao taboleiro e arriba á dereita podes facer clic na túa campaña actual para mostrar a interface de cambio de campaña.',
        'question'  => 'Podo ter máis dunha campaña?',
    ],
    'nested'                => [
        'answer'    => 'Se prefires ver as túas entidades na forma de árbore por defecto, podes facelo dende o teu Perfil, nas opcións de Deseño. Aí podes marcar a opción de Vista en árbore. Isto afecta á túa conta, non ás túas campañas.',
        'question'  => 'Podo configurar as listas para que aparezan en forma de árbore por defecto?',
    ],
    'organise_play'         => [
        'answer'    => 'Estamos asociadas con :lfgm, que che permite organizar as túas sesións co teu grupo. Podes sincronizar os datos da túa campaña de Kanka coa túa campaña de LFGM para mostrar as túas próximas dispoñibilidades directamente no taboleiro da campaña.',
        'question'  => 'Como podo administrar cando fago as miñas sesións?',
    ],
    'permissions'           => [
        'answer'    => 'Por suposto, é por iso que creamos Kanka! Podes invitar todas as túas xogadoras ás túas campañas e darlles roles e permisos. Construimos o sistema para ser extremadamente flexible (podes usar opcións de inclusión e de exclusión) para cubrir as máximas necesidades e situacións posíbeis.',
        'question'  => 'Podo limitar a información que as miñas xogadoras ven na miña campaña?',
    ],
    'plans'                 => [
        'answer'    => <<<'TEXT'
O plan a longo prazo para Kanka é crearmos unha ferramenta de creación de mundos e administración de campañas versátil que non sexa dependente dun sistema de xogo de rol en concreto, con contido administrado pola comunidade na forma de "Padróns da comunidade". Outro obxetivo noso é crearmos ferramentas que sexa integrables con outras plataformas como aplicacións de taboleiros virtuais.

Usamos Kanka nós mesmas, así que non temos plans de deixar de desenvolvela e de mellorala. Por se acaso, o proxecto tamén é de código aberto e pode ser retomado pola comunidade se algo nos pasara nalgún momento.
TEXT
,
        'question'  => 'Cales son os plans a longo prazo?',
    ],
    'public-campaigns'      => [
        'answer'    => 'Podes explorar a páxina :public-campaigns para ver como outras persoas usan Kanka para as súas campañas.',
        'question'  => 'Como usan Kanka outras persoas?',
    ],
    'renaming-modules'      => [
        'answer'    => 'Por defecto, Kanka non deixa que cambios o nome dos módulos. Isto é debido á corrección gramática e á experiencia das usuarias con linguas que teñen palabras con xénero. Aínda así, unha campaña potenciada pode cambiar o nome dos módulos na barra lateral usando CSS personalizado.',
        'question'  => 'Podo renomear módulos? Por exemplo Familias a Clans, ou Organizacións a Faccións?',
    ],
    'sections'              => [
        'community'     => 'Comunidade',
        'general'       => 'Xeral',
        'other'         => 'Miscelánea',
        'permissions'   => 'Permisos',
        'pricing'       => 'Prezos',
        'worldbuilding' => 'Creación de mundos',
    ],
    'show'                  => [
        'return'    => 'Voltar a Preguntas Frecuentes',
        'timestamp' => 'Actualizado por última vez en :date',
        'title'     => 'Preguntas Frecuentes :name',
    ],
    'unboost'               => [
        'answer'    => 'Quitar a potenciación dunha campaña non elimina ningún dato, simplemente oculta a información e funcionalidades correspondentes á potenciación. Se voltares potenciala, a información e funcionalidades estarán dispoñíbeis de novo na mesma forma na que estaban antes de que quitases a potenciación da campaña.',
        'question'  => 'Que pasa se unha campaña deixa de estar potenciada?',
    ],
    'user-switch'           => [
        'answer'    => 'Os permisos poden ser complicados, especialmente en campañas grandes. Como administradora da campaña, podes ir á páxina de membras da campaña e facer clic no botón "Ver como" que aparecerá xunto a cada membra non administradora. Facer isto permitirache ver a campaña da mesma forma que a vería a usuaria seleccionada. Esta é a forma máis fácil de comprobar os permisos da túa campaña.',
        'question'  => 'Os permisos da miña campaña están configurados, como podo comprobalos?',
    ],
    'visibility'            => [
        'answer'    => 'Só a xente que ti invites á campaña pode ver e interactuar co que creases. Os teus datos son privados e sempre no teu control. Tamén podes configurar a túa campaña como pública para que usuarias non rexistradas poidan vela.',
        'question'  => 'Pode ver o meu mundo calquera persoa?',
    ],
];
