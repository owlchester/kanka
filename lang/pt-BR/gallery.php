<?php

return [
    'actions'   => [
        'gallery'   => 'Da galeria',
        'url'       => 'Carregar uma imagem de uma URL',
    ],
    'browse'    => [
        'layouts'       => [
            'large' => 'Pré-visualizações grandes',
            'small' => 'Pré-visualizações pequenas',
        ],
        'search'        => [
            'placeholder'   => 'Procurar uma imagem na galeria',
        ],
        'title'         => 'Galeria',
        'unauthorized'  => 'Nenhum de seus cargos tem a permissão "navegar pela galeria".',
    ],
    'delete'    => [
        'success'   => '[0] Excluído 0 elementos|[1] Excluído um elemento|{2,*} Excluídos :count elementos',
    ],
    'download'  => [
        'errors'    => [
            'copy_failed'           => 'Nossos servidores não conseguiram baixar a imagem fornecida.',
            'gallery_full_free'     => 'O espaço de armazenamento da galeria está cheio. Habilite recursos premium para mais armazenamento.',
            'gallery_full_premium'  => 'O espaço de armazenamento da galeria está cheio. Remova os arquivos não utilizados primeiro.',
            'invalid_format'        => 'O arquivo não está num formato válido.',
            'too_big'               => 'O arquivo é muito grande.',
            'unauthorized'          => 'Nenhum dos seus cargos tem a permissão "carregar para a galeria".',
        ],
    ],
    'file'      => [
        'saved' => 'Salvo',
    ],
    'filters'   => [
        'only_unused'   => 'Somente mostrar arquivos não salvos',
    ],
    'move'      => [
        'success'   => '[0] Movido 0 elementos|[1] Movido um elemento|{2,*} Movidos :count elementos',
    ],
    'update'    => [
        'home'      => 'Pasta inicial',
        'success'   => '[0] Atualizado 0 elementos|[1] Atualizado um elemento|{2,*} Atualizados :count elementos',
    ],
];
