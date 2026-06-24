<?php

return [
    'actions'   => [
        'pay'   => 'Pagar :amount :currency agora',
    ],
    'helpers'   => [
        'auto-renew'    => [
            'monthly'   => 'Sua assinatura é renovada automaticamente todo mês. Sua próxima data de cobrança é :date.',
            'yearly'    => 'Sua assinatura é renovada automaticamente a cada 12 meses. Sua próxima data de cobrança é :date.',
        ],
        'refund'        => 'Oferecemos uma política de reembolso de 14 dias, sem perguntas, para todas as assinaturas anuais. Basta nos enviar um e-mail para :email para iniciar o processo de reembolso.',
    ],
    'title'     => ':nome da assinatura',
];
