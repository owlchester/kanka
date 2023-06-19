<?php

return [
    'actions'   => [
        'customise' => 'Personalizar',
    ],
    'fields'    => [
        'icon'      => 'Ícone do módulo',
        'plural'    => 'Nome plural do módulo',
        'singular'  => 'Nome singular do módulo',
    ],
    'helpers'   => [
        'info'  => 'Uma campanha é dividida em vários módulos que interagem entre si. Habilite ou desabilite aqueles que você não precisa. A desativação de um módulo não exclui nenhum de seus dados, apenas os oculta.',
    ],
    'pitch'     => 'Renomeie e altere o ícone associado a este módulo para toda a campanha.',
    'rename'    => [
        'helper'    => 'Altere o nome e o ícone do módulo ao longo da campanha. Deixe em branco para usar o padrão de Kanka.',
        'success'   => 'Módulo personalizado.',
        'title'     => 'Personalizar o módulo :module',
    ],
    'reset'     => [
        'success'   => 'Os módulos da campanha foram redefinidos.',
        'title'     => 'Redefinir nomes e ícones dos módulos personalizados',
        'warning'   => 'Tem certeza de que deseja redefinir os módulos de campanha para seus nomes e ícones originais?',
    ],
    'states'    => [
        'disable'   => 'Desabilitar',
        'enable'    => 'Habilitar',
    ],
];
