<?php

return [
    'create'        => [
        'title' => 'Novo Evento',
    ],
    'destroy'       => [],
    'edit'          => [],
    'events'        => [
        'helper'    => 'Eventos que tem essa entidade como seu evento primário são exibidos aqui.',
    ],
    'fields'        => [
        'date'  => 'Data',
    ],
    'helpers'       => [
        'date'  => 'Este campo pode conter qualquer coisa e não está vinculado aos calendários da campanha. Para vincular este evento a um calendário, adicione-o no calendário ou no sub-menu de lembretes deste evento.',
    ],
    'index'         => [],
    'lists'         => [
        'empty' => 'Adicione momentos significativos, como batalhas, coroações ou descobertas, à história do seu mundo.',
    ],
    'placeholders'  => [
        'date'  => 'Uma data para o seu evento',
        'type'  => 'Cerimonia, Festival, Desastre, Batalha, Nascimento',
    ],
    'show'          => [],
    'tabs'          => [
        'calendars' => 'Entidades do Calendário',
    ],
];
