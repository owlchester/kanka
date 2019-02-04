<?php

return [
    'account'   => [
        'actions'           => [
            'social'            => 'Vai al Login Kanka',
            'update_email'      => 'Aggiorna e-mail',
            'update_password'   => 'Aggiorna password',
        ],
        'description'       => 'Aggiorna il tuo account',
        'email'             => 'Cambia e-mail',
        'email_success'     => 'E-Mail aggiornata.',
        'password'          => 'Cambia password',
        'password_success'  => 'Password aggiornata.',
        'social'            => [
            'error'     => 'Stai già utilizzando il login Kanka per questo account.',
            'helper'    => 'Il tuo account è attualmente gestito da :provider. Puoi smettere di utilizzarlo e passare al login standard di Kanka impostando una password.',
            'success'   => 'Il tuo account ora utilizza il login Kanka.',
            'title'     => 'Social a Kanka',
        ],
        'title'             => 'Account',
    ],
    'api'       => [
        'description'           => 'Aggiorna le impostazioni delle tue API',
        'experimental'          => 'Benvenuto alle API di Kanka! Queste caratteristiche sono ancora in fase di sperimentazione ma dovrebbero essere abbastanza stabili per permetterti di incominciare a comunicare con le APIs. Crea un Token di Accesso Personale da utilizzare nelle tue richieste api o utilizza il Token del Client se vuoi che la tua app abbia accesso ai dati utente.',
        'help'                  => 'Kanka fornirà presto una RESTful API in modo che applicazioni di terze parti possano connettervisi. I dettagli su come gestire le tue chiavi API saranno mostrati qui.',
        'request_permission'    => 'Stiamo attualmente creando una potente RESTful API in modo che applicazioni di terze parti possano connettervisi. Stiamo attualmente limitando il numero di utenti che possono interagire con le API mentre le miglioriamo. Se vuoi avere accesso alle API e creare eccezionali apps che comunichino con Kanka, per favore contattaci e noi ti invieremo tutte le informazioni di cui hai bisogno.',
        'title'                 => 'API',
    ],
    'layout'    => [
        'description'   => 'Aggiorna le tue impostazioni di layout',
        'success'       => 'Impostazioni di layout aggiornate.',
        'title'         => 'Layout',
    ],
    'menu'      => [
        'account'           => 'Account',
        'api'               => 'API',
        'layout'            => 'Layout',
        'patreon'           => 'Patreon',
        'personal_settings' => 'Impostazioni Personali',
        'profile'           => 'Profilo',
    ],
    'patreon'   => [
        'actions'       => [
            'link'  => 'Collega Account',
            'view'  => 'Visita Kanka su Patreon',
        ],
        'benefits'      => 'Supportarci su Patreon fa si che tu possa caricare immagini più grandi, aiuti noi a coprire i costi del server e ci permetti di dedicare più tempo a lavorare su Kanka.',
        'description'   => 'Connetti con Patreon',
        'errors'        => [
            'invalid_token' => 'Token non valido! Patreon non può verificare la tua richiesta.',
            'missing_code'  => 'Codice mancante! Patreon non ha ritornato un codice per l\'identificazione del tuo account.',
            'no_pledge'     => 'Nessun pledge! Patreon ha riconosciuto il tuo account my non è a conoscenza di nessun pledge attivo.',
        ],
        'link'          => 'Usa questo bottone se stai attualmente supportando Kanka su :patreon. Questo sbloccherà i bonus',
        'linked'        => 'Grazie per supportare Kanka su Patreon! Il tuo account è stato collegato.',
        'pledge'        => 'Pledge: :name',
        'success'       => 'Grazie per supportare Kanka su Patreon!',
        'title'         => 'Patreon',
        'wrong_pledge'  => 'Il livello del tuo pledge è settato manualmente da noi, quindi per favore daccia fino a qualche giorno per settarlo correttamente. Se resta sbagliato per diverso tempo ti preghiamo di contattarci.',
    ],
    'profile'   => [
        'actions'       => [
            'update_profile'    => 'Aggiorna profilo',
        ],
        'avatar'        => 'Immagine del profilo',
        'description'   => 'Aggiorna il tuo profilo',
        'success'       => 'Profilo aggiornato.',
        'title'         => 'Profilo Personale',
    ],
];
