<?php

return [
    'actions'   => [
        'export'    => 'Exportovať údaje kampane',
    ],
    'errors'    => [
        'limit' => 'Kampaň už dnes bola raz exportovaná. Prosím, vyskúšaj to opäť zajtra.',
    ],
    'helpers'   => [
        'import'    => 'Tieto exporty nemôžu byť použité na spätný import a slúžia pre teba alebo ak neplánuješ Kanku ďalej používať. Ak hľadáš schopnejšiu funkcionalitu exportu a importu, pozri sa na :api.',
        'intro'     => 'Kampaň môžu raz za deň exportovať jej admini. V pozadí sa vytvoria dva zipované súbory. Prvý obsahuje všetky objekty kampane, zatiaľ čo druhý obsahuje všetky obrázky. Akonáhle budú pripravené na stiahnutie, obdržíš o tom notifikáciu v Kanke.',
        'json'      => 'Exportovaný obsah je poskytovaný vo formáte JSON. JSON je textový formát a môžeš ho otvoriť v textovom editore alebo prehliadači.',
    ],
    'success'   => 'Pripravuje sa export kampane. O pripravení na stiahnutie ťa budeme informovať v Kanke.',
    'title'     => 'Export kampane',
];
