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
        'helper'    => 'Bem vindo(a) as APIs do Kanka. Gere um token de acesso pessoal para usar em sua solicitação de API, para coletar informações sobre as campanhas das quais você faz parte.',
        'link'      => 'Leia a documentação da API',
        'title'     => 'API',
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
        'available_boosts'  => 'Impulsões disponíveis: :amount / :max',
        'benefits'          => [
            'headers'   => [
                'boosted'       => 'Benefícios da campanha Impulsionada',
                'superboosted'  => 'Benefícios da campanha Super Impulsionada',
            ],
            'more'      => [
                'boosted'       => 'Todos recursos de uma campanha Impulsionada',
                'superboosted'  => 'Todos recursos de uma campanha Super Impulsionada',
            ],
            'third'     => 'Para impulsionar uma campanha, vá até a página da campanha e clique no botão ":boost_button" acima do botão ":edit_button".',
        ],
        'buttons'           => [
            'boost'         => 'Impulsionamento',
            'superboost'    => 'Super Impulso',
            'tooltips'      => [
                'boost'         => 'Impulsionar uma campanha usa :amount de seus impulsos',
                'superboost'    => 'Super impulsionar uma campanha usa :amount de seus impulsos',
            ],
            'unboost'       => 'Deixar de impulsionar',
        ],
        'campaigns'         => 'Campanhas impulsionadas :count / :max',
        'exceptions'        => [
            'already_boosted'       => 'Campanha :name já está sendo impulsionada',
            'exhausted_boosts'      => 'Você está sem impulsos para dar. Remova o impulso de uma campanha antes de dar a outra.',
            'exhausted_superboosts' => 'Você está sem impulsionamentos. Você precisa de 3 impulsos para tornar uma campanha Super Impulsionada.',
        ],
        'modals'            => [
            'more'  => [
                'action'    => 'Mais impulsionamentos?',
                'body'      => 'Você pode obter mais impulsionamentos atualizando seu nível de assinatura ou removendo-os de uma campanha. O desbloqueio de uma campanha não exclui nenhuma das informações impulsionadas, apenas a desativa até que você impulsione essa campanha novamente.',
                'title'     => 'Obtendo mais impulsionamentos',
            ],
        ],
        'success'           => [
            'boost'         => 'Campanha :name impulsionada',
            'delete'        => 'Seu impulsionamento foi removido de :name',
            'superboost'    => 'Campanha :name foi Super Impulsionada',
        ],
        'title'             => 'Impulso',
        'unboost'           => [
            'description'   => 'Você tem certeza de que quer parar de impulsionar a campanha :tag?',
            'title'         => 'Deixar de impulsionar uma campanha',
        ],
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
        'invoices'              => 'Faturas',
        'layout'                => 'Layout',
        'marketplace'           => 'Mercado',
        'other'                 => 'Outros',
        'patreon'               => 'Patreon',
        'payment_options'       => 'Formas de pagamento',
        'personal_settings'     => 'Configurações pessoais',
        'profile'               => 'Perfil',
        'settings'              => 'Configurações',
        'subscription'          => 'Assitatura',
        'subscription_status'   => 'Status da assinatura',
    ],
    'patreon'       => [
        'deprecated'    => 'Recurso obsoleto - se você deseja oferecer suporte ao Kanka, faça-o com uma :subscription. A vinculação do Patreon ainda está ativa para nossos clientes que vincularam suas contas antes de termos deixado o Patreon.',
        'pledge'        => 'Pledge :name',
        'remove'        => [
            'button'    => 'Desvincular sua conta Patreon',
            'success'   => 'Sua conta Patreon foi desvinculada',
            'text'      => 'Desvincular sua conta do Patreon com Kanka removerá seus bônus, nome no Hall da fama, impulsionamentos de campanha e outros recursos vinculados ao suporte de Kanka. Nenhum de seus conteúdos impulsionados serão perdidos (por exemplo, cabeçalhos de entidade). Ao se inscrever novamente, você terá acesso a todos os seus dados anteriores, incluindo a capacidade de impulsionar suas campanhas previamente impulsionadas.',
            'title'     => 'Desvincule sua conta Patreon com Kanka',
        ],
        'title'         => 'Patreon',
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
        'billing'               => [
            'helper'    => 'Suas informações de faturamento são processadas e armazenadas com segurança através de :stripe. Este método de pagamento é usado para todas as suas assinaturas.',
            'saved'     => 'Método de pagamento salvo',
            'title'     => 'Editar método de pagamento',
        ],
        'cancel'                => [
            'options'   => [
                'competitor'        => 'Mudar para um concorrente',
                'custom'            => 'Outro (por favor especifique)',
                'financial'         => 'Situação financeira alterada',
                'missing_features'  => 'Recursos ausentes',
                'not_using'         => 'Não estou usando o Kanka no momento',
            ],
            'text'      => 'Lamentamos ver você ir! O cancelamento de sua assinatura a manterá ativa até o próximo ciclo de faturamento, após o qual você perderá os impulsionamentos à sua campanha e outros benefícios relacionados ao suporte ao Kanka. Sinta-se à vontade para preencher o formulário a seguir para nos informar o que podemos fazer melhor ou o que levou à sua decisão.',
        ],
        'cancelled'             => 'Sua assinatura foi cancelada. Você pode renovar uma assinatura assim que sua assinatura atual terminar.',
        'change'                => [
            'text'  => [
                'monthly'   => 'Você está se inscrevendo no nível :tier, cobrado mensalmente em :amount.',
                'yearly'    => 'Você está se inscrevendo no nível :tier, cobrado anualmente em :amount.',
            ],
            'title' => 'Alterar nível de assinatura',
        ],
        'coupon'                => [
            'check'         => 'Verifique o código promocional',
            'invalid'       => 'Código promocional inválido.',
            'label'         => 'Código promocional',
            'percent_off'   => 'Iremos descontar sua primeira assinatura anual por :percent%!',
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
            'cancel'    => [
                'bullets'   => [
                    'bonuses'   => 'Seus bônus permanecem ativados até o final do período de pagamento.',
                    'boosts'    => 'O mesmo acontece com suas campanhas impulsionadas. Os recursos impulsionados se tornam invisíveis, mas não são excluídos quando uma campanha não é mais impulsionada.',
                    'kobold'    => 'Para cancelar sua assinatura, mude para o nível Kobold',
                ],
                'title'     => 'Quando for cancelar sua assinatura',
            ],
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
