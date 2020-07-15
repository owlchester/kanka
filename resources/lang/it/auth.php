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
    'failed'    => 'Credenziali non corrispondenti ai dati registrati.',
    'helpers'   => [
        'password'  => 'Mostra / Nascondi password',
    ],
    'login'     => [
        'fields'                => [
            'email'     => 'Email',
            'password'  => 'Password',
        ],
        'login_with_facebook'   => 'Accedi con Facebook',
        'login_with_google'     => 'Accedi con Google',
        'login_with_twitter'    => 'Accedi con Twitter',
        'new_account'           => 'Registra un nuovo account',
        'or'                    => 'OPPURE',
        'password_forgotten'    => 'Password dimenticata?',
        'remember_me'           => 'Ricordami',
        'submit'                => 'Accedi',
        'title'                 => 'Accedi',
    ],
    'register'  => [
        'already_account'           => 'Hai già un account?',
        'email'                     => [
            'body'  => '<p>Benvenuto su kanka.io!</p><p>Il tuo account è stato creato usando il tuo indirizzo email.</p>',
            'login' => 'Accedi',
            'title' => 'Benvenuto su kanka.io!',
        ],
        'errors'                    => [
            'email_already_taken'   => 'Un account con questa email è già stato registrato.',
            'general_error'         => 'C\'è stato un errore durante la registrazione del tuo account. Per favore riprova.',
        ],
        'fields'                    => [
            'email'     => 'Email',
            'name'      => 'Nome Utente',
            'password'  => 'Password',
            'tos'       => 'Accetto la <a href=":privacyUrl" target="_blank">Privacy Policy</a>.',
        ],
        'register_with_facebook'    => 'Registrati con Facebook',
        'register_with_google'      => 'Registrati con Google',
        'register_with_twitter'     => 'Registrati con Twitter',
        'submit'                    => 'Registrati',
        'title'                     => 'Registrati',
        'welcome_email'             => [
            'header'        => 'Benvenuto su Kanka, :name!',
            'header_sub'    => 'Congratulazioni, hai mosso i primi passi per la creazione del tuo mondo su :kanka!',
            'section_1'     => 'E ora dove si va?',
            'section_10'    => 'Patrons',
            'section_11'    => 'Crea il tuo mondo,',
            'section_2'     => 'La risorsa più importante è :discord, dove troverai tanti nostri utenti volenterosi, un team di accoglienza, così come il fondatore di Kanka, che potrà rispondere a qualsiasi domanda che potresti voler fare.',
            'section_3'     => 'Anche la nostra :faq affronta le domande più frequenti.',
            'section_4'     => 'Il nostro canale :youtube contiene video che trattano le basi di Kanka. Sebbene non tutti gli argomenti siano ancora stati trattati, noi aggiungiamo regolarmente nuovi video.',
            'section_5'     => 'Canale Youtube',
            'section_6'     => 'Contattaci',
            'section_7'     => 'Se non hai trovato una risposta alle tue domande, o desideri semplicemente contattarci, puoi trovarci su :facebook, o puoi inviarci una email a :email. Siamo un piccolo team di due amici, ma ci assicuriamo di rispondere a ciascuna email che riceviamo, quindi non esitare!',
            'section_8'     => 'Un\'ultima cosa',
            'section_9'     => 'Ci siamo assicurati di fare in modo che tutte le funzionalità principali di Kanka siano gratuite, e rimarranno sempre così. In ogni caso, qualora tu volessi supportarci in questo progetto, puoi unirti alla nostra schiera di :patrons, e ottenere accesso a funzionalità aggiuntive, oltre che la nostra eterna gratitudine!',
            'title'         => 'Iniziare con Kanka',
        ],
    ],
    'reset'     => [
        'fields'    => [
            'email'                 => 'Indirizzo Email',
            'password'              => 'Password',
            'password_confirmation' => 'Conferma la password',
        ],
        'send'      => 'Invia il Link di Reset Password',
        'submit'    => 'Resetta la password',
        'title'     => 'Resetta la password',
    ],
    'throttle'  => 'Troppi tentativi di accesso. Riprova tra :seconds secondi.',
];
