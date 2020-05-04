<?php

return [
    '403'       => [
        'body'  => 'Izgleda da nemate dozvolu za pristup ovoj stranici!',
        'title' => 'Dozvola odbijena',
    ],
    '404'       => [
        'body'  => 'Nažalost, stranicu koju tražite nije moguće pronaći.',
        'title' => 'Stranica nije pronađena',
    ],
    '500'       => [
        'body'  => [
            '1' => 'Ups, izgleda da je nešto pošlo po zlu.',
            '2' => 'Izvješće s nađenom pogreškom nam je poslano, ali ponekad pomaže ako možemo znati malo više o tome što ste radili.',
        ],
        'title' => 'Pogreška',
    ],
    '503'       => [
        'body'  => [
            '1' => 'Kanka se trenutno održava, što obično znači da je u tijeku ažuriranje!',
            '2' => 'Oprostite na neugodnosti. Sve će se vratiti u normalu u samo nekoliko minuta.',
        ],
        'title' => 'Održavanje',
    ],
    '503-form'  => [
        'body'  => 'Nismo uspjeli pravilno spremiti tvoje podatke, što je obično uzrokovano jednim od dva faktora. Molimo da otvorite Kanku na :link. Ako se aplikacija održava, spremite svoje podatke negdje drugdje dok aplikacija ne bude ponovno podignuta pa pokušajte ponovo. Ako Vas je dočekala poruka "Provjera preglednika", pokušajte ponovo kliknuti Spremi.',
        'link'  => 'novi prozor',
        'title' => 'Dogodilo se nešto neočekivano.',
    ],
    'footer'    => 'Ako Vam je potrebna dodatna pomoć, kontaktirajte nas na hello@kanka.io ili na :discord',
];
