<?php

return [
    'actions'   => [
        'status'    => 'Status :status',
    ],
    'public'    => [
        'campaign'      => [
            'private'   => 'A campanha é atualmente privada.',
            'public'    => 'A campanha é atualmente pública.',
        ],
        'description'   => 'Defina as permissões para a função pública para visualizar as seguintes entidades da campanha. Um usuário está automaticamente na função pública se estiver visualizando a campanha, mas não for um membro.',
        'test'          => 'Para testar as permissões da função pública, abra a campanha :url em uma janela anônima.',
    ],
    'show'      => [
        'title' => ':role permissões - :campaign',
    ],
    'toggle'    => [
        'disabled'  => 'Membros da função :role não podem mais :action :entities',
        'enabled'   => 'Membros da função :role agora podem :action :entities',
    ],
];
