<?php

return [
    'actions'       => [
        'download'  => 'Download PDF',
    ],
    'description'   => 'Exibindo faturas dentro dos últimos 24 meses.',
    'empty'         => 'Nenhuma fatura encontrada',
    'fields'        => [
        'amount'    => 'Valor',
        'date'      => 'Data',
        'invoice'   => 'Fatura',
        'status'    => 'Status',
    ],
    'paypal'        => 'Observe que apenas pagamentos feitos pelo Stripe, e não pelo PayPal, são visíveis aqui.',
    'status'        => [
        'paid'      => 'Pago',
        'pending'   => 'Pendente',
    ],
    'title'         => 'Histórico de cobrança',
];
