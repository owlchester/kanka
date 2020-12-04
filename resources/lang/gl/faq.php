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
];
