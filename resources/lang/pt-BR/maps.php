<?php

return [
    'actions'       => [
        'back'      => 'Voltar para :name',
        'edit'      => 'Editar mapa',
        'explore'   => 'Explorar',
    ],
    'create'        => [
        'success'   => 'Mapa :name criado',
        'title'     => 'Novo mapa',
    ],
    'destroy'       => [
        'success'   => 'Mapa :name removido',
    ],
    'edit'          => [
        'success'   => 'Mapa :name atualizado com sucesso',
        'title'     => 'Editar mapa :name',
    ],
    'errors'        => [
        'dashboard' => [
            'missing'   => 'Este mapa precisa de uma imagem para poder aparecer no dashboard',
        ],
        'explore'   => [
            'missing'   => 'Por favor, adicione uma imagem ao mapa para poder explorá-lo',
        ],
    ],
    'fields'        => [
        'center_x'          => 'Posição de longitude padrão',
        'center_y'          => 'Posição de latitude padrão',
        'distance_measure'  => 'Medida de distância',
        'distance_name'     => 'Unidade de distância',
        'grid'              => 'Grid',
        'initial_zoom'      => 'Zoom inicial',
        'map'               => 'Mapa primário',
        'maps'              => 'Mapas',
        'max_zoom'          => 'Zoom máximo',
        'min_zoom'          => 'Zoom mínimo',
        'name'              => 'Nome',
        'type'              => 'Tipo',
    ],
    'helpers'       => [
        'center'            => 'Alterar os valores a seguir controlará em qual área do mapa está o foco. Deixar esses valores vazios resultará no centro do mapa ser considerado o foco.',
        'descendants'       => 'Esta lista contém todos os mapas que são relacionados a este mapa, e não apenas aqueles diretamente relacionados a ele.',
        'distance_measure'  => 'Dar ao mapa uma medida de distância habilitará a ferramenta de medição no modo de exploração.',
        'grid'              => 'Defina o tamanho do grid que será mostrado no modo exploração.',
        'initial_zoom'      => 'O nível de zoom inicial com o qual um mapa é carregado. O valor padrão é :default, enquanto o maior valor permitido é :max e o menor valor permitido é :min.',
        'max_zoom'          => 'O máximo que um mapa pode ser ampliado. O valor padrão é :default, enquanto o maior valor permitido é :max.',
        'min_zoom'          => 'O máximo que um mapa pode ser diminuído. O valor padrão é :default, enquanto o menor valor permitido é :max.',
        'missing_image'     => 'Você precisa salvar o mapa com uma imagem antes de poder adicionar camadas e marcadores.',
        'nested'            => 'Quando na visualização aninhada, você pode visualizar seus mapas de uma maneira aninhada. Mapas sem mapas primários serão mostrados por padrão. Mapas comrelacionados podem ser clicados para ver esses mapas secundários. Você pode continuar clicando até que não haja mais mapas secundários para ver.',
    ],
    'index'         => [
        'add'   => 'Novo mapa',
        'title' => 'Mapas',
    ],
    'maps'          => [
        'title' => 'Mapas de :name',
    ],
    'panels'        => [
        'groups'    => 'Grupos',
        'layers'    => 'Camadas',
        'markers'   => 'Marcadores',
        'settings'  => 'Configurações',
    ],
    'placeholders'  => [
        'center_x'          => 'Deixe vazio para carregar o mapa centralizado.',
        'center_y'          => 'Deixe vazio para carregar o mapa centralizado.',
        'distance_measure'  => 'Unidades por pixel',
        'distance_name'     => 'Nome da distância (kilômetro, milha)',
        'grid'              => 'Distância em pixels entre os elementos da grid. Deixe vazio para esconder a grid.',
        'name'              => 'Nome do mapa',
        'type'              => 'Masmorra, Cidade, Galáxia',
    ],
    'show'          => [
        'tabs'  => [
            'maps'  => 'Mapas',
        ],
        'title' => 'Mapa :name',
    ],
];
