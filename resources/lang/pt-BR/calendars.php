<?php

return [
    'actions'       => [
        'add_epoch'         => 'Adicione uma época',
        'add_intercalary'   => 'Adicionar dias intercalares',
        'add_month'         => 'Adicionar um mês',
        'add_moon'          => 'Adicionar uma lua',
        'add_reminder'      => 'Adicionar um lembrete',
        'add_season'        => 'Adicione uma temporada',
        'add_weather'       => 'Configurar um efeito de clima',
        'add_week'          => 'Adicionar uma semana nomeada',
        'add_weekday'       => 'Adicionar um dia da semana',
        'add_year'          => 'Adicionar um nome para o ano',
        'set_today'         => 'Definir como dia atual',
        'today'             => 'Hoje',
    ],
    'checkboxes'    => [
        'is_recurring'  => 'Acontece todos os anos',
    ],
    'create'        => [
        'success'   => 'Calendário \':name\' criado.',
        'title'     => 'Novo Calendário',
    ],
    'destroy'       => [
        'success'   => 'Calendário \':name\' removido',
    ],
    'edit'          => [
        'success'   => 'Calendário \':name\' atualizado.',
        'title'     => 'Editar Calendário :name',
        'today'     => 'Data do calendário atualizada.',
    ],
    'event'         => [
        'actions'   => [
            'delete-confirm'    => 'esse lembrete',
            'existing'          => 'Entidade Existente',
            'new'               => 'Novo evento',
            'switch'            => 'Escolha de mudança',
        ],
        'create'    => [
            'success'   => 'Evento de calendário criado.',
            'title'     => 'Adicionar um evento de calendário para :name',
        ],
        'destroy'   => 'Evento removido do calendário \':name\'',
        'edit'      => [
            'success'   => 'Atualização de evento de calendário.',
            'title'     => 'Atualizar evento do calendário para :name',
        ],
        'helpers'   => [
            'add'               => 'Adicione um evento existente para esse calendário usando a lista.',
            'new'               => 'Ou você pode criar um novo evento simplesmente fornecendo um nome.',
            'other_calendar'    => 'Você está editando um lembrete que está no :calender calendário',
        ],
        'modal'     => [
            'title' => 'Adicione um evento ao calendário',
        ],
        'success'   => 'Evento \':event\' adicionado ao calendário.',
    ],
    'events'        => [
        'title' => 'Calendário :name Eventos',
    ],
    'fields'        => [
        'calendar'              => 'Calendário Principal',
        'calendars'             => 'Calendários',
        'colour'                => 'Cor',
        'comment'               => 'Comentar',
        'current_day'           => 'Dia Atual',
        'current_month'         => 'Mês Atual',
        'current_year'          => 'Ano Atual',
        'date'                  => 'Data Atual',
        'has_leap_year'         => 'Tem anos bissextos',
        'intercalary'           => 'Dias intercalares',
        'is_incrementing'       => 'Data de Avanço',
        'is_recurring'          => 'Recorrente',
        'leap_year_amount'      => 'Adicionar Dias',
        'leap_year_month'       => 'Mês',
        'leap_year_offset'      => 'Cada',
        'leap_year_start'       => 'Ano Bissexto',
        'length'                => 'Duração do Evento',
        'length_days'           => ':count day|: contar dias',
        'months'                => 'Meses',
        'moons'                 => 'Luas',
        'name'                  => 'Nome',
        'parameters'            => 'Parâmetros',
        'recurring_periodicity' => 'Periodicidade Recorrente',
        'recurring_until'       => 'Recorrente até o ano',
        'reset'                 => 'Reinicialização semanal',
        'seasons'               => 'Estações',
        'start_offset'          => 'Iniciar deslocamento',
        'suffix'                => 'Sufixo',
        'type'                  => 'Tipo',
        'week_names'            => 'Nomes da semana',
        'weekdays'              => 'Dias da Semana',
    ],
    'helpers'       => [
        'month_type'    => 'Os meses intercalares não usam os dias da semana, mas ainda influenciam as luas e as estações.',
        'nested_parent' => 'Mostrando os calendários de :parent.',
        'nested_without'=> 'Mostrando todos os calendários que não tem um calendário-pai. Clique em uma linha para ver os calendários-filhos.',
        'start_offset'  => 'Por padrão, o calendário começa no primeiro dia da semana do ano 0. A alteração deste campo influencia onde o primeiro dia do calendário é colocado.',
    ],
    'hints'         => [
        'event_length'      => 'Quanto tempo um evento deve durar. Um evento não pode durar mais de dois meses.',
        'intercalary'       => 'Dias que estão fora dos meses e semanas padrão. Eles não influenciam os dias da semana, mas influenciam os ciclos lunares.',
        'is_incrementing'   => 'Avançar calendários terá automaticamente seu incremento de data atual às 00:00 UTC.',
        'is_recurring'      => 'Um evento pode ser marcado como recorrente. Ele reaparecerá todo ano na mesma data.',
        'months'            => 'Seu calendário deve ter pelo menos 2 meses.',
        'moons'             => 'Adicionar luas fará com que elas apareçam no calendário em cada lua cheia e nova. Se o período da lua cheia for maior que 10 dias, as luas minguantes e crescentes também serão exibidas.',
        'parent_calendar'   => 'Relacionar o calendário a um calendário principal incluirá os lembretes e os efeitos do clima do calendário principal.',
        'reset'             => 'Sempre comece no início do mês ou ano no primeiro dia da semana.',
        'seasons'           => 'Crie estações para o seu calendário, informando quando cada uma delas começa. Kanka cuidará do resto.',
        'weekdays'          => 'Defina os nomes dos dias da semana. São necessários pelo menos 2 dias de semana.',
        'weeks'             => 'Defina alguns nomes para as semanas mais importantes do seu calendário.',
        'years'             => 'Alguns anos são tão importantes que têm um nome próprio.',
    ],
    'index'         => [
        'add'       => 'Novo Calendário',
        'header'    => 'Calendários de :name',
        'title'     => 'Calendários',
    ],
    'layouts'       => [
        'month' => 'Mês',
        'year'  => 'Ano',
    ],
    'modals'        => [
        'switcher'  => [
            'title' => 'Mudança de ano',
        ],
    ],
    'month_types'   => [
        'intercalary'   => 'Intercalar',
        'standard'      => 'Padrão',
    ],
    'options'       => [
        'events'    => [
            'recurring_periodicity' => [
                'fullmoon'      => 'Lua cheia',
                'fullmoon_name' => ':moon lua cheia',
                'month'         => 'Por mês',
                'newmoon'       => 'Lua nova',
                'newmoon_name'  => ':moon lua nova',
                'none'          => 'Nenhum',
                'unnamed_moon'  => 'Lua :number',
                'year'          => 'Anual',
            ],
        ],
        'resets'    => [
            ''      => 'Nenhum',
            'month' => 'Por mês',
            'year'  => 'Anual',
        ],
    ],
    'panels'        => [
        'intercalary'   => 'Dias intercalares',
        'leap_year'     => 'Ano Bissexto',
        'months'        => 'Meses',
        'weeks'         => 'Semanas',
        'years'         => 'Anos Nomeados',
    ],
    'parameters'    => [
        'intercalary'   => [
            'length'    => 'Duração em dias',
            'month'     => 'No final de que mês',
            'name'      => 'Nome da intercalação',
        ],
        'month'         => [
            'alias' => 'Alias ​​do mês',
            'length'=> 'Número de dias',
            'name'  => 'Nome do Mês',
            'type'  => 'Tipo',
        ],
        'moon'          => [
            'fullmoon'  => 'Lua cheia a cada (dias)',
            'name'      => 'Nome da lua',
            'offset'    => 'Primeiro deslocamento de lua cheia',
        ],
        'seasons'       => [
            'day'   => 'Começo do dia',
            'month' => 'Início do mês',
            'name'  => 'Nome da Temporada',
        ],
        'weeks'         => [
            'name'      => 'Nome da semana',
            'number'    => 'Número',
        ],
        'year'          => [
            'name'      => 'Nome',
            'number'    => 'Ano',
        ],
    ],
    'placeholders'  => [
        'colour'            => 'Cor',
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
        'missing_details'   => 'Este calendário não pôde ser exibido. Os calendários precisam de pelo menos 2 meses e 2 dias da semana para serem renderizados corretamente.',
        'moon_full_moon'    => ':moon Lua cheia',
        'moon_new_moon'     => ':moon Lua Nova',
        'moon_waning_moon'  => ':moon Minguante',
        'moon_waxing_moon'  => ':moon crescente',
        'tabs'              => [
            'events'        => 'Eventos de calendário',
            'information'   => 'Informação',
            'weather'       => 'Clima',
        ],
        'title'             => 'Calendário :name',
    ],
    'sorters'       => [
        'after' => 'Hoje e depois',
        'before'=> 'Hoje e antes',
    ],
];
