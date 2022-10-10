<?php

return [
    'helpers'   => [
        'main'  => 'Verejné kampane sú viditeľné pred všetkých užívateľov, ktoré k nim majú link, alebo cez stránku :public-campaigns. Oprávnenia pre užívateľov zobrazujúcich kampaň sú kontrolované prostredníctvom roly :public-role.',
    ],
    'title'     => 'Zmeniť viditeľnosť kampane',
    'update'    => [
        'private'   => 'Kampaň je teraz privátna a viditeľná len pre jej členov.',
        'public'    => 'Kampaň je teraz verejná. Môže chvíľku trvať, kým sa zobrazí na stránke :public-campaigns.',
    ],
];
