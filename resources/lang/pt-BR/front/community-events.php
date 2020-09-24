<?php

return [
    'actions'       => [
        'return'        => 'Voltar para todos Eventos',
        'send'          => 'Participar',
        'show_ongoing'  => 'Ver Evento e participar',
        'show_past'     => 'Ver Evento e ganhadores',
        'update'        => 'Atualizar seu envio',
        'view'          => 'Ver envio',
    ],
    'description'   => 'Realizamos eventos de construção de mundo frequentes para nossa comunidade e nossas entradas favoritas são exibidas.',
    'fields'        => [
        'comment'       => 'Comentário',
        'entity_link'   => 'Link para a entidade',
        'rank'          => 'Classificação',
        'submitter'     => 'Participante',
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
            'modified'  => 'As alterações em seu envio foram salvas.',
            'removed'   => 'Seu envio foi removido.',
            'submit'    => 'Enviado com sucesso. Você pode editar ou remover seu envio quando quiser.',
        ],
        'title'         => 'Participar do evento',
    ],
    'placeholders'  => [
        'comment'       => 'Comentário sobre o seu envio (opcional)',
        'entity_link'   => 'Copie e cole o link para a entidade aqui',
    ],
    'results'       => [
        'description'       => 'Nosso júri selecionou os seguintes envios como vencedores do evento.',
        'title'             => 'Vencedores do evento',
        'waiting_results'   => 'O evento acabou! O júri do evento analisará as inscrições e, assim que os vencedores forem selecionados, eles serão exibidos aqui.',
    ],
    'show'          => [
        'participants'  => '{1} :number de entradas enviadas. | [2, *] :number de entradas enviadas.',
        'title'         => 'Evento :name',
    ],
    'title'         => 'Eventos',
];
