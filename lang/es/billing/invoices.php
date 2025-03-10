<?php

return [
    'actions'       => [
        'download'  => 'Descargar PDF',
    ],
    'description'   => 'Mostrando facturas de los últimos 24 meses.',
    'empty'         => 'No se encontraron facturas',
    'fields'        => [
        'amount'    => 'Importe',
        'date'      => 'Fecha',
        'invoice'   => 'Factura',
        'status'    => 'Estado',
    ],
    'paypal'        => 'Ten en cuenta que sólo los pagos realizados a través de Stripe y no a través de PayPal son visibles aquí.',
    'status'        => [
        'paid'      => 'Pagado',
        'pending'   => 'Pendiente',
    ],
    'title'         => 'Historial de facturación',
];
