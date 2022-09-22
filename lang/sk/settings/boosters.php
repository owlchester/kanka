<?php

return [
    'actions'       => [
        'boost_name'    => 'Boost :name',
    ],
    'benefits'      => [
        'boosted'       => 'Boostnutie kampane s :one booster odomyká prístup k :marketplace, štýlovaniu, nahrávaniu väčších súborov pre všetkých členov, obnovovanie zmazaných objektov a :more.',
        'more'          => 'ďalšie úžasné funkcionality.',
        'superboosted'  => 'Superboostnutie kampane s :amount boostami odomyká všetky výhody boostnutej kampane, ako aj galériu kampane, plné reporty zmien, ktoré boli robené na objektoch, a :more.',
    ],
    'boost'         => [
        'actions'   => [
            'confirm'   => 'Boostni to!',
            'remove'    => 'Ukončiť boostnutie :campaign',
            'subscribe' => 'Predplatiť Kanku',
            'upgrade'   => 'Aktualizovať tvoje predplatné',
        ],
        'confirm'   => 'Ako vzrušujúce! Ideš boostnuť :campaign. Toto priradí jeden (:cost) z dostupných boostov kampani.',
        'duration'  => 'Priradené boosty ostávajú priradené, dokiaľ ich manuálne neodstrániš, alebo dokiaľ predplatné neskončí.',
        'errors'    => [
            'boosted'           => 'Och, zdá sa, že :campaign je už boostnutá!',
            'out-of-boosters'   => 'Och nie! Nemáš už dostatočný počet boostov. Máš :available a potrebuješ :cost. Buď ukonči boostnutie inej kampane, alebo :upgrade.',
        ],
        'pitch'     => 'Zakúp si predplatné a odomkni boostnutie kampaní.',
        'success'   => 'Kampaň :campaign je teraz boostnutá. Užívaj všetky úžasné funkcionality!',
        'title'     => 'Boostnuť :campaign',
        'upgrade'   => 'Aktualizovať tvoje predplatné',
    ],
    'campaign'      => [
        'boosted'       => 'Boostnuté :user od :time',
        'superboosted'  => 'Superboostnuté :user od :time',
        'unboosted'     => 'Neboostnuté',
    ],
    'intro'         => [
        'anyone'    => 'Nemusíš len boostnuť kampane, ktoré sú vytvorené tebou. Môžeš boostnuť hociktorú kampaň, ktorej si súčasťou alebo ktorá je viditeľná. Toto zahŕňa kampane, v ktorých hrávaš, alebo :public, ktoré sa ti páčia.',
        'data'      => 'Ak kampaň prestane byť boostnutá, prístup k boostnutým funkciám je odobratý. Ale žiaden obsah sa je odstránený, takže boostnutie kampane v budúcnosti ti ho opäť sprístupní.',
        'first'     => 'Rozšírené funkcie sa odomykajú priradením boostov na boostnutie alebo superboostnutie kampane. Počet boostov, ktoré máš, je dané tvojím :subscription. Toto číslo je dostupné zakaždým, kým máš predplatné. Boostnutie kampane priradí tejto jeden z tvojich boostov, zatiaľ čo superboostnutie požaduje boosty tri.',
    ],
    'pitch'         => [
        'benefits'      => [
            'backup'        => 'Obnov predtým odstránený objekt spred :amount dní',
            'customisable'  => 'Úplná možnosť úpravy vizuálu kampane',
            'entities'      => 'Lepšia kontrola nad tým, ako sa objekty správajú a vyzerajú',
            'icons'         => 'Prístup k tisíckam nádherných ikoniek pre mapy a časové osy',
            'relations'     => 'Objav vzťahy objektu vizuálne v prehliadači vzťahov',
            'title'         => 'Boostnuté kampane získajú',
            'upload'        => 'Väčšie veľkosti nahrávaných súborov pred všetkých členov',
        ],
        'description'   => 'Priraď boosty ku kampaniam a pomôž im odomknúť úžasné funkcionality pred všetkých zúčastnených. Nestačí ti boostnutie kampane? Tak potom pre teba máme možnosť kampaň superboostnuť!',
        'more'          => 'Spoznaj celý zoznam benefitov na stránke :boosters.',
        'title'         => 'Posuň kampaň na vyššiu úroveň s možnosťou vlastných úprav a výhod pre všetkých jej členov.',
    ],
    'ready'         => [
        'available'         => 'Tvoje dostupné kampaňové boosty.',
        'pricing'           => 'Všetky tvoje úrovne predplatného obsahujú aspoň jeden boost kampane a začínajú na :amount mesačne.',
        'pricing-amount'    => ':amount :currency',
        'title'             => 'Boostnutie kampane',
    ],
    'superboost'    => [
        'actions'   => [
            'confirm'   => 'Superboostni to!',
            'remove'    => 'Ukončiť superboostnutie :campaign',
        ],
        'confirm'   => 'Ako vzrušujúce! Ideš superboostnuť :campaign. Toto priradí tri (:cost) z dostupných boostov kampani.',
        'errors'    => [
            'boosted'   => 'Och, zdá sa, že :campaign je už superboostnutá!',
        ],
        'success'   => 'Kampaň :campaign je teraz superboostnutá. Užívaj všetky úžasné funkcionality!',
        'title'     => 'Superboostnuť :campaign',
        'upgrade'   => 'Priprav sa na ultimátne využitie Kanky! Superboostnutie :campaign jej priradí :cost dodatočné kampaňové boosty.',
    ],
    'title'         => 'Kampaňové boosty',
    'unboost'       => [
        'confirm'   => 'Áno, určite',
        'status'    => [
            'boosting'      => 'boostnutá',
            'superboosting' => 'superboostnutá',
        ],
        'success'   => 'Kampaň :campaign už nie je boostnutá a tvoje boosty sú opäť dostupné.',
        'title'     => 'Ukončiť boost kampane',
        'warning'   => 'Naozaj chceš ukončiť :action :campaign? Týmto uvoľníš tvoje priradené boosty a skryje sa všetok obsah a funkcionality, ktoré boli uvoľnené vďaka benefitom boostnutia.',
    ],
];
