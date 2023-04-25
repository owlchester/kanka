<?php

return [
    'actions'       => [
        'return'        => 'Voltar para todos os eventos',
        'send'          => 'Participar',
        'show_ongoing'  => 'Visualizar Evento & Participar',
        'show_past'     => 'Visualizar Evento & Vencedores',
        'update'        => 'Atualizar sua inscrição',
        'view'          => 'Visualizar inscrição',
    ],
    'description'   => 'Realizamos eventos frequentes de construção de mundo para nossa comunidade e nossas candidaturas favoritas são exibidas.',
    'fields'        => [
        'comment'       => 'Comentário',
        'entity_link'   => 'Link para a entidade',
        'honorable'     => 'Menção honrosa',
        'jury'          => 'Júri convidado :user',
        'rank'          => 'Classificação',
        'submitter'     => 'Remetente',
    ],
    'index'         => [
        'ongoing'   => 'Eventos em andamento',
        'past'      => 'Eventos passados',
    ],
    'participate'   => [
        'description'   => 'Sentiu-se inspirado por este evento? Crie uma entidade em uma de suas campanhas públicas e envie-nos o link da entidade no formulário abaixo. Você pode alterar ou excluir sua inscrição a qualquer momento.',
        'login'         => 'Faça login em sua conta para participar no evento.',
        'participated'  => 'Você já enviou uma inscrição para este evento. Você pode editá-la ou removê-la.',
        'success'       => [
            'modified'  => 'As alterações em sua inscrição foram salvas.',
            'removed'   => 'Sua inscrição foi removida.',
            'submit'    => 'Sua inscrição foi enviada com sucesso. Você pode editar ou removê-la quando quiser.',
        ],
        'title'         => 'Participar do evento de construção de mundo',
    ],
    'placeholders'  => [
        'comment'       => 'Comentário sobre a sua inscrição (opcional)',
        'entity_link'   => 'Copie e cole o link para a entidade aqui',
    ],
    'results'       => [
        'description'       => 'Nosso júri selecionou as seguintes inscrições como vencedores do evento.',
        'scheduled'         => 'Esse evento começará em :start.',
        'title'             => 'Vencedores do Evento',
        'waiting_results'   => 'O evento acabou! O júri do evento analisará as inscrições e, assim que os vencedores forem selecionados, eles serão exibidos aqui.',
    ],
    'show'          => [
        'participants'  => '{1} :number candidatura enviada. | [2, *] :number candidaturas enviadas.',
        'title'         => 'Evento :name',
    ],
    'title'         => 'Eventos',
];
