<?php

return [
    'create'        => [
        'success'   => 'Elemento engadido á liña temporal.',
        'title'     => 'Novo elemento da liña temporal',
    ],
    'delete'        => [
        'success'   => 'Elemento ":name" eliminado.',
    ],
    'edit'          => [
        'success'   => 'Elemento actualizado.',
        'title'     => 'Editar elemento da liña temporal',
    ],
    'fields'        => [
        'date'              => 'Data',
        'era'               => 'Era',
        'icon'              => 'Icona',
        'use_entity_entry'  => 'Mostra abaixo a entrada da entidade adxunta. O texto deste elemento, se existe, será mostrado primeiro.',
    ],
    'helpers'       => [
        'entity_is_private' => 'A entidade do elemento é privada.',
        'icon'              => 'Copia o HTML dunha icona de :fontawesome ou de :rpgawesome',
        'is_collapsed'      => 'O elemento aparece colapsado por defecto.',
    ],
    'placeholders'  => [
        'date'      => 'por exemplo 42 de marzo ou 1332-1337',
        'name'      => 'Obrigatorio se non se seleccionou ningunha entidade',
        'position'  => 'Posición na lista de elementos da era. Déixao en branco para engadilo ao final.',
    ],
];
