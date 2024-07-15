<?php

return [
    'campaign'          => [
        'application'           => [
            'approved'              => 'Sua inscrição para a campanha :campaign foi aprovada.',
            'approved_message'      => 'Sua inscrição para a campanha :campaign foi aprovada. Mensagem fornecida: :reason',
            'new'                   => 'Nova solicitação para :campaign.',
            'rejected'              => 'Sua solicitação para a campanha :campaign foi rejeitada. Razão fornecida: :reason',
            'rejected_no_message'   => 'Sua inscrição para a campanha :campaign foi rejeitada.',
        ],
        'asset_export'          => 'Uma exportação de recursos da campanha está disponível. O link está disponível por :time minutos.',
        'asset_export_error'    => 'Ocorreu um erro ao exportar os recursos da campanha. Isso acontece em grandes campanhas.',
        'boost'                 => [
            'add'           => 'A campanha :campaign está sendo impulsionada por :user',
            'remove'        => ':user não está mais impulsionando a campanha :campaign',
            'superboost'    => 'A campanha :campaign está sendo super-impulsionada por :user',
        ],
        'deleted'               => 'A campanha :campaign foi excluída.',
        'export'                => 'A exportação da campanha está disponível. O link estará disponível por :time minutos.',
        'export_error'          => 'Ocorreu um erro enquanto sua campanha era exportada. Por favor, contate-nos se o problema persistir,',
        'hidden'                => 'A campanha :campaign agora está oculta na página de campanhas públicas.',
        'import'                => [
            'failed'    => 'A importação da campanha :campaign falhou.',
            'success'   => 'A campanha :campaign foi importada.',
        ],
        'join'                  => ':user se juntou à campanha :campaign',
        'leave'                 => ':user saiu da campanha :campaign',
        'plugin'                => [
            'deleted'   => 'O plugin :plugin foi deletado do mercado e removido de sua campanha :campaign.',
        ],
        'premium'               => [
            'add'       => 'Os recursos premium foram desbloqueados para a campanha :campaign pelo :user.',
            'remove'    => ':user não está mais desbloqueando recursos premium para a campanha :campaign.',
        ],
        'removed-image'         => 'A imagem ou cabeçalho de :entity foi removido devido a uma reivindicação de direitos autorais.',
        'role'                  => [
            'add'       => 'Você ganhou o cargo de :role na campanha :campaign',
            'remove'    => 'Você foi removido do cargo :role na campanha :campaign.',
        ],
        'shown'                 => 'A campanha :campaign agora está visível na página de campanhas públicas.',
        'troubleshooting'       => [
            'joined'    => 'O membro da equipe Kanka :user juntou-se a campanha :campaign.',
        ],
    ],
    'clear'             => [
        'action'    => 'Limpar tudo',
        'success'   => 'Notificações removidas.',
        'title'     => 'Limpar notificações',
    ],
    'features'          => [
        'approved'  => 'Sua ideia :feature foi aprovada',
        'rejected'  => 'Sua ideia :feature foi rejeita, motivo :reason',
    ],
    'header'            => 'Você tem :count notificações.',
    'index'             => [
        'title' => 'Notificações',
    ],
    'map'               => [
        'chunked'   => 'Mapa :name terminou de fragmentar e agora está pronto para uso.',
    ],
    'no_notifications'  => 'As notificações aparecerão aqui assim que você tiver algumas.',
    'subscriptions'     => [
        'charge_fail'   => 'Ocorreu um erro ao tentar processar seu pagamento. Por favor, aguarde alguns momentos enquanto tentamos novamente. Se nada mudar, por favor entre em contato conosco.',
        'deleted'       => 'Sua assinatura do Kanka foi cancelada após muitas tentativas malsucedidas de cobrar seu cartão. Por favor, vá até suas configurações de Assinatura e tente atualizar os detalhes de sua forma de pagamento.',
        'ended'         => 'Sua assinatura do Kanka foi encerrada. Seus cargos do Discord e impulsionamentos de campanha foram removidos. Esperamos ver você novamente!',
        'failed'        => 'Não foi possível processar seus detalhes de pagamento. Por favor, atualize-os em suas configurações de Métodos de Pagamento.',
        'started'       => 'Sua assinatura do kanka foi iniciada.',
    ],
    'unread'            => 'Nova notificação',
];
