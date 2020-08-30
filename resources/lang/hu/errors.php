<?php

return [
    '403'       => [
        'body'  => 'Úgy tűnik, nincs jogosultságod a lap megtekintéséhez.',
        'title' => 'Hozzáférés megtagadva.',
    ],
    '403-form'  => [
        'help'  => 'Ezt okozhatja, hogy lejárt munkameneted. Kérlek próbálj meg bejelentkezni egy új böngészőablakban, mielőtt mentenél.',
    ],
    '404'       => [
        'body'  => 'Sajnos nem találjuk a keresett oldalt.',
        'title' => 'Oldal nem található.',
    ],
    '500'       => [
        'body'  => [
            '1' => 'Hoppá, úgy tűnik, valami félrement.',
            '2' => 'A rendszer elküldte nekünk a hibajelentést, de néha segít, ha elmondod nekünk, pontosan mit is csináltál.',
        ],
        'title' => 'Hiba',
    ],
    '503'       => [
        'body'  => [
            '1' => 'A Kanka jelenleg karbantartás alatt áll - ez általában azt jelenti, hogy jön egy frissítés!',
            '2' => 'Elnézést kérünk a kellemetlenségért. Pár percen belül minden rendben lesz.',
        ],
        'title' => 'Karbantartás',
    ],
    '503-form'  => [
        'body'  => <<<'TEXT'
Nem tudtuk menteni az adatot, amelyet általában az alábbi két eset egyike szokott okozni:
Kérlek nyisd meg a Kankát az alábbi linken keresztül :link. Amennyiben az app karbantartás alatt áll, kérlek mentsd el a módosításaid valahol magadnak, és amikor az app megint elérhető, próbálkozz újra. Amennyiben "Böngésző ellenőrzése" üzenettel találkoznál, próbáld meg újra elmenteni a változtatásaid a Mentés gombra kattintva.
TEXT
,
        'link'  => 'új ablak',
        'title' => 'Váratlan esemény történt.',
    ],
    'footer'    => 'Ha további segítségre van szükséged, kérjük, keress meg minket a hello@kanka.io email-címen vagy a :discord szerverünkön.',
];
