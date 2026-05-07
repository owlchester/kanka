<?php

return [
    'actions'       => [
        'add'   => 'Adicionar um pseudônimo',
    ],
    'create'        => [
        'helper'    => 'Crie um pseudônimo para :name, que o tornará encontrável na pesquisa global e por meio de menções de :code.',
        'success'   => 'Pseudônimo :name adicionado a :entity.',
        'title'     => 'Novo pseudônimo',
    ],
    'destroy'       => [
        'success'   => 'Pseudônimo :name removido.',
    ],
    'fields'        => [
        'name'  => 'Nome',
    ],
    'helpers'       => [
        'primary'   => 'Definir um ou mais pseudônimos na entidade fará com que ela seja encontrada na pesquisa global (barra superior) e por meio de menções :code.',
    ],
    'limit'         => 'Limite de aliases atingido para campanhas padrão (:amount/:max). :upgrade para aliases ilimitados nesta campanha.',
    'pitch'         => 'Adicione pseudônimos a esta entidade para facilitar a localização em pesquisas e menções. Ideal para apelidos, títulos ou grafias alternativas.',
    'placeholders'  => [
        'name'  => 'Novo pseudônimo',
    ],
    'unboosted'     => [],
    'update'        => [
        'success'   => 'Pseudônimo :name atualizado para :entity.',
        'title'     => 'Atualizar pseudônimo para :name',
    ],
];
