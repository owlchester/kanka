<?php

return [
    'campaign'          => [
        'boost'         => [
            'add'           => 'A campanha :campaign  está sendo impulsionada por :user',
            'remove'        => ':user não está mais impulsionando a campanha :campaign',
            'superboost'    => 'A campanha :campaign está sendo super-impulsionada por :user',
        ],
        'export'        => 'A exportação da campanha está disponível. Você pode fazer o download dela clicando <a href=":link">here</a>. O link estará disponível por :time minutos.',
        'export_error'  => 'Ocorreu um erro enquanto sua campanha era exportada. Por favor, contate-nos se o problema persistir,',
        'join'          => ':user se juntou à campanha :campaign',
        'leave'         => ':user saiu da campanha :campaign',
        'role'          => [
            'add'       => 'Você ganhou o cargo de :role na campanha :campaign',
            'remove'    => 'Você foi removido do cargo :role na campanha :campaign.',
        ],
    ],
    'header'            => 'Você tem :count notificações.',
    'index'             => [
        'description'   => 'Suas notificações mais recentes',
        'title'         => 'Notificações',
    ],
    'no_notifications'  => 'Não há notificações no momento.',
    'permissions'       => [
        'body'  => 'Ei, nós gostaríamos de te informar que nós mudamos completamente o sistema de permissões para cada campanha!</p><p>Campanhas podem agora ter cargos, e cada cargo pode ter permissões para acessar, editar ou deletar entidades. Cada entidade pode também ser ajustada com permissões específicas para cada usuário, significando que João e Maria podem editar os seus próprios personagens!</p><p> O único ponto negativo é que campanhas com diversos usuários terão que configurar suas novas permissões. Se você é  Administrador de uma campanha, você pode fazer isso na página de configurações da campanha. Se você é parte da campanha, você não verá nada até o dono ter ajustado isso.',
        'title' => 'Mudanças nas Permissões',
    ],
    'subscriptions'     => [
        'charge_fail'   => 'Ocorreu um erro ao tentar processar seu pagamento. Por favor, aguarde alguns momentos enquanto tentamos novamente. Se nada mudar, por favor entre em contato conosco.',
        'deleted'       => 'Sua assinatura do Kanka foi cancelada após muitas tentativas malsucedidas de cobrar seu cartão. Por favor, vá até suas configurações de Assinatura e tente atualizar os detalhes de sua forma de pagamento.',
        'ended'         => 'Sua assinatura do Kanka foi encerrada. Seus cargos do Discord e impulsionamentos de campanha foram removidos. Esperamos ver você novamente!',
        'failed'        => 'Não foi possível processar seus detalhes de pagamento. Por favor, atualize-os em suas configurações de Métodos de Pagamento.',
        'started'       => 'Sua assinatura do kanka foi iniciada.',
    ],
];
