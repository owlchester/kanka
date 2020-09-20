<?php

return [
    'abilities'     => [
        'title' => 'Habilidades infantis de :name',
    ],
    'create'        => [
        'success'   => 'Habilidade \':name\' criada.',
        'title'     => 'Nova Habilidade',
    ],
    'destroy'       => [
        'success'   => 'Capacidade \':name\' removida.',
    ],
    'edit'          => [
        'success'   => 'Habilidade \':name\' atualizada.',
        'title'     => 'Capacidade de edição :name',
    ],
    'fields'        => [
        'abilities' => 'Habilidades',
        'ability'   => 'Habilidade dos pais',
        'charges'   => 'Cobranças',
        'name'      => 'Nome',
        'type'      => 'Tipo',
    ],
    'helpers'       => [
        'descendants'   => 'Esta lista contém todas as habilidades que são descendentes dessa habilidade, e não apenas aquelas diretamente abaixo dela.',
        'nested'        => 'Quando em Visão Aninhada, você pode ver suas Habilidades de uma maneira aninhada. Habilidades sem habilidade dos pais serão mostradas por padrão. Habilidades com sub-habilidades podem ser clicadas para ver essas crianças. Você pode continuar clicando até que não haja mais filhos para ver.',
    ],
    'index'         => [
        'add'           => 'Nova Habilidade',
        'description'   => 'Crie poderes, feitiços, talentos e muito mais para suas entidades.',
        'header'        => 'Habilidades de :name',
        'title'         => 'Habilidades',
    ],
    'placeholders'  => [
        'charges'   => 'Quantidade de cobranças. Atributos de referência com {Level} * {CHA}',
        'name'      => 'Bola de fogo, alerta, ataque astuto',
        'type'      => 'Feitiço, Talento, Ataque',
    ],
    'show'          => [
        'tabs'  => [
            'abilities' => 'Habilidades',
        ],
        'title' => 'Habilidade :name',
    ],
];
