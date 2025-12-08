<?php

return [
    'actions'   => [
        'status'    => 'Status :status',
    ],
    'create'    => [
        'helper'    => 'Crie um novo cargo para a campanha.',
    ],
    'overview'  => [
        'limited'   => ':amount de ::total cargos criados.',
        'title'     => 'Cargos disponíveis',
        'unlimited' => ':amount de cargos ilimitados criados.',
    ],
    'public'    => [],
    'show'      => [
        'title' => ':role permissões - :campaign',
    ],
    'toggle'    => [
        'disabled'  => 'Membros do cargo :role não podem mais :action :entities',
        'enabled'   => 'Membros da cargo :role agora podem :action :entities',
    ],
    'warnings'  => [
        'adding-to-admin'   => 'Os membros do cargo :name têm acesso a tudo na campanha e não podem ser removidos por outros membros do cargo . Após :amount minutos, somente eles próprios podem se retirar do cargo.',
    ],
];
