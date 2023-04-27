<?php

return [
    'actions'   => [
        'boost_name'    => 'Impulsionar :name',
    ],
    'available' => 'Impulsões disponíveis :amount/:total',
    'benefits'  => [
        'boosted'       => 'Impulsionar uma campanha com :one impulso desbloqueará o acesso ao :marketplace, opções de temas, uploads maiores para todos os membros, recuperação de entidades excluídas e :more.',
        'more'          => 'mais recursos incríveis',
        'superboosted'  => 'Superimpulsionar uma campanha com :amount impulsos desbloqueará todos os benefícios de uma campanha impulsionada, bem como uma galeria de campanha, alterações completas de logs que são feitas para entidades e :more.',
    ],
    'boost'     => [
        'actions'   => [
            'confirm'   => 'Impulsione-a!',
            'remove'    => 'Parar de impulsionar :campaign',
            'subscribe' => 'Inscreva-se no Kanka',
            'upgrade'   => 'Atualize sua assinatura',
        ],
        'confirm'   => 'Que legal! Você está prestes a impulsionar :campaign. Isso atribuirá um (:custo) de seus impulsos disponíveis de campanha.',
        'duration'  => 'Impulsos atribuídos permanecem atribuídos até que você os remova manualmente ou quando sua assinatura terminar.',
        'errors'    => [
            'boosted'           => 'Oh oh, parece que :campaign já foi impulsionada!',
            'out-of-boosters'   => 'Oh não! Você não tem impulsos suficientes disponíveis. Você tem :available e precisa de :cost. Pare de impulsionar outras campanhas ou :upgrade.',
        ],
        'pitch'     => 'Torne-se um assinante para desbloquear impulsos de campanha.',
        'success'   => 'A campanha :campaign agora está impulsionada. Aproveite todos os novos recursos incríveis!',
        'title'     => 'Impulsionar :campaign',
        'upgrade'   => 'atualize sua assinatura',
    ],
    'campaign'  => [
        'boosted'       => 'Impulsionado por :user desde :time',
        'superboosted'  => 'Superimpulsionado por :user desde :time',
        'unboosted'     => 'Desimpulsionado',
    ],
    'intro'     => [
        'anyone'    => 'Você não está limitado a impulsionar apenas as campanhas que criou. Você pode impulsionar qualquer campanha da qual faça parte ou possa visualizar. Isso inclui campanhas em que você é um jogador ou as :public de que gosta.',
        'data'      => 'Quando uma campanha não é mais impulsionada, o acesso aos recursos impulsionados é removido. No entanto, nenhum conteúdo é excluído, portanto, impulsionar a campanha novamente no futuro restaura o acesso a isto.',
        'first'     => 'Os recursos avançados são desbloqueados atribuindo seus impulsos para impulsionar ou superimpulsionar uma campanha. A quantidade de impulsos que você tem é determinada pela sua :subscription. Este número está disponível para você o tempo todo enquanto você for um assinante. Impulsionar uma campanha atribuirá um de seus impulsos a ela, enquanto superimpulsionar uma campanha atribuirá três deles.',
    ],
    'pitch'     => [
        'benefits'      => [
            'backup'        => 'Recupere uma entidade excluída anteriormente por até :amount dias',
            'customisable'  => 'Personalização total da aparência de uma campanha',
            'entities'      => 'Melhor controle sobre como as entidades se comportam e aparecem',
            'icons'         => 'Acesso a milhares de belos ícones para mapas e linhas do tempo',
            'relations'     => 'Explore as relações de uma entidade visualmente em um explorador visual',
            'title'         => 'As campanhas impulsionadas obtém',
            'upload'        => 'Maior tamanho de upload para todos os membros da campanha',
        ],
        'description'   => 'Atribua impulsos a campanhas e ajude a desbloquear recursos incríveis para todos os envolvidos. Não está impressionado com as campanhas impulsionadas? Nós o cobrimos com campanhas superimpulsionadas!',
        'more'          => 'Confira a lista completa de vantagens em nossa página :boosters.',
        'title'         => 'Leve uma campanha para o próximo nível com personalização e vantagens para todos os seus membros',
    ],
    'ready'     => [
        'available'         => 'Seus impulsos de campanha disponíveis.',
        'pricing'           => 'Todos os nossos níveis de assinatura incluem pelo menos um impulso de campanha e começa com :amount por mês.',
        'pricing-amount'    => ':currency:amount',
        'title'             => 'Impulsione uma campanha',
    ],
    'superboost'=> [
        'actions'   => [
            'confirm'   => 'Superimpulsione-a!',
            'instead'   => 'Superimpulsione-a por :count!',
            'remove'    => 'Parar de superimpulsionar :campaign',
        ],
        'confirm'   => 'Que legal! Você está prestes a dar uma superimpulsão em :campaign. Isso atribuirá três (:cost) de seus impulsos disponíveis de campanha.',
        'errors'    => [
            'boosted'   => 'Oh oh, parece que :campaign já está superimpulsionada!',
        ],
        'success'   => 'A campanha :campaign agora está superimpulsionada. Aproveite todos os novos recursos incríveis!',
        'title'     => 'Superimpulsionar :campaign',
        'upgrade'   => 'Pronto para uma melhor experiência no Kanka? Superimpulsionar :campaign atribuirá :cost impulsos de campanha adicionais.',
    ],
    'title'     => 'Impulsos de Campanha',
    'unboost'   => [
        'confirm'   => 'Sim, tenho certeza',
        'status'    => [
            'boosting'      => 'impulsionando',
            'superboosting' => 'superimpulsionando',
        ],
        'success'   => 'A campanha :campaign não é mais impulsionada e seus impulsos estão disponíveis novamente.',
        'title'     => 'Desimpulsionar uma campanha',
        'warning'   => 'Tem certeza de que deseja interromper :action :campaign? Isso liberará seus impulsos atribuídos e ocultará todo o conteúdo e recursos relacionados às vantagens até que a campanha seja impulsionada novamente.',
    ],
];
