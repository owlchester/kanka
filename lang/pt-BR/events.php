<?php

return [
    'create'        => [
        'title' => 'Novo Evento',
    ],
    'destroy'       => [],
    'edit'          => [],
    'events'        => [
        'helper'    => 'Eventos que tem essa entidade como seu evento primário são exibidos aqui.',
        'title'     => 'Evento :name Eventos',
    ],
    'fields'        => [
        'date'      => 'Data',
        'event'     => 'Evento Primário',
        'events'    => 'Eventos',
    ],
    'helpers'       => [
        'date'              => 'Este campo pode conter qualquer coisa e não está vinculado aos calendários da campanha. Para vincular este evento a um calendário, adicione-o no calendário ou no sub-menu de lembretes deste evento.',
        'nested_without'    => 'Exibindo todos os eventos que não tem um evento primário. Clique em uma linha para ver os eventos secundários.',
    ],
    'index'         => [],
    'placeholders'  => [
        'date'  => 'Uma data para o seu evento',
        'name'  => 'Nome do evento',
        'type'  => 'Cerimonia, Festival, Desastre, Batalha, Nascimento',
    ],
    'show'          => [
        'tabs'  => [
            'events'    => 'Eventos',
        ],
    ],
    'tabs'          => [
        'calendars' => 'Introduções de Calendário',
    ],
];
