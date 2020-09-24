<?php

return [
    'create'        => [
        'description'   => 'Criar um novo evento',
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
    'fields'        => [
        'date'      => 'Data',
        'image'     => 'Imagem',
        'location'  => 'Local',
        'name'      => 'Nome',
        'type'      => 'Tipo',
    ],
    'helpers'       => [
        'date'  => 'Este campo pode conter qualquer coisa e não está vinculado aos calendários da campanha. Para vincular este evento a uma agenda, adicione-o na agenda ou na guia de lembretes deste evento.',
    ],
    'index'         => [
        'add'           => 'Novo Evento',
        'description'   => 'Gerencie os eventos de :name.',
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
        'description'   => 'Uma visão detalhada de um evento',
        'tabs'          => [
            'information'   => 'Informação',
        ],
        'title'         => 'Evento :name',
    ],
    'tabs'          => [
        'calendars' => 'Registros no Calendário',
    ],
];
