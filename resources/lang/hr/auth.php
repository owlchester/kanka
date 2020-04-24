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

    'failed'    => 'Uneseni korisnički podaci ne odgovaraju našim zapisima.',
    'helpers'   => [
        'password'  => 'Prikaži / sakrij lozinku',
    ],
    'login'     => [
        'fields'                => [
            'email'     => 'Email',
            'password'  => 'Lozinka',
        ],
        'login_with_facebook'   => 'Prijavi se pomoću Facebook računa',
        'login_with_google'     => 'Prijavi se pomoću Google računa',
        'login_with_twitter'    => 'Prijavi se pomoću Twitter računa',
        'new_account'           => 'Registriraj novi račun',
        'or'                    => 'ILI',
        'password_forgotten'    => 'Zaboravljena lozinka?',
        'remember_me'           => 'Zapamti me',
        'submit'                => 'Prijava',
        'title'                 => 'Prijava',
    ],
    'register'  => [
        'already_account'           => 'Već imaš račun?',
        'email'                     => [
            'body'  => '<p>Dobro došao/la u kanka.io!</p><p>Tvoj račun je kreiran korištenjem tvoje email adrese.</p>',
            'login' => 'Prijavi se',
            'title' => 'Započinjanje rada s Kankom',
        ],
        'errors'                    => [
            'email_already_taken'   => 'Račun s ovom email adresom je već registriran.',
            'general_error'         => 'Dogodila se pogreška prilikom registracije. Molimo, pokušaj ponovno.',
        ],
        'fields'                    => [
            'email'     => 'Email',
            'name'      => 'Korisničko ime',
            'password'  => 'Lozinka',
            'tos'       => 'Pristajem na <a href=":privacyUrl" target="_blank">Policu privatnosti</a>.',
        ],
        'register_with_facebook'    => 'Registriraj se pomoću Facebook računa',
        'register_with_google'      => 'Registriraj se pomoću Google računa',
        'register_with_twitter'     => 'Registriraj se pomoću Twitter računa',
        'submit'                    => 'Registracija',
        'title'                     => 'Registracija',
        'welcome_email'             => [
            'header'        => 'Dobro došao/la u Kanku :name!',
            'header_sub'    => 'Čestitamo, poduzeo/la si prve korake u kreiranju svog svijeta u :kanka!',
            'section_1'     => 'Kamo sada?',
            'section_10'    => 'Pokrovitelji',
            'section_11'    => 'Kreiraj svoj svijet,',
            'section_2'     => 'Najvažniji resurs je :discord, gdje ćeš pronaći puno naših korisnika, tim za pomaganje novim korisnicima, te osnivatelja Kanke, koji može odgovoriti na bilo koje pitanje o Kanki.',
            'section_3'     => 'Naš :faq također pokriva većinu ponavljajućih pitanja.',
            'section_4'     => 'Naš :youtube ima video zapise koji objašnjavaju osnove Kanke. Iako još uvijek nisu pokrivene sve teme, redovito dodajemo nove video zapise.',
            'section_5'     => 'Youtube kanal',
            'section_6'     => 'Kontaktiraj nas',
            'section_7'     => 'Ako nisi pronašao/la odgovor na pitanje ili jednostavno želiš stupiti u kontakt, možeš nas pronaći na :facebook ili nam možeš poslati email na :email. Mi smo mali tim od 2 prijatelja, ali se trudimo odgovarati na svaki email koji primimo, tako da se nemoj ustručavati!',
            'section_8'     => 'Još jedna stvar',
            'section_9'     => 'Pobrinuli smo se da su sve osnovne funkcionalnosti u Kanki besplatne, i tako će uvijek i biti. Međutim, ako želiš podržati ovaj projekt, možeš se priključiti našim :patrons, i dobiti pristup dodatnim funkcionalnostima te našu vječnu zahvalnost!',
            'title'         => 'Započinjanje rada s Kankom',
        ],
    ],
    'reset'     => [
        'fields'    => [
            'email'                 => 'Email adresa',
            'password'              => 'Lozinka',
            'password_confirmation' => 'Potvrdi svoju lozinku',
        ],
        'send'      => 'Pošalji poveznicu za ponovno postavljanje lozinke',
        'submit'    => 'Ponovno postavi lozinku',
        'title'     => 'Ponovi lozinku',
    ],
    'throttle'  => 'Previše pokušaja prijave. Molim, pokušaj ponovno za :seconds sekundi.',
];
