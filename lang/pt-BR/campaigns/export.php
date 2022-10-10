<?php

return [
    'actions'   => [
        'export'    => 'Exportar os dados da campanha',
    ],
    'errors'    => [
        'limit' => 'A campanha já foi exportada uma vez hoje. Por favor, tente novamente amanhã.',
    ],
    'helpers'   => [
        'import'    => 'Essas exportações não podem ser reimportadas e destinam-se a sua própria tranquilidade ou se você não planeja mais usar o Kanka. Para uma experiência de exportação e importação mais robusta, consulte o arquivo :api.',
        'intro'     => 'Uma campanha pode ser exportada uma vez por dia pelos administradores da campanha. Isso gerará dois arquivos zip em segundo plano. O primeiro arquivo zip contém todas as entidades da campanha, enquanto o segundo arquivo zip contém todas as imagens. Você receberá uma notificação em Kanka assim que os arquivos zip estiverem prontos para serem baixados.',
        'json'      => 'O conteúdo exportado é fornecido no formato de arquivo JSON. JSON é um formato baseado em texto e você pode abri-lo em um editor de texto ou no navegador.',
    ],
    'success'   => 'A exportação da campanha está sendo preparada. Você será notificado em Kanka assim que estiver pronto para download.',
    'title'     => 'Exportação de campanha',
];
