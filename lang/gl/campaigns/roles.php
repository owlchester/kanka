<?php

return [
    'actions'   => [
        'status'    => 'Estado: :status',
    ],
    'public'    => [
        'campaign'      => [
            'private'   => 'A campaña é actualmente privada.',
            'public'    => 'A campaña é actualmente pública.',
        ],
        'description'   => 'Establece os permisos do rol público para ver as seguintes entidades da campaña. Unha persoa é automaticamente parte do rol públic se está vendo a campaña pero sen ser integrante desta.',
        'test'          => 'Para probar os permisos do rol público, abre a campaña :url nunha ventá de incógnito.',
    ],
    'show'      => [
        'title' => 'Permisos do rol :role - :campaign',
    ],
    'toggle'    => [
        'disabled'  => 'As integrantes do rol :role xa non poden :action :entities',
        'enabled'   => 'As integrantes do rol :role agora poden :action :entities',
    ],
];
