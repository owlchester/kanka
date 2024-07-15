<?php

return [
    'actions'       => [
        'download'  => 'Télécharger le PDF',
    ],
    'description'   => 'Affichage des factures des derniers 24 mois.',
    'empty'         => 'Aucune facture trouvée.',
    'fields'        => [
        'amount'    => 'Somme',
        'date'      => 'Date',
        'invoice'   => 'Facture',
        'status'    => 'Status',
    ],
    'paypal'        => 'Seuls les paiements effectués par Stripe, et non par PayPal, sont visibles ici.',
    'status'        => [
        'paid'      => 'Payée',
        'pending'   => 'En attente',
    ],
    'title'         => 'Historique de facturation',
];
