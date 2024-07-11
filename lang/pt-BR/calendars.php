<?php

return [
    'actions'       => [
        'add_epoch'         => 'Adicionar uma época',
        'add_intercalary'   => 'Adicionar dias intercalares',
        'add_month'         => 'Adicionar um mês',
        'add_moon'          => 'Adicionar uma lua',
        'add_reminder'      => 'Adicionar um lembrete',
        'add_season'        => 'Adicionar uma estação',
        'add_weather'       => 'Definir efeitos do clima',
        'add_week'          => 'Adicionar uma semana nomeada',
        'add_weekday'       => 'Adicionar um dia da semana',
        'add_year'          => 'Adicionar um ano nomeado',
        'set_today'         => 'Definir como dia atual',
        'today'             => 'Hoje',
        'update_weather'    => 'Atualizar o clima',
    ],
    'checkboxes'    => [
        'is_recurring'  => 'Ocorre todos os anos',
    ],
    'create'        => [
        'title' => 'Novo Calendário',
    ],
    'destroy'       => [],
    'edit'          => [
        'today' => 'Data do calendário atualizada.',
    ],
    'event'         => [
        'actions'   => [
            'existing'  => 'Entidade Existente',
            'new'       => 'Novo Evento',
            'switch'    => 'Mudar de escolha',
        ],
        'create'    => [
            'success'   => 'Evento de calendário criado.',
            'title'     => 'Adicionar um Evento de Calendário para :name',
        ],
        'destroy'   => 'Lembrete removido do calendário \':name\'',
        'edit'      => [
            'success'   => 'Lembrete atualizado.',
            'title'     => 'Atualizar Lembrete para :name',
        ],
        'errors'    => [
            'invalid_entity'    => 'Seleção de entidade inválida.',
        ],
        'helpers'   => [
            'add'               => 'Adicionar um evento existente para esse calendário.',
            'new'               => 'Ou crie um novo evento simplesmente fornecendo um nome.',
            'other_calendar'    => 'Você está editando um lembrete que está no calendário :calendar.',
        ],
        'modal'     => [
            'title' => 'Adicionar um evento ao calendário',
        ],
        'success'   => 'Lembrete \':event\' adicionado ao calendário.',
    ],
    'events'        => [
        'bulks'     => [
            'delete'    => '{1} :count lembrete removido.|[2,*] :count lembretes removidos.',
            'patch'     => '{1} :count lembrete atualizado.|[2,*] :count lembretes atualizados.',
        ],
        'end'       => '(fim)',
        'filters'   => [
            'show_after'    => 'Mostrar hoje e depois',
            'show_all'      => 'Mostrar tudo',
            'show_before'   => 'Mostrar antes de hoje',
        ],
        'start'     => '(começo)',
    ],
    'fields'        => [
        'colour'                => 'Cor',
        'comment'               => 'Comentário',
        'current_day'           => 'Dia Atual',
        'current_month'         => 'Mês Atual',
        'current_year'          => 'Ano Atual',
        'date'                  => 'Data Atual',
        'day'                   => 'Dia',
        'default_layout'        => 'Layout padrão',
        'format'                => 'Formato',
        'intercalary'           => 'Dias Intercalares',
        'is_incrementing'       => 'Avançando data',
        'is_recurring'          => 'Recorrente',
        'leap_year'             => 'Anos bissextos',
        'leap_year_amount'      => 'Adicionar Dias',
        'leap_year_month'       => 'Mês',
        'leap_year_offset'      => 'Cada',
        'leap_year_start'       => 'Ano Bissexto',
        'length'                => 'Duração do Evento',
        'length_days'           => ':count day|: contar dias',
        'month'                 => 'Mês',
        'months'                => 'Meses',
        'moons'                 => 'Luas',
        'parameters'            => 'Parâmetros',
        'recurring_periodicity' => 'Periodicidade Recorrente',
        'recurring_until'       => 'Recorrente Até o Ano',
        'reset'                 => 'Reinicialização Semanal',
        'seasons'               => 'Estações',
        'show_birthdays'        => 'Mostrar Aniversários',
        'skip_year_zero'        => 'Ignorar o Ano Zero',
        'start_offset'          => 'Deslocamento Inicial',
        'suffix'                => 'Sufixo',
        'week_names'            => 'Nomes da Semana',
        'weekdays'              => 'Dias da Semana',
        'year'                  => 'Ano',
    ],
    'helpers'       => [
        'default_layout'    => 'Selecione qual layout o calendário deve usar por padrão quando visualizado.',
        'format'            => 'Adicione formatação de data personalizada para entidades do calendário.',
        'month_type'        => 'Os meses intercalares não usam os dias da semana, mas ainda influenciam as luas e as estações.',
        'moon_offset'       => 'Por padrão, a primeira lua cheia aparece no primeiro dia do ano 0. A alteração do deslocamento mudará quando a primeira lua cheia for exibida. Este valor pode ser negativo (até a duração do primeiro mês) ou positivo (até a duração do primeiro mês).',
        'start_offset'      => 'Por padrão, o calendário começa no primeiro dia da semana do ano 0. A alteração deste campo influencia onde o primeiro dia do calendário é colocado.',
    ],
    'hints'         => [
        'event_length'      => 'Quanto tempo um evento deve durar. Um evento não pode durar mais de dois meses.',
        'intercalary'       => 'Dias que estão fora dos meses e semanas padrão. Eles não influenciam os dias da semana, mas influenciam os ciclos lunares.',
        'is_incrementing'   => 'O avanço de calendário automaticamente terá seu incremento da data atual às 00:00 UTC.',
        'is_recurring'      => 'Um evento pode ser marcado como recorrente. Ele reaparecerá todo ano na mesma data.',
        'leap_year'         => 'Configure anos bissextos para o calendário.',
        'months'            => 'Seu calendário deve ter pelo menos 2 meses.',
        'moons'             => 'Adicionar luas fará com que elas apareçam no calendário em cada lua cheia e nova. Se o período da lua cheia for maior que 10 dias, as luas minguantes e crescentes também serão exibidas.',
        'parent_calendar'   => 'Relacionar o calendário a um calendário primário incluirá os lembretes e os efeitos do clima do calendário primário.',
        'reset'             => 'Sempre comece no início do mês ou ano no primeiro dia da semana.',
        'seasons'           => 'Crie estações para o seu calendário, informando quando cada uma delas começa. Kanka cuidará do resto.',
        'show_birthdays'    => 'Mostre os aniversários anuais dos personagens que têm um lembrete de aniversário neste calendário até a data de sua morte.',
        'skip_year_zero'    => 'Por padrão, o primeiro ano do calendário é o ano zero. Habilite esta opção para pular o ano zero.',
        'weekdays'          => 'Defina os nomes dos dias da semana. São necessários pelo menos 2 dias de semana.',
        'weeks'             => 'Defina alguns nomes para as semanas mais importantes do seu calendário.',
        'years'             => 'Alguns anos são tão importantes que têm um nome próprio.',
    ],
    'index'         => [],
    'layouts'       => [
        'month'     => 'Mês',
        'monthly'   => 'Mensal por padrão',
        'year'      => 'Ano',
        'yearly'    => 'Anual por padrão',
    ],
    'modals'        => [
        'switcher'  => [
            'title' => 'Seletor de Ano',
        ],
    ],
    'month_types'   => [
        'intercalary'   => 'Intercalado',
        'standard'      => 'Padrão',
    ],
    'options'       => [
        'events'    => [
            'recurring_periodicity' => [
                'fullmoon'      => 'Lua cheia',
                'fullmoon_name' => ':moon lua cheia',
                'month'         => 'Mensal',
                'newmoon'       => 'Lua nova',
                'newmoon_name'  => ':moon lua nova',
                'none'          => 'Nenhum',
                'unnamed_moon'  => 'Lua :number',
                'year'          => 'Anual',
            ],
        ],
        'resets'    => [
            ''      => 'Nenhum',
            'month' => 'Mensal',
            'year'  => 'Anual',
        ],
    ],
    'panels'        => [
        'intercalary'   => 'Dias Intercalares',
        'leap_year'     => 'Ano Bissexto',
        'months'        => 'Meses',
        'weeks'         => 'Semanas',
        'years'         => 'Anos Nomeados',
    ],
    'parameters'    => [
        'intercalary'   => [
            'length'    => 'Duração em dias',
            'month'     => 'No final de qual mês',
            'name'      => 'Nome da intercalação',
        ],
        'month'         => [
            'alias' => 'Apelido ​​do Mês',
            'length'=> 'Dias',
            'name'  => 'Nome do Mês',
            'type'  => 'Tipo',
        ],
        'moon'          => [
            'fullmoon'  => 'Lua cheia a cada (dias)',
            'name'      => 'Nome da Lua',
            'offset'    => 'Primeiro deslocamento da lua cheia',
        ],
        'seasons'       => [
            'day'   => 'Início do dia',
            'month' => 'Início do mês',
            'name'  => 'Nome da Estação',
        ],
        'weeks'         => [
            'name'      => 'Nome da Semana',
            'number'    => 'Número',
        ],
        'year'          => [
            'name'      => 'Nome do Ano',
            'number'    => 'Ano',
        ],
    ],
    'placeholders'  => [
        'colour'            => 'Cor',
        'comment'           => 'Aniversário, festival, solstício',
        'date'              => 'A data atual',
        'leap_year_amount'  => 'Número de dias adicionado em um ano bissexto',
        'leap_year_month'   => 'Mês em que os dias são adicionados',
        'leap_year_offset'  => 'A cada quantos anos é um ano bissexto',
        'leap_year_start'   => 'Primeiro ano que é um ano bissexto',
        'length'            => 'Duração do evento em dias',
        'months'            => 'Número de meses em um ano',
        'recurring_until'   => 'Ultimo ano recorrente (deixe vazio para ser recorrente sempre)',
        'seasons'           => 'Número de estações',
        'suffix'            => 'Sufixo atual da Era (AC, DC)',
        'type'              => 'Tipo do calendário',
        'weekdays'          => 'Número de dias em uma semana',
    ],
    'show'          => [
        'missing_details'       => 'Este calendário não pôde ser exibido. Os calendários precisam de pelo menos 2 meses e 2 dias da semana para serem renderizados corretamente.',
        'moon_1first_quarter'   => 'Lua minguante de :moon',
        'moon_full'             => 'Lua cheia de :moon',
        'moon_last_quarter'     => 'Lua crescente de :moon',
        'moon_new'              => 'Lua nova de :moon',
        'tabs'                  => [
            'events'    => 'Lembretes',
            'weather'   => 'Clima',
        ],
    ],
    'sorters'       => [
        'after' => 'Hoje & depois',
        'before'=> 'Hoje & antes',
    ],
    'validators'    => [
        'format'        => 'O formato da data é inválido.',
        'moon_offset'   => 'O deslocamento da primeira lua cheia não pode ser maior que a duração do primeiro mês do calendário.',
    ],
    'warnings'      => [
        'event_length'  => 'Os lembretes que abrangem vários anos só são visíveis nos primeiros dois anos. Saiba mais em nossa :documentation.',
    ],
];
