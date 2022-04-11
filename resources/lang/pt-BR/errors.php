<?php

return [
    '403'       => [
        'body'  => 'Parece que você não tem permissão para acessar esta páginaQ',
        'title' => 'Acesso negado',
    ],
    '403-form'  => [
        'help'  => 'Isso pode ser devido  sua sessão ter atingido o tempo limite. Tente fazer login novamente em outra janela antes de salvar.',
    ],
    '404'       => [
        'body'  => 'Desculpe, a página que você está procurando não pode ser encotrada',
        'title' => 'Página não encontrada',
    ],
    '500'       => [
        'body'  => [
            '1' => 'Eita, parece que algo deu errado!',
            '2' => 'Um relatório com o erro encontrado foi enviado para nós, mas às vezes ajuda se pudermos saber um pouco mais sobre o que você estava fazendo.',
        ],
        'title' => 'Erro',
    ],
    '503'       => [
        'body'  => [
            '1' => 'Kanka está em manutenção, o que geralmente significa que uma nova versão está a caminho!',
            '2' => 'Desculpe pela inconveniência. Tudo voltará ao normal em apenas alguns minutos.',
        ],
        'title' => 'Em manutenção',
    ],
    '503-form'  => [],
    'footer'    => 'Se precisar de mais ajuda, entre em contato conosco em hello@kanka.io ou no :discord',
];
