<?php

return [
    'actions'       => [
        'add_month'     => 'Adicionar um mês',
        'add_weekday'   => 'Adicionar um dia da semana',
        'add_year'      => 'Adicionar um nome para o ano',
    ],
    'create'        => [
        'description'   => 'Criar um novo calendário',
        'success'       => 'Calendário \':name\' criado.',
        'title'         => 'Novo Calendário',
    ],
    'destroy'       => [
        'success'   => 'Calendário \':name\' removido',
    ],
    'edit'          => [
        'success'   => 'Calendário \':name\' atualizado.',
        'title'     => 'Editar Calendário :name',
    ],
    'event'         => [
        'destroy'   => 'Evento removido do calendário \':name\'',
        'helpers'   => [
            'add'   => 'Adicione um evento existente para esse calendário usando a lista.',
            'new'   => 'Ou você pode criar um novo evento simplesmente fornecendo um nome.',
        ],
        'modal'     => [
            'title' => 'Adicione um evento ao calendário',
        ],
        'success'   => 'Evento \':event\' adicionado ao calendário.',
    ],
    'fields'        => [
        'comment'           => 'Comentar',
        'current_day'       => 'Dia Atual',
        'current_month'     => 'Mês Atual',
        'current_year'      => 'Ano Atual',
        'date'              => 'Data Atual',
        'has_leap_year'     => 'Tem anos bissextos',
        'is_recurring'      => 'Recorrente',
        'leap_year_amount'  => 'Adicionar Dias',
        'leap_year_month'   => 'Mês',
        'leap_year_offset'  => 'Cada',
        'leap_year_start'   => 'Ano Bissexto',
        'length'            => 'Duração do Evento',
        'months'            => 'Meses',
        'name'              => 'Nome',
        'parameters'        => 'Parâmetros',
        'recurring_until'   => 'Recorrente até o ano',
        'seasons'           => 'Estações',
        'suffix'            => 'Sufixo',
        'type'              => 'Tipo',
        'weekdays'          => 'Dias da Semana',
    ],
    'hints'         => [
        'is_recurring'  => 'Um evento pode ser marcado como recorrente. Ele reaparecerá todo ano na mesma data.',
    ],
    'index'         => [
        'add'           => 'Novo Calendário',
        'description'   => 'Gerencie os calendários de :name.',
        'header'        => 'Calendários de :name',
        'title'         => 'Calendários',
    ],
    'panels'        => [
        'leap_year' => 'Ano Bissexto',
        'years'     => 'Anos Nomeados',
    ],
    'parameters'    => [
        'month' => [
            'length'    => 'Número de dias',
            'name'      => 'Nome do Mês',
        ],
        'year'  => [
            'name'      => 'Nome',
            'number'    => 'Ano',
        ],
    ],
    'placeholders'  => [
        'comment'           => 'Aniversário, Festival, Solstício',
        'date'              => 'Data Atual',
        'leap_year_amount'  => 'Número de dias adicionado no ano bissexto',
        'leap_year_month'   => 'Mês em que os dias são adicionados',
        'leap_year_offset'  => 'De quantos em quantos anos o ano é bissexto',
        'leap_year_start'   => 'Primeiro ano que é um ano bissexto',
        'length'            => 'Duração do evento em dias',
        'months'            => 'Número de meses em um ano',
        'name'              => 'Nome do calendário',
        'recurring_until'   => 'Ultimo ano recorrente (deixe desmarcado para ser recorrente sempre)',
        'seasons'           => 'Número de estações',
        'suffix'            => 'Sufixo atual da Era (AC, DC)',
        'type'              => 'Tipo do calendário',
        'weekdays'          => 'Número de dias na semana',
    ],
    'show'          => [
        'description'   => 'Uma visão detalhada de um calendário',
        'tabs'          => [
            'information'   => 'Informação',
        ],
        'title'         => 'Calendário :name',
    ],
];
