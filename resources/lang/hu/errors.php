<?php

return [
    '403'       => [
        'body'  => 'Úgy tűnik, nincs jogosultságod a lap megtekintéséhez.',
        'title' => 'Hozzáférés megtagadva.',
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
    'footer'    => 'Ha további segítségre van szükséged, kérjük, keress meg minket a hello@kanka.io email-címen vagy a :discord szerverünkön.',
];
