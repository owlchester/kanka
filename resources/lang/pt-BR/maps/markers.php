<?php

return [
    'actions'       => [
        'entry'             => 'Escrever um campo de entrada personalizado para esse marcador.',
        'remove'            => 'Remover marcador',
        'save_and_explore'  => 'Salvar e Explorar',
        'update'            => 'Editar marcadoe',
    ],
    'create'        => [
        'success'   => 'Marcador :name criado',
        'title'     => 'Novo marcador',
    ],
    'delete'        => [
        'success'   => 'Marcador :name deletado.',
    ],
    'edit'          => [
        'success'   => 'Marcador :name atualizado.',
        'title'     => 'Editar marcador :name',
    ],
    'fields'        => [
        'circle_radius' => 'Raio do círculo',
        'copy_elements' => 'Copiar elementos',
        'custom_icon'   => 'Ícone personalizado',
        'custom_shape'  => 'Forma personalizada',
        'font_colour'   => 'Cor do ícone',
        'group'         => 'Grupo de marcadores',
        'is_draggable'  => 'Arrastável',
        'latitude'      => 'Latitude',
        'longitude'     => 'Longitude',
        'opacity'       => 'Opacidade',
        'pin_size'      => 'Tamanho do pino',
        'polygon_style' => [
            'stroke'            => 'Cor do traço',
            'stroke-opacity'    => 'Opacidade do traço',
            'stroke-width'      => 'Largura do traço',
        ],
    ],
    'helpers'       => [
        'base'                      => 'Adicione marcadores no mapa clicando em qulquer lugar',
        'copy_elements'             => 'Copiar grupos, camadas e marcadores.',
        'copy_elements_to_campaign' => 'Copie grupos, camadas e marcadores dos mapas. Os marcadores vinculados a uma entidade serão convertidos em um marcador padrão.',
        'custom_icon'               => 'Copie o HTML de um ícone de :fontawesome ou :rpgawesome , ou um ícone SVG personalizado',
        'custom_radius'             => 'Selecione a opção de tamanho personalizado no menu suspenso para definir um tamanho.',
        'draggable'                 => 'Ative para permitir mover um marcador no modo de exploração.',
        'label'                     => 'Um rótulo é exibido como um bloco de texto no mapa. O conteúdo será o nome do marcador do nome da entidade.',
        'polygon'                   => [
            'edit'  => 'Clique no mapa para adicionar essa posição às coordenadas do polígono.',
            'new'   => 'Mova o marcador no mapa para salvar a posição no polígono.',
        ],
    ],
    'icons'         => [
        'custom'        => 'Personalizado',
        'entity'        => 'Entidade',
        'exclamation'   => 'Exclamação',
        'marker'        => 'Marcador',
        'question'      => 'Questão',
    ],
    'placeholders'  => [
        'custom_shape'  => '100,100 200,240 340,110',
        'name'          => 'Necessário se nenhuma entidade estiver selecionada',
    ],
    'shapes'        => [
        '0' => 'Círculo',
        '1' => 'Quadrado',
        '2' => 'Triângulo',
        '3' => 'Personalizado',
    ],
    'sizes'         => [
        '0' => 'Minúsculo',
        '1' => 'Padrão',
        '2' => 'Pequeno',
        '3' => 'Grande',
        '4' => 'Enorme',
    ],
    'tabs'          => [
        'circle'    => 'Círculo',
        'label'     => 'Letreiro',
        'marker'    => 'Marcador',
        'polygon'   => 'Polígono',
    ],
];
