<?php

return [
    'actions'   => [
        'status'    => 'Status :status',
    ],
    'public'    => [
        'campaign'      => [
            'private'   => 'A campanha está atualmente privada.',
            'public'    => 'A campanha está atualmente pública.',
        ],
        'description'   => 'Defina as permissões para o cargo público para visualizar as seguintes entidades da campanha. Um usuário está automaticamente no cargo público se estiver visualizando a campanha, mas não for um membro.',
        'test'          => 'Para testar as permissões do cargo público, abra a campanha :url em uma janela anônima.',
    ],
    'show'      => [
        'title' => ':role permissões - :campaign',
    ],
    'toggle'    => [
        'disabled'  => 'Membros do cargo :role não podem mais :action :entities',
        'enabled'   => 'Membros da cargo :role agora podem :action :entities',
    ],
];
