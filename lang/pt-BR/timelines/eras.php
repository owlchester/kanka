<?php

return [
    'actions'       => [
        'add'   => 'Add uma nova era',
    ],
    'bulks'         => [
        'delete'    => '{0} Removida :count era.|{1} Removida :count era.|[2,*] Removidas :count eras.',
    ],
    'create'        => [
        'success'   => 'Era :name criada.',
        'title'     => 'Nova Era',
    ],
    'delete'        => [
        'success'   => 'Era :name removida.',
    ],
    'edit'          => [
        'success'   => 'Era :name atualizada.',
        'title'     => 'Editar Era :name',
    ],
    'fields'        => [
        'abbreviation'  => 'Sigla',
        'end_year'      => 'Ano Final',
        'is_collapsed'  => 'Recolhido',
        'start_year'    => 'Ano Inicial',
    ],
    'helpers'       => [
        'eras'          => 'Uma linha do tempo precisa ser criada antes que eras possam ser adicionadas a ela.',
        'is_collapsed'  => 'Era é recolhida (minimizada) por padrão.',
        'primary'       => 'Separe sua linha do tempo em eras. Uma linha do tempo precisa de pelo menos uma era para funcionar corretamente.',
    ],
    'index'         => [
        'title' => 'Eras de :name',
    ],
    'placeholders'  => [
        'abbreviation'  => 'AC, DC, AEC',
        'end_year'      => 'Ano em que a era termina. Deixe em branco se esta for a era atual.',
        'name'          => 'Era Moderna, Idade do Bronze, Guerras Galácticas',
        'start_year'    => 'Ano em que a era começa. Deixe em branco se esta for a primeira era.',
    ],
    'reorder'       => [],
];
