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
    'status'        => [
        'paid'      => 'Pagado',
        'pending'   => 'Pendiente',
    ],
    'title'         => 'Historial de facturación',
];
