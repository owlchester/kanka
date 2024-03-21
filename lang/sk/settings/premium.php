<?php

return [
    'actions'       => [
        'remove'    => 'Odstrániť prémium',
        'unlock'    => 'Získaj prémium',
    ],
    'create'        => [
        'actions'   => [
            'confirm'   => 'Získaj prémium!',
        ],
        'confirm'   => 'Vzrušujúce! Ideš odomknúť prémiové funkcionality pre :campaign. Bude na to použité jedno prémium.',
        'duration'  => 'Prémiové kampane ostávajú dokiaľ ich manuálne neodstrániš alebo kým neskončí tvoje predplatné.',
        'pitch'     => 'Zaplať si predplatné a odomkni prémiové kampane.',
        'success'   => 'Kampaň :campaign je teraz prémiová. Užívaj jej nové úžasné funkcionality!',
    ],
    'exceptions'    => [
        'already'       => 'Prémiové funkcionality boli už pre túto kampaň odomknuté.',
        'out-of-stock'  => 'Nemáš dostatok prémia, aby bolo možné odomknúť túto kampaň. Odober prémiový status z nejakej kampane alebo :upgrade.',
    ],
    'pitch'         => [
        'description'   => 'Pridaj prémium kampaniam a pomôž odomknúť úžasné funkcionality pre každého v nich.',
        'more'          => 'Spoznaj celý prehľad výhod na stránke :premium.',
        'title'         => 'Prémiové kampane získavajú',
    ],
    'ready'         => [
        'available'         => 'Tvoje dostupné prémiové nastavenia.',
        'pricing'           => 'Všetky naše predplatné úrovne obsahujú min. 1 prémiovú kampaň a sú dostupné od :amount mesačne.',
        'pricing-amount'    => ':amount :currency',
        'title'             => 'Získaj prémium',
    ],
    'remove'        => [
        'confirm'   => 'Áno, naozaj',
        'cooldown'  => 'Prémiové funkcie z :campaign môžu byť odstránené po :date.',
        'success'   => 'Prémiové funkcionality boli odobraté z kampane :campaign. Teraz môžeš odomknúť prémiové funkcionality pre inú kampaň.',
        'title'     => 'Odobrať prémiové funkcionality',
        'warning'   => 'Naozaj chceš odobrať prémiové funkcionality z :campaign? Toto ti umožní odomknúť inú kampaň a skryť všetok obsah spojený s prémiovými funkcionalitami dokiaľ sa jej prémiový status neobnoví.',
    ],
];
