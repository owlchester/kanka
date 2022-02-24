<?php

return [
    'campaign'          => [
        'application'           => [
            'approved'  => 'Sua solicitação para a campanha :campaign foi aprovada.',
            'new'       => 'Nova solicitação para :campaign.',
            'rejected'  => 'Sua solicitação para a campanha :campaign foi rejeitada. Razão fornecida: :reason',
        ],
        'asset_export'          => 'Uma exportação de recursos da campanha está disponível. O link está disponível por :time minutos.',
        'asset_export_error'    => 'Ocorreu um erro ao exportar os recursos da campanha. Isso acontece em grandes campanhas.',
        'boost'                 => [
            'add'           => 'A campanha :campaign  está sendo impulsionada por :user',
            'remove'        => ':user não está mais impulsionando a campanha :campaign',
            'superboost'    => 'A campanha :campaign está sendo super-impulsionada por :user',
        ],
        'deleted'               => 'A campanha :campaign foi excluída.',
        'export'                => 'A exportação da campanha está disponível. O link estará disponível por :time minutos.',
        'export_error'          => 'Ocorreu um erro enquanto sua campanha era exportada. Por favor, contate-nos se o problema persistir,',
        'join'                  => ':user se juntou à campanha :campaign',
        'leave'                 => ':user saiu da campanha :campaign',
        'plugin'                => [
            'deleted'   => 'O plugin :plugin foi deletado do mercado e removido de sua campanha :campaign.',
        ],
        'role'                  => [
            'add'       => 'Você ganhou o cargo de :role na campanha :campaign',
            'remove'    => 'Você foi removido do cargo :role na campanha :campaign.',
        ],
        'troubleshooting'       => [
            'joined'    => 'O membro da equipe Kanka :user juntou-se a campanha :campaign.',
        ],
    ],
    'clear'             => [
        'action'    => 'Limpar tudo',
        'confirm'   => 'Você tem certeza que quer remover todas as notificações? Essa ação não pode ser desfeita.',
        'success'   => 'Notificações removidas.',
    ],
    'header'            => 'Você tem :count notificações.',
    'index'             => [
        'title' => 'Notificações',
    ],
    'no_notifications'  => 'Não há notificações no momento.',
    'subscriptions'     => [
        'charge_fail'   => 'Ocorreu um erro ao tentar processar seu pagamento. Por favor, aguarde alguns momentos enquanto tentamos novamente. Se nada mudar, por favor entre em contato conosco.',
        'deleted'       => 'Sua assinatura do Kanka foi cancelada após muitas tentativas malsucedidas de cobrar seu cartão. Por favor, vá até suas configurações de Assinatura e tente atualizar os detalhes de sua forma de pagamento.',
        'ended'         => 'Sua assinatura do Kanka foi encerrada. Seus cargos do Discord e impulsionamentos de campanha foram removidos. Esperamos ver você novamente!',
        'failed'        => 'Não foi possível processar seus detalhes de pagamento. Por favor, atualize-os em suas configurações de Métodos de Pagamento.',
        'started'       => 'Sua assinatura do kanka foi iniciada.',
    ],
    'unread'            => 'Nova notificação',
];
