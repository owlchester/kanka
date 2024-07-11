<?php

return [
    'actions'       => [
        'import'    => 'Carregar a exportação',
    ],
    'description'   => 'Importe as entidades, posts, atributos, a galeria e outros elementos de uma exportação de campanha para essas campanhas. Isso acontece no backend e pode demorar um pouco, então tome um café. Você e os outros administradores da campanha serão notificados quando o processo de importação for concluído.',
    'fields'        => [
        'file'      => 'Exportar arquivo ZIP',
        'updated'   => 'Última atualização',
    ],
    'form'          => 'Carregar formulário',
    'limitation'    => 'Apenas arquivos zip são aceitos. Max :size.',
    'progress'      => [
        'uploading' => 'Carregando',
        'validating'=> 'Validando',
    ],
    'status'        => [
        'failed'    => 'Fracassado',
        'finished'  => 'Finalizado',
        'queued'    => 'Enfileirado',
        'running'   => 'Executando',
    ],
    'title'         => 'Importar',
];
