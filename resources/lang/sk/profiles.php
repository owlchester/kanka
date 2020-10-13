<?php

return [
    'avatar'        => [
        'success'   => 'Avatar aktualizovaný.',
    ],
    'description'   => 'Uprav detaily tvojho profilu',
    'edit'          => [
        'success'   => 'Profil upravený',
    ],
    'editors'       => [
        'default'       => 'TinyMCE 4 (štandard)',
        'summernote'    => 'Summernote (experimentálna verzia)',
    ],
    'fields'        => [
        'avatar'                    => 'Avatar',
        'email'                     => 'E-mail',
        'last_login_share'          => 'Zdieľaj s ostatnými členmi kampane tvoj posledný čas online.',
        'name'                      => 'Meno',
        'new_password'              => 'Nové heslo (voliteľné)',
        'new_password_confirmation' => 'Potvrdiť nové heslo',
        'newsletter'                => 'Prajem si, aby ste ma niekedy kontaktovali mailom.',
        'password'                  => 'Súčasné heslo',
        'settings'                  => 'Nastavenia',
        'theme'                     => 'Téma',
    ],
    'newsletter'    => [
        'links'     => [
            'community-vote'    => 'Komunitné hlasovanie',
            'news'              => 'Novinky',
        ],
        'settings'  => [
            'news'          => 'Novinky - oznámenie pri publikovaní nových :news.',
            'newsletter'    => 'Newsletter - zaslanie newslettra Kanky.',
            'votes'         => 'Komunitné hlasovania - oznámenie o novom :vote.',
        ],
        'title'     => 'Newsletter',
    ],
    'password'      => [
        'success'   => 'Heslo zmenené',
    ],
    'placeholders'  => [
        'email'                     => 'Tvoja e-mailová adresa',
        'name'                      => 'Tvoje meno, ako sa bude zobrazovať',
        'new_password'              => 'Tvoje nové heslo',
        'new_password_confirmation' => 'Potvrď tvoje nové heslo',
        'password'                  => 'Zadaj tvoje aktuálne heslo',
    ],
    'sections'      => [
        'delete'    => [
            'delete'    => 'Odstrániť moje konto',
            'title'     => 'Odstránenie môjho konta',
            'warning'   => 'Odstránením tvojho konta sa odstránia aj všetky tvoje údaje. Chceš to naozaj urobiť?',
        ],
        'password'  => [
            'title' => 'Zmena hesla',
        ],
    ],
    'settings'      => [
        'fields'    => [
            'advanced_mentions'     => 'Pokročilé referencie',
            'date_format'           => 'Formát dátumu',
            'default_nested'        => 'Vnorené zobrazenie ako štandard',
            'editor'                => 'Textový editor',
            'new_entity_workflow'   => 'Nový workflow objektu',
            'pagination'            => 'Stránkovanie (počet objektov na stránke)',
        ],
        'helpers'   => [
            'editor'    => 'Štandardný editor (TinyMCE 4) je starší ale funguje dobre na desktope, nie však na mobile. Summernote je novší editor, ktorý správne funguje na všetkých zariadeniach, ale ešte stále ho testujeme.',
        ],
        'hints'     => [
            'advanced_mentions'     => 'Ak je toto nastavenie aktívne, budú sa referencie pri úprave objektov zobrazovať vo forme [entity:123].',
            'default_nested'        => 'Aktivuj toto nastavenie, ak si praješ, aby sa zoznamy štandardne zobrazovali vnorene.',
            'new_entity_workflow'   => 'Po vytvorení nového objektu sa systém vracia do zoznamu objektov. Tento workflow môžeš zmeniť, aby sa po vytvorení zobrazil nový objekt.',
        ],
        'success'   => 'Nastavenia zmenené.',
    ],
    'theme'         => [
        'success'   => 'Téma zmenená.',
        'themes'    => [
            'dark'      => 'Dark',
            'default'   => 'Štandard',
            'future'    => 'Future',
            'midnight'  => 'Midnight Blue',
        ],
    ],
    'title'         => 'Úprava profilu',
    'workflows'     => [
        'created'   => 'Prejsť na vytvorený objekt',
        'default'   => 'Zoznam objektov',
    ],
];
