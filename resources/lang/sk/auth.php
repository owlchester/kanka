<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed'    => 'Prihlasovacie údaje nie sú správne.',
    'helpers'   => [
        'password'  => 'Zobraziť / Skryť heslo',
    ],
    'login'     => [
        'fields'                => [
            'email'     => 'E-mail',
            'password'  => 'Heslo',
        ],
        'login_with_facebook'   => 'Prihlásenie cez Facebook',
        'login_with_google'     => 'Prihlásenie cez Google',
        'login_with_twitter'    => 'Prihlásenie cez Twitter',
        'new_account'           => 'Registrovať nové konto',
        'or'                    => 'ALEBO',
        'password_forgotten'    => 'Zabudnuté heslo?',
        'remember_me'           => 'Zapamätaj si ma',
        'submit'                => 'Prihlásiť',
        'title'                 => 'Prihlásenie',
    ],
    'register'  => [
        'already_account'           => 'Máš už vlastné konto?',
        'email'                     => [
            'body'  => '<p>Vitaj na kanka.io!</p><p>Tvoje konto bolo vytvorené pomocou tvojej e-mailovej adresy.</p>',
            'login' => 'Prihlásenie',
            'title' => 'Vitaj na kanka.io!',
        ],
        'errors'                    => [
            'email_already_taken'   => 'Konto s touto e-mailovou adresou už existuje.',
            'general_error'         => 'Nastala chyba pri registrácii tvojho konta. Prosím, skús to znovu.',
        ],
        'fields'                    => [
            'email'     => 'E-mail',
            'name'      => 'Meno užívateľa',
            'password'  => 'Heslo',
            'tos'       => 'Súhlasím s <a href=":privacyUrl" target="_blank">Privacy Policy</a>.',
        ],
        'register_with_facebook'    => 'Registrácia cez Facebook',
        'register_with_google'      => 'Registrácia cez Google',
        'register_with_twitter'     => 'Registrácia cez Twitter',
        'submit'                    => 'Registrovať',
        'title'                     => 'Registrácia',
        'welcome_email'             => [
            'header'        => 'Vitaj v Kanke, :name!',
            'header_sub'    => 'Gratulujeme, prvé kroky vo vytváraní vlastného sveta v :kanka máš za sebou!',
            'section_1'     => 'Čo ďalej?',
            'section_10'    => 'Podporovatelia',
            'section_11'    => 'Vytvor svoj svet,',
            'section_2'     => 'Najdôležitejší zdroj informácií je :discord, kde nájdeš veľa nadšených užívateľov a užívateľky, pomocný tím, zakladateľa Kanky, ktorí ti zodpovedajú tvoje otázky.',
            'section_3'     => 'Naša :faq taktiež obsahuje odpovede na najčastejšie otázky.',
            'section_4'     => 'Na našom :youtube nájdeš videá o základnom ovládaní Kanky. Aj keď nejdú príliš do hĺbky, nové videá sú neustále pridávané.',
            'section_5'     => 'Youtube kanál',
            'section_6'     => 'Kontaktuj nás',
            'section_7'     => 'Ak nájdené odpovede neboli postačujúce alebo sa s nami proste chceš spojiť, nájdeš nás na :facebook alebo nám napíš :email. Sme malý tím dvoch priateľov, ale snažíme sa odpovedať na každý e-mail, ktorý dostaneme, takže nech ťa to neodradí!',
            'section_8'     => 'Ešte jedna vec nakoniec',
            'section_9'     => 'Robíme všetko preto, aby základné funkcie Kanky boli stále voľne dostupné a tak to aj navždy zostane. Ak nás však chceš v tomto projekte podporiť, môžeš sa pridať medzi :patrons, a tak získať prístup k ďalším funkciám a zároveň našu večnú vďaku!',
            'title'         => 'Začíname s Kankou',
        ],
    ],
    'reset'     => [
        'fields'    => [
            'email'                 => 'E-mailová adresa',
            'password'              => 'Heslo',
            'password_confirmation' => 'Potvrď svoje heslo',
        ],
        'send'      => 'Zaslať link na obnovenie hesla',
        'submit'    => 'Obnoviť heslo',
        'title'     => 'Obnovenie hesla',
    ],
    'throttle'  => 'Prekročený limit pokusov. Skús to znovu o :seconds sekúnd.',
];
