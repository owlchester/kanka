<?php

return [
    'actions'       => [
        'return'        => 'Voltar para todos os eventos',
        'send'          => 'Participar',
        'show_ongoing'  => 'Ver Evento & Participar',
        'show_past'     => 'Ver Evento & Vencedores',
        'update'        => 'Atualizar seu envio',
        'view'          => 'Ver inscrição',
    ],
    'description'   => 'Realizamos eventos de construção de mundo frequentes para nossa comunidade e nossas entradas favoritas são exibidas.',
    'fields'        => [
        'comment'       => 'Comentário',
        'entity_link'   => 'Link para a entidade',
        'honorable'     => 'Menção honrosa',
        'jury'          => 'Júri convidado :user',
        'rank'          => 'Classificação',
        'submitter'     => 'Remetente',
    ],
    'index'         => [
        'ongoing'   => 'Eventos que estão acontecendo',
        'past'      => 'Eventos passados',
    ],
    'participate'   => [
        'description'   => 'Sentiu-se inspirado por este evento? Crie uma entidade em uma de suas campanhas públicas e envie-nos o link da entidade no formulário abaixo. Você pode alterar ou excluir seu envio a qualquer momento.',
        'login'         => 'Faça login para participar no evento.',
        'participated'  => 'Você já enviou uma inscrição para este evento. Você pode editá-la ou removê-la.',
        'success'       => [
            'modified'  => 'As alterações em sua inscrição foram salvas.',
            'removed'   => 'Sua inscrição foi removida.',
            'submit'    => 'Enviado com sucesso. Você pode editar ou remover seu envio quando quiser.',
        ],
        'title'         => 'Participar do evento de construção de mundo',
    ],
    'placeholders'  => [
        'comment'       => 'Comentário sobre o seu envio (opcional)',
        'entity_link'   => 'Copie e cole o link para a entidade aqui',
    ],
    'results'       => [
        'description'       => 'Nosso júri selecionou os seguintes envios como vencedores do evento.',
        'scheduled'         => 'Esse evento começará em :start.',
        'title'             => 'Vencedores do Evento',
        'waiting_results'   => 'O evento acabou! O júri do evento analisará as inscrições e, assim que os vencedores forem selecionados, eles serão exibidos aqui.',
    ],
    'show'          => [
        'participants'  => '{1} :number de entradas enviadas. | [2, *] :number de entradas enviadas.',
        'title'         => 'Evento :name',
    ],
    'title'         => 'Eventos',
];
