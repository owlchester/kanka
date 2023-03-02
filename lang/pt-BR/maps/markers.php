<?php

return [
    'actions'       => [
        'entry'             => 'Escrever um campo de entrada personalizado para esse marcador.',
        'remove'            => 'Remover marcador',
        'reset-polygon'     => 'Redefinir posições',
        'save_and_explore'  => 'Salvar e Explorar',
        'start-drawing'     => 'Começar a desenhar',
        'update'            => 'Editar marcadoe',
    ],
    'bulks'         => [
        'delete'    => '{1} Removido :count marcador.|[2,*] Removidos :count marcadores.',
        'patch'     => '{1} Atualizado :count marcador.|[2,*] Atualizados :count marcadores.',
    ],
    'circle_sizes'  => [
        'custom'    => 'Personalizado',
        'huge'      => 'Enorme',
        'large'     => 'Grande',
        'small'     => 'Pequeno',
        'standard'  => 'Padrão',
        'tiny'      => 'Minúsculo',
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
        'bg_colour'     => 'Cor de fundo',
        'circle_radius' => 'Raio do círculo',
        'copy_elements' => 'Copiar elementos',
        'custom_icon'   => 'Ícone personalizado',
        'custom_shape'  => 'Forma personalizada',
        'font_colour'   => 'Cor do ícone',
        'group'         => 'Grupo de marcadores',
        'icon'          => 'Ícone',
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
        'size'          => 'Tamanho',
    ],
    'helpers'       => [
        'base'                      => 'Adicione marcadores no mapa clicando em qulquer lugar',
        'copy_elements'             => 'Copiar grupos, camadas e marcadores.',
        'copy_elements_to_campaign' => 'Copie grupos, camadas e marcadores dos mapas. Os marcadores vinculados a uma entidade serão convertidos em um marcador padrão.',
        'custom_icon_v2'            => 'Use ícones de :fontawesome, :rpgawesome ou um ícone SVG personalizado. Descubra como em :docs.',
        'custom_radius'             => 'Selecione a opção de tamanho personalizado no menu suspenso para definir um tamanho.',
        'draggable'                 => 'Ative para permitir mover um marcador no modo de exploração.',
        'label'                     => 'Um rótulo é exibido como um bloco de texto no mapa. O conteúdo será o nome do marcador do nome da entidade.',
        'polygon'                   => [
            'edit'  => 'Clique no mapa para adicionar essa posição às coordenadas do polígono.',
        ],
    ],
    'icons'         => [
        'custom'        => 'Personalizado',
        'entity'        => 'Entidade',
        'exclamation'   => 'Exclamação',
        'marker'        => 'Marcador',
        'question'      => 'Questão',
    ],
    'index'         => [
        'title' => 'Marcadores de :name',
    ],
    'pitches'       => [
        'poly'  => 'Desenhe formas poligonais personalizadas para representar bordas e outras formas irregulares.',
    ],
    'placeholders'  => [
        'custom_icon'   => 'Tente :example1 ou :example2',
        'custom_shape'  => '100,100 200,240 340,110',
        'name'          => 'Necessário se nenhuma entidade estiver selecionada',
    ],
    'presets'       => [
        'helper'    => 'Clique sobre uma predefinição para carregá-la ou crie uma nova.',
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
        'preset'    => 'Predefinições',
    ],
];
