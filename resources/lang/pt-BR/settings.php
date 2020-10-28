<?php

return [
    'account'       => [
        'actions'           => [
            'social'            => 'Trocar para o login do Kanka',
            'update_email'      => 'Atualizar e-mail',
            'update_password'   => 'Atualizar senha',
        ],
        'email'             => 'Mudar e-mail',
        'email_success'     => 'E-mail atualizado com sucesso',
        'password'          => 'Mudar senha',
        'password_success'  => 'Senha atualizada com sucesso',
        'social'            => [
            'error'     => 'Você já está usando o login do Kanka nesta conta!',
            'helper'    => 'Atualmente, sua conta está sendo gerenciada pelo :provider. Você pode mudar isto e trocar para o login padrão do Kanka ao escolher uma senha.',
            'success'   => 'Sucesso! Sua conta agora usa o login do Kanka.',
            'title'     => 'Social para Kanka',
        ],
        'title'             => 'Conta',
    ],
    'api'           => [
        'experimental'          => 'Bem-vindo às APIs Kanka! Esses recursos ainda são experimentais, mas devem ser estáveis o suficiente para que você comece a se comunicar com as APIs. Crie um token de acesso pessoal para usar em suas solicitações de API ou use o token de cliente se desejar que seu aplicativo tenha acesso aos dados do usuário.',
        'help'                  => 'Em breve, Kanka fornecerá uma API RESTful para que aplicativos de terceiros possam se conectar ao aplicativo. Detalhes sobre como gerenciar suas chaves de API serão mostrados aqui.',
        'link'                  => 'Leia a documentação da API',
        'request_permission'    => 'No momento, estamos construindo uma API RESTful poderosa para que aplicativos de terceiros possam se conectar ao aplicativo. No entanto, atualmente estamos limitando o número de usuários que podem interagir com a API enquanto a aperfeiçoamos. Se você deseja acessar a API e construir aplicativos maneiros que se comunicam com o Kanka, entre em contato conosco e enviaremos todas as informações de que você precisa.',
        'title'                 => 'API',
    ],
    'apps'          => [
        'actions'   => [
            'connect'   => 'Conectar',
            'remove'    => 'Remover',
        ],
        'benefits'  => 'Kanka oferece integração com alguns serviços de terceiros. Mais integrações de terceiros estão planejadas para o futuro.',
        'discord'   => [
            'errors'    => [
                'add'   => 'Ocorreu um erro ao vincular sua conta do Discord ao kanka. Por favor, tente novamente.',
            ],
            'success'   => [
                'add'       => 'Sua conta do Discord foi vinculada com sucesso!',
                'remove'    => 'Sua conta do Discord foi desvinculada com sucesso.',
            ],
            'text'      => 'Acesse seus cargos de assinatura automaticamente.',
        ],
        'title'     => 'Integração de aplicativos',
    ],
    'boost'         => [
        'benefits'      => [
            'first'     => 'Para garantir o progresso contínuo no Kanka, alguns recursos da campanha são desbloqueados ao impulsionar uma campanha. Os impulsos são desbloqueados por meio de assinaturas. Qualquer um que pode ver uma campanha pode impulsioná-la, para que o Mestre nem sempre tenha que pagar a conta. Uma campanha permanece impulsionada enquanto um usuário estiver impulsionando a campanha e eles continuarem apoiando Kanka. Se uma campanha não é mais impulsionada, os dados não são perdidos, só ficam ocultos até que a campanha seja impulsionada novamente.',
            'header'    => 'Imagens de cabeçalho da entidade.',
            'images'    => 'Imagens de entidade padrão personalizadas.',
            'more'      => 'Descubra mais sobre todos os recursos.',
            'second'    => 'Impulsionar uma campanha oferece os seguintes benefícios:',
            'theme'     => 'Tema nível da campanha e estilo personalizado.',
            'third'     => 'Para impulsionar uma campanha, vá até a página da campanha e clique no botão ":boost_button" acima do botão ":edit_button".',
            'tooltip'   => 'Dicas de ferramentas personalizadas para entidades.',
            'upload'    => 'Aumento do tamanho de upload para todos os membros da campanha.',
        ],
        'buttons'       => [
            'boost' => 'Impulsionamento',
        ],
        'campaigns'     => 'Campanhas impulsionadas :count / :max',
        'exceptions'    => [
            'already_boosted'   => 'Campanha :name já está sendo impulsionada',
            'exhausted_boosts'  => 'Você está sem impulsos para dar. Remova o impulso de uma campanha antes de dar a outra.',
        ],
        'success'       => [
            'boost' => 'Campanha :name impulsionada',
            'delete'=> 'Seu impulsionamento foi removido de :name',
        ],
        'title'         => 'Impulso',
    ],
    'countries'     => [
        'austria'       => 'Áustria',
        'belgium'       => 'Bélgica',
        'france'        => 'França',
        'germany'       => 'Alemanha',
        'italy'         => 'Itália',
        'netherlands'   => 'Holanda',
        'spain'         => 'Espanha',
    ],
    'invoices'      => [
        'actions'   => [
            'download'  => 'Baixar PDF',
            'view_all'  => 'Ver tudo',
        ],
        'empty'     => 'Sem faturas',
        'fields'    => [
            'amount'    => 'Quantidade',
            'date'      => 'Data',
            'invoice'   => 'Fatura',
            'status'    => 'Status',
        ],
        'header'    => 'Abaixo está alista de suas últimas 24 faturas, que podem ser baixadas',
        'status'    => [
            'paid'      => 'Pago',
            'pending'   => 'Pendente',
        ],
        'title'     => 'Faturas',
    ],
    'layout'        => [
        'success'   => 'Opções de layout atualizadas.',
        'title'     => 'Layout',
    ],
    'marketplace'   => [
        'fields'    => [
            'name'  => 'Nome do Mercado',
        ],
        'helper'    => 'Como padrão, seu nome de usuário é mostrado no :marketplace:. Você pode alterar isso neste campo.',
        'title'     => 'Configurações do Mercado',
        'update'    => 'Configurações do Mercado salvas com sucesso.',
    ],
    'menu'          => [
        'account'               => 'Conta',
        'api'                   => 'API',
        'apps'                  => 'Aplicativos',
        'billing'               => 'Formas de Pagamento',
        'boost'                 => 'Impulsionamento',
        'invoices'              => 'Faturas',
        'layout'                => 'Layout',
        'marketplace'           => 'Mercado',
        'other'                 => 'Outros',
        'patreon'               => 'Patreon',
        'payment_options'       => 'Formas de pagamento',
        'personal_settings'     => 'Configurações pessoais',
        'profile'               => 'Perfil',
        'subscription'          => 'Assitatura',
        'subscription_status'   => 'Status da assinatura',
    ],
    'patreon'       => [
        'actions'           => [
            'link'  => 'Vincular conta',
            'view'  => 'Visite Kanka no Patreon',
        ],
        'benefits'          => 'Apoiando-nos em :patreon desbloqueia todos os tipos de :features para você e suas campanhas, e também nos ajuda a passar mais tempo trabalhando para melhorar o Kanka.',
        'benefits_features' => 'Recursos incríveis',
        'deprecated'        => 'Recurso obsoleto - se você deseja oferecer suporte ao Kanka, faça-o com uma :subscription. A vinculação do Patreon ainda está ativa para nossos clientes que vincularam suas contas antes de termos deixado o Patreon.',
        'description'       => 'Sincronizando com o Patreon',
        'linked'            => 'Obrigado por apoiar o Kanka no Patreon! Sua conta está vinculada.',
        'pledge'            => 'Pledge :name',
        'remove'            => [
            'button'    => 'Desvincular sua conta Patreon',
            'success'   => 'Sua conta Patreon foi desvinculada',
            'text'      => 'Desvincular sua conta do Patreon com Kanka removerá seus bônus, nome no Hall da fama, impulsionamentos de campanha e outros recursos vinculados ao suporte de Kanka. Nenhum de seus conteúdos impulsionados serão perdidos (por exemplo, cabeçalhos de entidade). Ao se inscrever novamente, você terá acesso a todos os seus dados anteriores, incluindo a capacidade de impulsionar suas campanhas previamente impulsionadas.',
            'title'     => 'Desvincule sua conta Patreon com Kanka',
        ],
        'success'           => 'Obrigado por apoiar Kanka no Patreon!',
        'title'             => 'Patreon',
        'wrong_pledge'      => 'Seu nível de pledge é definido manualmente por nós, portanto, espere alguns dias para que possamos defini-lo corretamente. Se continuar errado por muito tempo, entre em contato conosco.',
    ],
    'profile'       => [
        'actions'   => [
            'update_profile'    => 'Atualizar perfil',
        ],
        'avatar'    => 'Foto de Perfil',
        'success'   => 'Perfil atualizado',
        'title'     => 'Perfil pessoal',
    ],
    'subscription'  => [
        'actions'               => [
            'cancel_sub'        => 'Cancelar assinatura',
            'subscribe'         => 'Assinar',
            'update_currency'   => 'Salvar moeda preferida',
        ],
        'benefits'              => 'Ao nos apoiar, você pode desbloquear alguns novos :features e nos ajudar a investir mais tempo para melhorar o Kanka. Nenhuma informação de cartão de crédito é armazenada ou transita por nossos servidores. Usamos :stripe para lidar com todo o faturamento.',
        'billing'               => [
            'helper'    => 'Suas informações de faturamento são processadas e armazenadas com segurança através de :stripe. Este método de pagamento é usado para todas as suas assinaturas.',
            'saved'     => 'Método de pagamento salvo',
            'title'     => 'Editar método de pagamento',
        ],
        'cancel'                => [
            'text'  => 'Lamentamos ver você ir! O cancelamento de sua assinatura a manterá ativa até o próximo ciclo de faturamento, após o qual você perderá os impulsionamentos à sua campanha e outros benefícios relacionados ao suporte ao Kanka. Sinta-se à vontade para preencher o formulário a seguir para nos informar o que podemos fazer melhor ou o que levou à sua decisão.',
        ],
        'cancelled'             => 'Sua assinatura foi cancelada. Você pode renovar uma assinatura assim que sua assinatura atual terminar.',
        'change'                => [
            'text'  => [
                'monthly'   => 'Você está se inscrevendo no nível :tier, cobrado mensalmente em :amount.',
                'yearly'    => 'Você está se inscrevendo no nível :tier, cobrado anualmente em :amount.',
            ],
            'title' => 'Alterar nível de assinatura',
        ],
        'currencies'            => [
            'eur'   => 'EUR',
            'usd'   => 'USD',
        ],
        'currency'              => [
            'title' => 'Altere sua moeda de cobrança preferida',
        ],
        'errors'                => [
            'callback'      => 'Nosso provedor de pagamento relatou um erro. Tente novamente ou entre em contato conosco se o problema persistir.',
            'subscribed'    => 'Não foi possível processar sua assinatura. Stripe forneceu a sugestão seguinte.',
        ],
        'fields'                => [
            'active_since'      => 'Ativa desde',
            'active_until'      => 'Ativa até',
            'billing'           => 'Cobrança',
            'currency'          => 'Moeda de cobrança',
            'payment_method'    => 'Método de pagamento',
            'plan'              => 'Plano atual',
            'reason'            => 'Razão',
        ],
        'helpers'               => [
            'alternatives'          => 'Pague sua assinatura usando :method. Este método de pagamento não será renovado automaticamente no final da sua assinatura. :method disponível apenas em euros.',
            'alternatives_warning'  => 'Não é possível atualizar sua assinatura ao usar este método. Faça uma nova assinatura quando a atual terminar.',
            'alternatives_yearly'   => 'Devido às restrições em torno dos pagamentos recorrentes, :method está disponível apenas para assinaturas anuais',
        ],
        'manage_subscription'   => 'Gerenciar assinatura',
        'payment_method'        => [
            'actions'       => [
                'add_new'           => 'Adicionar novo método de pagamento',
                'change'            => 'Mudar método de pagamento',
                'save'              => 'Salvar método de pagamento',
                'show_alternatives' => 'Métodos de pagamento alternativos',
            ],
            'add_one'       => 'No momento, você não tem um método de pagamento salvo.',
            'alternatives'  => 'Você pode se inscrever usando essas opções alternativas de pagamento. Esta ação cobrará sua conta uma vez e não renovará automaticamente sua assinatura todos os meses.',
            'card'          => 'Cartão',
            'card_name'     => 'Nome no cartão',
            'country'       => 'País de residência',
            'ending'        => 'Terminado em',
            'helper'        => 'Este cartão será usado para todas suas assinaturas.',
            'new_card'      => 'Adicionar novo método de pagamento',
            'saved'         => ':brand terminando em :last4',
        ],
        'placeholders'          => [
            'reason'    => 'Opcionalmente, diga-nos por que você não está mais apoiando o Kanka. Estava faltando algum recurso? Sua situação financeira mudou?',
        ],
        'plans'                 => [
            'cost_monthly'  => ':currency :amount cobrado mensalmente',
            'cost_yearly'   => ':currency :amount cobrado anualmente',
        ],
        'sub_status'            => 'Informação da assinatura',
        'subscription'          => [
            'actions'   => [
                'downgrading'       => 'Entre em contato conosco para fazer o downgrade',
                'rollback'          => 'Mudar para Kobold',
                'subscribe'         => 'Mudar para :tier mensalmente',
                'subscribe_annual'  => 'Mudar para :tier anualmente',
            ],
        ],
        'success'               => [
            'alternative'   => 'Seu pagamento foi registrado. Você receberá uma notificação assim que for processado e sua assinatura estiver ativa.',
            'callback'      => 'Sua assinatura foi realizada com sucesso. Sua conta será atualizada assim que nosso provedor de pagamento nos informar sobre a mudança (isso pode levar alguns minutos).',
            'cancel'        => 'Sua assinatura foi cancelada. Ela continuará ativa até o final do seu período de faturamento atual.',
            'currency'      => 'Sua configuração de moeda preferida foi atualizada.',
            'subscribed'    => 'Sua assinatura foi realizada com sucesso. Não se esqueça de assinar a newsletter do Voto da Comunidade para ser notificado quando uma votação estiver disponível. Você pode alterar as configurações da newsletter em sua página de perfil.',
        ],
        'tiers'                 => 'Níveis de assinatura',
        'trial_period'          => 'As assinaturas anuais têm uma política de cancelamento de 14 dias. Entre em contato conosco por :email se desejar cancelar sua assinatura anual e obter um reembolso.',
        'upgrade_downgrade'     => [
            'button'    => 'Informação de Upgrade e Downgrade',
            'downgrade' => [
                'bullets'   => [
                    'end'   => 'Seu nível atual permanecerá ativo até o final do seu ciclo de faturamento atual, após o qual você será rebaixado para o novo nível.',
                ],
                'title'     => 'Ao fazer downgrade para um nível menor',
            ],
            'upgrade'   => [
                'bullets'   => [
                    'immediate' => 'Seu método de pagamento será cobrado imediatamente e você terá acesso ao seu novo nível.',
                    'prorate'   => 'Ao fazer upgrade de Urso-Coruja para Elemental, você só será cobrado pela diferença de seu novo nível.',
                ],
                'title'     => 'Ao fazer upgrade para um nível maior',
            ],
        ],
        'warnings'              => [
            'incomplete'    => 'Não foi possível cobrar seu cartão de crédito. Atualize as informações do seu cartão de crédito e tentaremos cobrar novamente nos próximos dias. Se falhar novamente, sua assinatura será cancelada.',
            'patreon'       => 'Sua conta está atualmente vinculada ao Patreon. Desvincule sua conta nas configurações de :patreon antes de mudar para uma assinatura Kanka.',
        ],
    ],
];
