<?php

return [
    'actions'       => [
        'download'  => 'Download PDF',
    ],
    'description'   => 'Mostrando faturas dentro dos últimos 24 meses.',
    'empty'         => 'Nenhuma fatura encontrada',
    'fields'        => [
        'amount'    => 'Valor',
        'date'      => 'Data',
        'invoice'   => 'Fatura',
        'status'    => 'Status',
    ],
    'status'        => [
        'paid'      => 'Pago',
        'pending'   => 'Pendente',
    ],
    'title'         => 'Histórico de cobrança',
];
