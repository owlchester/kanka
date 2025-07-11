<?php

return [
    'account'       => [
        '2fa'               => [
            'actions'               => [
                'disable'           => 'Desativar autenticação de dois fatores',
                'disable-confirm'   => 'Clique novamente para confirmar',
                'finish'            => 'Conclua a configuração e faça login',
            ],
            'activation_helper'     => 'Para concluir a configuração da autenticação de dois fatores da sua conta, siga estas instruções.',
            'disable'               => [
                'helper'    => 'Se você deseja desativar a autenticação de dois fatores, clique no botão abaixo. Lembre-se de que isso deixará sua conta vulnerável a qualquer pessoa que conheça suas informações de login.',
                'title'     => 'Desativar autenticação de dois fatores',
            ],
            'enable_instructions'   => 'Para iniciar o processo de ativação, gere seu QR Code de autenticação e, em seguida, digitalize-o no aplicativo Google Authenticator (:ios, :android) ou outro aplicativo autenticador semelhante.',
            'enabled'               => 'Autenticação de dois-fatores está atualmente ativada em sua conta.',
            'error_enable'          => 'Código Inválido, tente novamente',
            'fields'                => [
                'otp'       => 'Digite a Senha de Uso Único (OTP) fornecida pelo aplicativo autenticador',
                'qrcode'    => 'Digitalize o seguinte QR Code com seu aplicativo autenticador para gerar uma Senha de Uso Único (OTP)',
            ],
            'generate_qr'           => 'Gerar QR code',
            'helper'                => 'A autenticação de dois fatores (2FA) fortalece a segurança de acesso ao exigir dois métodos (também conhecidos como fatores) para verificar sua identidade em cada login.',
            'learn_more'            => 'Saiba mais sobre a autenticação de dois fatores.',
            'social'                => 'A autenticação de dois fatores do Kanka é habilitada apenas para usuários que fazem login usando seu e-mail e senha. Altere seu método de login nas configurações da sua conta antes de habilitar esta opção.',
            'success_disable'       => 'Autenticação de dois fatores desativada com sucesso.',
            'success_enable'        => 'Autenticação de dois fatores habilitada com sucesso. Faça login novamente para concluir a configuração.',
            'success_key'           => 'Seu QR Code de segurança foi gerado com sucesso. Conclua sua configuração para ativar a autenticação de dois fatores.',
            'title'                 => 'Autenticação de dois fatores',
        ],
        'actions'           => [
            'social'            => 'Trocar para o Login do Kanka',
            'update_email'      => 'Atualizar e-mail',
            'update_password'   => 'Atualizar senha',
        ],
        'email'             => 'Alterar e-mail',
        'email_success'     => 'E-mail atualizado.',
        'password'          => 'Alterar senha',
        'password_success'  => 'Senha atualizada.',
        'social'            => [
            'error'     => 'Você já está usando o login do Kanka para essa conta.',
            'helper'    => 'Atualmente sua conta está sendo gerenciada pelo :provider. Você pode mudar isto e trocar para o login padrão do Kanka configurando uma senha.',
            'success'   => 'Sua conta agora usa o login do Kanka.',
            'title'     => 'Social para Kanka',
        ],
        'title'             => 'Conta',
    ],
    'api'           => [
        'helper'    => 'Bem-vindo às APIs do Kanka. Gere um Token de Acesso Pessoal para usar em sua requisição de API para coletar informações sobre as campanhas das quais você faz parte.',
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
            'confirm'   => 'Tem certeza de que deseja desconectar sua conta do Discord? Isso removerá todas as funções com as quais você foi sincronizado.',
            'errors'    => [
                'add'   => 'Ocorreu um erro ao vincular sua conta do Discord ao Kanka. Por favor, tente novamente. Se isso continuar acontecendo, saiba que o Discord tem um limite de 100 servidores associados ao usar suas APIs.',
            ],
            'success'   => [
                'add'       => 'Sua conta do Discord foi vinculada.',
                'remove'    => 'Sua conta do Discord foi desvinculada.',
            ],
            'text'      => 'Acesse seus cargos de assinatura automaticamente.',
            'unlock'    => 'Desbloquear cargos do Discord',
        ],
        'title'     => 'Integração de App',
    ],
    'billing'       => [
        'placeholder'   => 'Se você precisar de contatos adicionais ou informações fiscais aos seus recibos (endereço comercial, número de IVA, etc.), insira-as abaixo e elas aparecerão em todos os seus recibos.',
        'save'          => 'Salvar informações de cobrança',
        'title'         => 'Informações de Cobrança',
    ],
    'boost'         => [
        'exceptions'    => [
            'already_boosted'       => 'Campanha :name já está sendo impulsionada.',
            'exhausted_boosts'      => 'Você está sem impulsos para dar. Remova o impulso de uma campanha antes de dar a outra.',
            'exhausted_superboosts' => 'Você está sem impulsionamentos. Você precisa de 3 impulsos para tornar uma campanha Super Impulsionada.',
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
    'invoices'      => [],
    'layout'        => [
        'title' => 'Layout',
    ],
    'marketplace'   => [],
    'menu'          => [
        'account'               => 'Conta',
        'api'                   => 'API',
        'appearance'            => 'Aparência',
        'apps'                  => 'Apps',
        'boosters'              => 'Impulsionamentos',
        'notifications'         => 'Notificações',
        'other'                 => 'Outros',
        'patreon'               => 'Patreon',
        'payment_options'       => 'Opções de Pagamento',
        'personal_settings'     => 'Configurações Pessoais',
        'premium'               => 'Campanhas premium',
        'profile'               => 'Perfil público',
        'settings'              => 'Configurações',
        'subscription'          => 'Assitatura',
        'subscription_status'   => 'Status da assinatura',
    ],
    'patreon'       => [
        'deprecated'    => 'Recurso obsoleto - se você deseja oferecer suporte ao Kanka, faça-o com uma :subscription. A vinculação do Patreon ainda está ativa para nossos clientes que vincularam suas contas antes de termos deixado o Patreon.',
        'pledge'        => 'Pledge :name',
        'remove'        => [
            'button'    => 'Desvincular sua conta Patreon',
            'success'   => 'Sua conta Patreon foi desvinculada.',
            'text'      => 'Desvincular sua conta Patreon com Kanka removerá seus bônus, nome no hall da fama, incentivos de campanha e outros recursos vinculados ao apoio a Kanka. Nenhum conteúdo impulsionado será perdido (por exemplo, cabeçalhos de entidade). Ao assinar novamente, você terá acesso a todos os seus dados anteriores, incluindo a capacidade de impulsionar suas campanhas impulsionadas anteriormente.',
            'title'     => 'Desvincule sua conta Patreon com Kanka',
        ],
        'title'         => 'Patreon',
    ],
    'profile'       => [
        'actions'   => [
            'update_profile'    => 'Atualizar perfil',
        ],
        'avatar'    => 'Foto de Perfil',
        'success'   => 'Perfil atualizado.',
        'title'     => 'Perfil público',
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
        ],
        'cancel'                => [
            'grace'     => [
                'text'  => 'Sua assinatura já está definida para terminar em :data, após a qual suas campanhas premium voltarão a ser campanhas padrão e outros benefícios relacionados ao suporte ao Kanka serão desativados.',
                'title' => 'Período de carência',
            ],
            'options'   => [
                'competitor'        => 'Alterar para um concorrente',
                'financial'         => 'A assinatura é muito cara',
                'missing_features'  => 'Falta de recursos',
                'not_for'           => 'Assinatura não é para mim',
                'not_playing'       => 'Não está mais jogando ou fazendo campanha em hiato',
                'not_using'         => 'Não estou usando o Kanka no momento',
                'other'             => 'Outro',
                'testing'           => 'Apenas testando Kanka',
            ],
            'text'      => 'Lamento ver você ir! Cancelar sua assinatura a manterá ativa até :date, após a qual você perderá seus impulsos de campanha e outros benefícios relacionados ao apoio a Kanka. Sinta-se à vontade para preencher o seguinte formulário para nos informar o que podemos fazer melhor ou o que levou à sua decisão.',
            'title'     => 'Cancelando a assinatura',
        ],
        'cancelled'             => 'Sua assinatura foi cancelada. Você pode renovar uma assinatura assim que sua assinatura atual terminar depois de :date.',
        'change'                => [
            'text'  => [
                'monthly'           => 'Você está se inscrevendo no nível :tier, cobrado mensalmente em :amount.',
                'upgrade_monthly'   => 'Você está atualizando para o nível :tier para :upgrade e, posteriormente, será cobrado mensalmente por :amount.',
                'upgrade_paypal'    => 'Você está atualizando para o nível :tier para :upgrade até :date.',
                'upgrade_yearly'    => 'Você está atualizando para o nível :tier para :upgrade, sendo posteriormente cobrado anualmente por :amount.',
                'yearly'            => 'Você está se inscrevendo no nível :tier, cobrado anualmente em :amount.',
            ],
            'title' => 'Alterar Nível de Assinatura',
        ],
        'coupon'                => [
            'check'         => 'Verifique o código promocional',
            'invalid'       => 'Código promocional inválido.',
            'label'         => 'Código promocional',
            'percent_off'   => 'Iremos descontar sua primeira assinatura anual em :percent%!',
        ],
        'currencies'            => [
            'brl'   => 'BRL',
            'eur'   => 'EUR',
            'usd'   => 'USD',
        ],
        'currency'              => [
            'title' => 'Altere sua moeda de cobrança preferida',
        ],
        'errors'                => [
            'callback'      => 'Nosso provedor de pagamento relatou um erro. Tente novamente ou entre em contato conosco se o problema persistir.',
            'failed'        => 'No momento, estamos enfrentando problemas com nosso sistema de cobrança. Entre em contato conosco em :email para obter assistência.',
            'subscribed'    => 'Não foi possível processar sua assinatura. Stripe forneceu a seguinte sugestão.',
        ],
        'fields'                => [
            'active_since'      => 'Ativa desde',
            'active_until'      => 'Ativa até',
            'billing'           => 'Cobrança',
            'currency'          => 'Moeda de Cobrança',
            'payment_method'    => 'Método de pagamento',
            'plan'              => 'Plano atual',
            'reason'            => 'Razão',
            'reset'             => 'Redefinir informações de cobrança',
            'reset_billing'     => 'Entendo que alterar a moeda fará com que eu perca meu histórico de cobrança e precise inserir novamente meu método de pagamento.',
        ],
        'helpers'               => [
            'alternatives'          => 'Pague sua assinatura usando :method. Este método de pagamento não será renovado automaticamente no final da sua assinatura. :method disponível apenas em Euros.',
            'alternatives-2'        => 'Pague sua assinatura usando :method. Este é um pagamento único que não é renovado automaticamente no final da assinatura.',
            'alternatives_warning'  => 'Não é possível atualizar sua assinatura ao usar este método. Faça uma nova assinatura quando a atual terminar.',
            'alternatives_yearly'   => 'Devido às restrições em torno dos pagamentos recorrentes, :method está disponível apenas para assinaturas anuais',
            'currency_block'        => 'Não é possível alterar a moeda enquanto você tiver uma assinatura Kanka ativa; você poderá alterar sua moeda quando sua assinatura atual terminar.',
            'currency_reset'        => 'Alterar a moeda de sua escolha excluirá seu histórico de cobrança e exigirá que você insira novamente um método de pagamento.',
            'paypal_v3'             => 'Pague com segurança pela sua assinatura anual usando o PayPal.',
            'stripe'                => 'Suas informações de cobrança são processadas e armazenadas com segurança por meio de :stripe.',
        ],
        'manage_subscription'   => 'Gerenciar assinatura',
        'payment_method'        => [
            'actions'       => [
                'add'               => 'Adicionar',
                'add_new'           => 'Adicionar um novo método de pagamento',
                'change'            => 'Alterar método de pagamento',
                'save'              => 'Salvar método de pagamento',
                'show_alternatives' => 'Métodos de pagamento alternativos',
            ],
            'add_one'       => 'No momento, você não tem um método de pagamento salvo.',
            'alternatives'  => 'Você pode se inscrever usando essas opções alternativas de pagamento. Esta ação cobrará sua conta uma vez e não renovará automaticamente sua assinatura todos os meses.',
            'card'          => 'Cartão',
            'card_name'     => 'Nome no cartão',
            'country'       => 'País de moradia',
            'ending'        => 'Válido até',
            'helper'        => 'Este cartão será usado para todas suas assinaturas.',
            'new_card'      => 'Adicionar um novo método de pagamento',
            'saved'         => ':brand terminando em :last4',
        ],
        'periods'               => [
            'monthly'   => 'Mensalmente',
            'yearly'    => 'Anualmente',
        ],
        'placeholders'          => [
            'downgrade_reason'  => 'Opcionalmente, diga-nos por que você está fazendo o downgrade de sua assinatura.',
            'reason'            => 'Opcionalmente, diga-nos por que você não está mais apoiando o Kanka. Estava faltando algum recurso? Sua situação financeira mudou?',
        ],
        'plans'                 => [
            'cost_monthly'  => ':currency :amount cobrado mensalmente',
            'cost_yearly'   => ':currency :amount cobrado anualmente',
        ],
        'sub_status'            => 'Informação da assinatura',
        'subscription'          => [
            'actions'   => [
                'cancel'            => 'Cancelar assinatura',
                'downgrading'       => 'Entre em contato conosco para fazer o downgrade',
                'rollback'          => 'Mudar para Kobold',
                'subscribe'         => 'Mudar para :tier mensalmente',
                'subscribe_annual'  => 'Mudar para :tier anualmente',
            ],
        ],
        'success'               => [
            'alternative'   => 'Seu pagamento foi registrado. Você receberá uma notificação assim que for processado e sua assinatura estiver ativa.',
            'callback'      => 'Sua assinatura foi realizada com sucesso. Sua conta será atualizada assim que nosso provedor de pagamento nos informar sobre a mudança (isso pode levar alguns minutos).',
            'currency'      => 'Sua configuração de moeda preferida foi atualizada.',
            'subscribed'    => 'Sua assinatura foi bem-sucedida! Não se esqueça de assinar o boletim informativo Votação da Comunidade para ser notificado quando uma votação for ao ar. Além disso, você pode conferir nosso discord e fazer parte da comunidade',
        ],
        'tiers'                 => 'Níveis de Assinatura',
        'trial_period'          => 'As assinaturas anuais têm uma política de cancelamento de 14 dias. Entre em contato conosco por :email se desejar cancelar sua assinatura anual e obter um reembolso.',
        'upgrade_downgrade'     => [
            'button'    => 'Informação de Upgrade e Downgrade',
            'cancel'    => [
                'bullets'   => [
                    'bonuses'   => 'Seus bônus permanecem ativados até o final do período de pagamento.',
                    'boosts'    => 'O mesmo acontece com suas campanhas impulsionadas. Os recursos impulsionados se tornam invisíveis, mas não são excluídos quando uma campanha não é mais impulsionada.',
                    'kobold'    => 'Para cancelar sua assinatura, mude para o nível Kobold',
                    'premium'   => 'O mesmo acontece com suas campanhas premium. Os recursos premium ficam invisíveis, mas não são excluídos quando uma campanha não é mais premium.',
                ],
                'title'     => 'Ao cancelar sua assinatura',
            ],
            'downgrade' => [
                'bullets'           => [
                    'end'   => 'Seu nível atual permanecerá ativo até o final do seu ciclo de faturamento atual, após o qual você será rebaixado para o seu novo nível.',
                ],
                'provide_reason'    => 'Se puder, compartilhe conosco por que está fazendo o downgrade de sua assinatura.',
                'title'             => 'Ao fazer downgrade para um nível menor',
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
