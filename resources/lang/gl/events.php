<?php

return [
    'create'        => [
        'description'   => 'Crear un novo evento',
        'success'       => 'Evento ":name" creado.',
        'title'         => 'Novo evento',
    ],
    'destroy'       => [
        'success'   => 'Evento ":name" eliminado.',
    ],
    'edit'          => [
        'success'   => 'Evento ":name" actualizado.',
        'title'     => 'Editar evento ":name"',
    ],
    'events'        => [
        'helper'    => 'Os eventos que teñen esta entidade como o seu evento superior son mostrados aquí.',
        'title'     => 'Eventos do evento ":name"',
    ],
    'fields'        => [
        'date'      => 'Data',
        'event'     => 'Evento pai',
        'events'    => 'Eventos',
        'image'     => 'Imaxe',
        'location'  => 'Localización',
        'name'      => 'Nome',
        'type'      => 'Tipo',
    ],
    'helpers'       => [
        'date'          => 'Este campo pode conter calquera cousa e non está ligado aos calendarios da campaña. Para ligar este evento a un calendario, faino dende o propio calendario ou na lapela "Lembretes" deste evento.',
        'nested_parent' => 'Mostrando os eventos de ":parent".',
        'nested_without'=> 'Mostrando todos os eventos que non teñen un evento pai. Fai clic nunha fila para ver os seus descendentes.',
    ],
    'index'         => [
        'add'           => 'Novo evento',
        'description'   => 'Xestiona os eventos de ":name"',
        'header'        => 'Eventos de ":name"',
        'title'         => 'Eventos',
    ],
    'placeholders'  => [
        'date'      => 'Data do teu evento',
        'location'  => 'Elixe un lugar',
        'name'      => 'Nome do evento',
        'type'      => 'Cerimonia, festival, desastre, batalla, nacemento...',
    ],
    'show'          => [
        'description'   => 'Vista detallada dun evento',
        'tabs'          => [
            'information'   => 'Información',
        ],
        'title'         => 'Evento ":name"',
    ],
    'tabs'          => [
        'calendars' => 'Entradas en calendarios',
    ],
];
