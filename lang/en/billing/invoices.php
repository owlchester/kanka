<?php

return [
    'actions'       => [
        'download'  => 'Download PDF',
    ],
    'description'   => 'Showing invoices within the past 24 months.',
    'empty'         => 'No invoices found',
    'fields'        => [
        'amount'    => 'Amount',
        'date'      => 'Date',
        'invoice'   => 'Invoice',
        'status'    => 'Status',
    ],
    'status'        => [
        'paid'      => 'Paid',
        'pending'   => 'Pending',
    ],
    'title'         => 'Billing history',
];
