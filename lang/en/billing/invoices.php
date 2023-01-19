<?php

return [
    'title' => 'Billing history',
    'description' => 'Showing invoices within the past 24 months.',

    'actions'   => [
        'download'  => 'Download PDF',
    ],
    'empty'     => 'No invoices found',
    'fields'    => [
        'amount'    => 'Amount',
        'date'      => 'Date',
        'invoice'   => 'Invoice',
        'status'    => 'Status',
    ],
    'status'    => [
        'paid'      => 'Paid',
        'pending'   => 'Pending',
    ],
];
