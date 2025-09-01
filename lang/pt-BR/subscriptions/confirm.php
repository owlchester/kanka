<?php

return [
    'actions'   => [
        'pay'       => 'Pagar :amount :currency agora',
        'paypal'    => 'Pagar :amount :currency com PayPal',
    ],
    'helpers'   => [
        'auto-renew'    => [
            'monthly'   => 'Sua assinatura é renovada automaticamente todo mês. Sua próxima data de cobrança é :date.',
            'none'      => 'O pagamento com PayPal é único e não é renovado automaticamente. Você pode assinar novamente após o término da sua assinatura, após :date.',
            'yearly'    => 'Sua assinatura é renovada automaticamente a cada 12 meses. Sua próxima data de cobrança é :date.',
        ],
        'paypal'        => 'Você será redirecionado ao PayPal para concluir esta transação.',
        'refund'        => 'Oferecemos uma política de reembolso de 14 dias, sem perguntas, para todas as assinaturas anuais. Basta nos enviar um e-mail para :email para iniciar o processo de reembolso.',
    ],
    'title'     => ':nome da assinatura',
];
