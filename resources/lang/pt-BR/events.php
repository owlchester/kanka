<?php

return [
    'create'        => [
        'success'       => 'Evento \':name\' criado.',
        'title'         => 'Criar um novo evento',
    ],
    'destroy'       => [
        'success'   => 'Evento \':name\' removido.',
    ],
    'edit'          => [
        'success'   => 'Evento \':name\' atualizado.',
        'title'     => 'Editar Evento :name',
    ],
    'events'        => [
        'helper'    => 'Eventos que tem essa entidade como seu evento-pai são mostrados aqui.',
        'title'     => 'Evento :name Eventos',
    ],
    'fields'        => [
        'date'      => 'Data',
        'event'     => 'Evento Pai',
        'events'    => 'Eventos',
        'image'     => 'Imagem',
        'location'  => 'Local',
        'name'      => 'Nome',
        'type'      => 'Tipo',
    ],
    'helpers'       => [
        'date'          => 'Este campo pode conter qualquer coisa e não está vinculado aos calendários da campanha. Para vincular este evento a uma agenda, adicione-o na agenda ou na guia de lembretes deste evento.',
        'nested_parent' => 'Mostrando os eventos de :parent.',
        'nested_without'=> 'Mostrando todos os eventos que não tem um evento-pai. Clique em uma linha para ver os eventos-filhos.',
    ],
    'index'         => [
        'add'           => 'Novo Evento',
        'header'        => 'Eventos de :name',
        'title'         => 'Eventos',
    ],
    'placeholders'  => [
        'date'      => 'A data para o seu evento',
        'location'  => 'Escolha um local',
        'name'      => 'Nome do evento',
        'type'      => 'Cerimonia, Festa, Desastre, Batalha, Nascimento',
    ],
    'show'          => [
        'tabs'          => [
            'events'        => 'Eventos',
        ],
        'title'         => 'Evento :name',
    ],
    'tabs'          => [
        'calendars' => 'Registros no Calendário',
    ],
];
