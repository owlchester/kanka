<?php

return [
    'actions'       => [
        'add'   => 'Adicionar um pseudônimo',
    ],
    'create'        => [
        'helper'    => 'Crie um alias para :name, que o tornará encontrável na pesquisa global e por meio de menções de :code.',
        'success'   => 'Pseudônimo :name adicionado a :entity.',
        'title'     => 'Adicionar um pseudônimo ao :name',
    ],
    'destroy'       => [
        'success'   => 'Pseudônimo :name removido.',
    ],
    'fields'        => [
        'name'  => 'Nome',
    ],
    'helpers'       => [
        'primary'   => 'Definir um ou vários pseudônimos para a entidade fará com que ela seja encontrada mais facilmente na busca global (barra superior) e através de menções.',
    ],
    'pitch'         => 'Crie pseudônimos para esta entidade para encontrá-la facilmente através da busca e por meio de menções.',
    'placeholders'  => [
        'name'  => 'Novo pseudônimo',
    ],
    'unboosted'     => [],
    'update'        => [
        'success'   => 'Pseudônimo :name atualizado para :entity.',
        'title'     => 'Atualizar pseudônimo para :name',
    ],
];
