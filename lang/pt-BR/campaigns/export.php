<?php

return [
    'actions'   => [
        'download'  => 'Download',
        'export'    => 'Exportar a campanha',
    ],
    'confirm'   => [
        'notification'  => 'Os membros do cargo :admin serão notificados quando a exportação estiver pronta para download.',
        'title'         => 'Exportar :name',
        'type'          => 'Tipo de Exportação',
        'warning'       => 'Você está prestes a exportar os dados da campanha. Este processo pode demorar muito dependendo do tamanho da campanha. Você pode continuar usando o Kanka enquanto nossos servidores geram a exportação.',
    ],
    'errors'    => [
        'limit'     => 'A campanha já foi exportada uma vez hoje. Por favor, tente novamente amanhã.',
        'premium'   => 'A exportação em Markdown é um recurso exclusivo de campanhas premium.',
    ],
    'expired'   => 'Link expirado',
    'helpers'   => [
        'json'      => 'Para backup e restauração – pode ser usado para importação de campanhas.',
        'markdown'  => 'Para compartilhar e ler – formato legível por humanos',
        'premium'   => 'Disponível apenas para campanhas premium.',
    ],
    'progress'  => 'Progresso',
    'size'      => 'Tamanho',
    'status'    => [
        'failed'    => 'Fracassado',
        'finished'  => 'Finalizado',
        'running'   => 'Executando',
        'scheduled' => 'Agendado',
    ],
    'success'   => 'A exportação da campanha está sendo preparada. Você será notificado em Kanka assim que estiver pronto para download.',
    'title'     => 'Exportação da Campanha',
    'type'      => 'Tipo',
    'types'     => [
        'json'  => 'JSON',
        'md'    => 'Markdown',
    ],
];
