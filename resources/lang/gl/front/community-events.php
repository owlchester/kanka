<?php

return [
    'actions'       => [
        'return'        => 'Voltar á lista de eventos',
        'send'          => 'Participar',
        'show_ongoing'  => 'Ver evento e participar',
        'show_past'     => 'Ver evento e gañadoras',
        'update'        => 'Actualizar entrega',
        'view'          => 'Ver entrega',
    ],
    'description'   => 'Organizamos frecuentemente eventos de creación de mundos para a nosa comunidade, mostrando as nosas participacións favoritas.',
    'fields'        => [
        'comment'       => 'Comentario',
        'entity_link'   => 'Ligazón á entidade',
        'rank'          => 'Rango',
        'submitter'     => 'Participante',
    ],
    'index'         => [
        'ongoing'   => 'Eventos en curso',
        'past'      => 'Eventos pasados',
    ],
    'participate'   => [
        'description'   => 'Inspírate este evento? Crea unha entidade nunha das túas campañas públicas e envíanos a ligazón á entidade no formulario de abaixo. Podes cambiar ou eliminar a túa entrega en calquera momento.',
        'login'         => 'Inicia sesión para participar no evento',
        'participated'  => 'Xa fixeches unha entrega neste evento. Podes editala ou eliminala.',
        'success'       => [
            'modified'  => 'Os cambios na túa entrega foron gardados.',
            'removed'   => 'A túa entrega foi eliminada',
            'submit'    => 'A túa entrega foi enviada. Podes editala ou eliminala en calquera momento.',
        ],
        'title'         => 'Participar no evento',
    ],
    'placeholders'  => [
        'comment'       => 'Comentario sobre a túa entrega (opcional)',
        'entity_link'   => 'Copia e pega a ligazón á entidade aquí',
    ],
    'results'       => [
        'description'       => 'O noso xurado seleccionou as seguintes entregas como gañadoras do evento.',
        'title'             => 'Gañadoras do evento',
        'waiting_results'   => 'O evento terminou! O xurado do evento evaluará as entregas e tan pronto como sexan seleccionadas as gañadoras, mostraranse aquí.',
    ],
    'show'          => [
        'participants'  => '{1} :number entrega presentada.|[2,*] :number entregas presentadas.',
        'title'         => 'Evento :name',
    ],
    'title'         => 'Eventos',
];
