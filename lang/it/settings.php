<?php

return [
    'account'       => [],
    'api'           => [],
    'apps'          => [],
    'billing'       => [],
    'boost'         => [
        'exceptions'    => [
            'already_boosted'   => 'La campagna :name è stata già potenziata.',
        ],
    ],
    'countries'     => [],
    'layout'        => [],
    'menu'          => [],
    'patreon'       => [
        'deprecated'    => 'Funzionalità disattivata - se desideri supportare Kanka, per favore fallo tramite un :subscription. Il collegamento con Patreon è ancora attivo per coloro che lo avevano collegato prima dell\'abbandono di Patreon.',
    ],
    'profile'       => [],
    'subscription'  => [
        'cancel'    => [
            'options'   => [
                'not_playing'   => 'Non gioco/scrivo più o la campagna è in pausa',
            ],
        ],
        'change'    => [
            'text'  => [
                'monthly'   => 'Stai sottoscrivendo l\'abbonamento per il grado :tier, da pagare mensilmente in cifra pari a :amount.',
                'yearly'    => 'Stai sottoscrivendo l\'abbonamento per il grado :tier, da pagare annualmente in cifra pari a :amount.',
            ],
        ],
        'helpers'   => [
            'paypal_v2' => 'Accettiamo PayPal per gli abbonamenti annuali. Contattaci all\'indirizzo :e-mail indicando l\'e-mail del tuo account Kanka, il livello a cui desideri abbonarti e la valuta (USD o EUR) in cui desideri essere fatturato.',
        ],
    ],
];
