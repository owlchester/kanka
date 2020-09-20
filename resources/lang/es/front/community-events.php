<?php

return [
    'actions'       => [
        'return'        => 'Volver a los eventos',
        'send'          => 'Participar',
        'show_ongoing'  => 'Ver evento y participar',
        'show_past'     => 'Ver evento y ganadores',
        'update'        => 'Actualizar entrega',
        'view'          => 'Ver entrega',
    ],
    'description'   => 'Presentamos eventos de creación de mundos para nuestra comunidad y anunciamos nuestras entidades favoritas.',
    'fields'        => [
        'comment'       => 'Comentario',
        'entity_link'   => 'Enlace a la entidad',
        'rank'          => 'Rango',
        'submitter'     => 'Participante',
    ],
    'index'         => [
        'ongoing'   => 'Eventos actuales',
        'past'      => 'Eventos anteriores',
    ],
    'participate'   => [
        'description'   => '¿El evento te inspira? Crea una entidad en una de tus campañas públicas y envíanos en enlace a ella desde el formulario siguiente. Puedes cambiar o borrar tu entrega en cualquier momento.',
        'login'         => 'Entra en tu cuenta para participar en el evento.',
        'participated'  => 'Ya has participado en este evento. Puedes editar o eliminar la entrega.',
        'success'       => [
            'modified'  => 'Los cambios en la entrega se han guardado.',
            'removed'   => 'Tu entrega se ha eliminado.',
            'submit'    => 'Tu entrega se ha enviado. Puedes editarla o eliminarla en cualquier momento.',
        ],
        'title'         => 'Participar en el evento',
    ],
    'placeholders'  => [
        'comment'       => 'Comentario acerca de tu entrega (opcional)',
        'entity_link'   => 'Copia y pega aquí en enlace a la entidad',
    ],
    'results'       => [
        'description'       => 'Nuestro jurado ha seleccionado las siguientes entregas como ganadoras del evento.',
        'title'             => 'Ganadores del evento',
        'waiting_results'   => '¡El evento ha terminado! El jurado del evento evaluará las entregas y, en cuanto se seleccionen los ganadores, se mostrarán a continuación.',
    ],
    'show'          => [
        'participants'  => '{1} :number entrega presentada.|[2,*] :number entregas presentadas.',
        'title'         => 'Evento :name',
    ],
    'title'         => 'Eventos',
];
