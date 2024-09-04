<?php

return [
    'account'       => [
        '2fa'               => [
            'actions'               => [
                'disable'   => 'Disattiva l\'autenticazione a due fattori',
                'finish'    => 'Termina la configurazione e accedi',
            ],
            'activation_helper'     => 'Per completare la configurazione dell\'autenticazione a due fattori del tuo account, segui queste istruzioni.',
            'disable'               => [
                'helper'    => 'Se desideri disattivare l\'autenticazione a due fattori, fai clic sul pulsante sottostante. Tieni presente che in questo modo il tuo account sarà vulnerabile a chiunque conosca i tuoi dati di accesso.',
                'title'     => 'Disattiva l\'autenticazione a due fattori',
            ],
            'enable_instructions'   => 'Per avviare il processo di attivazione, genera il codice QR di autenticazione, poi scansionalo nell\'app Google Authenticator (:ios, :android) o in un\'altra app simile di autenticazione.',
            'enabled'               => 'L\'autenticazione a due fattori è attualmente abilitata sul tuo account.',
            'error_enable'          => 'Codice Invalido, prova di nuovo',
            'fields'                => [
                'otp'       => 'Inserisci la Password Una Tantum (OTP) fornita dall\'app di autenticazione',
                'qrcode'    => 'Scansiona il seguente codice QR con l\'app di autenticazione per generare una Password Una Tantum (OTP).',
            ],
            'generate_qr'           => 'Genera codice QR',
            'helper'                => 'L\'autenticazione a due fattori (2FA) rafforza la sicurezza dell\'accesso richiedendo due metodi (detti anche fattori) per verificare la tua identità a ogni accesso.',
            'learn_more'            => 'Per saperne di più sull\'autenticazione a due fattori.',
            'social'                => 'L\'autenticazione a due fattori di Kanka è abilitata solo per gli utenti che effettuano il login utilizzando l\'e-mail e la password. Modifica il metodo di accesso nelle impostazioni dell\'account prima di poter abilitare questa opzione.',
            'success_disable'       => 'L\'autenticazione a due fattori è stata disattivata con successo.',
            'success_enable'        => 'L\'autenticazione a due fattori è stata attivata con successo. Accedi nuovamente per completare la configurazione.',
            'success_key'           => 'Il codice QR sicuro è stato generato con successo. Completa la configurazione per attivare l\'autenticazione a due fattori.',
            'title'                 => 'Autenticazione a Due Fattori',
        ],
        'actions'           => [
            'social'            => 'Passa al login di Kanka',
            'update_email'      => 'Aggiorna email',
            'update_password'   => 'Aggiorna password',
        ],
        'email'             => 'Cambia email',
        'email_success'     => 'Email aggiornata.',
        'password'          => 'Cambia password',
        'password_success'  => 'Password modificata.',
        'social'            => [
            'error'     => 'Stai già utilizzando il login Kanka per questo account.',
            'helper'    => 'Il tuo account è attualmente gestito da :provider. Puoi smettere di usarlo e passare al login standard di Kanka impostando una password.',
            'success'   => 'Il tuo account ora utilizza il login di Kanka.',
            'title'     => 'Social per Kanka',
        ],
        'title'             => 'Account',
    ],
    'api'           => [
        'helper'    => 'Benvenuto nelle API di Kanka. Genera un token di accesso personale da utilizzare nella tua richiesta API per raccogliere informazioni sulle campagne di cui fai parte.',
        'link'      => 'Leggi la documentazione API',
        'title'     => 'API',
    ],
    'apps'          => [
        'actions'   => [
            'connect'   => 'Connetti',
            'remove'    => 'Rimuovi',
        ],
        'benefits'  => 'Kanka offre alcune integrazioni con servizi di terze parti. Altre integrazioni di terze parti sono previste per il futuro.',
        'discord'   => [
            'confirm'   => 'Sei sicuro di voler disconnettere il tuo account da Discord? Questo rimuoverà tutti i ruoli con cui sei stato sincronizzato.',
            'errors'    => [
                'add'   => 'Si è verificato un errore nel collegamento del tuo account Discord con Kanka. Riprova. Se continua a verificarsi questo problema, tieni presente che Discord ha un limite di 100 server collegati quando si utilizzano le sue API.',
            ],
            'success'   => [
                'add'       => 'Il tuo account Discord è stato collegato.',
                'remove'    => 'Il tuo account Discord è stato scollegato.',
            ],
            'text'      => 'Collega il tuo account Discord a Kanka per ottenere automaticamente l\'accesso ai ruoli di abbonamento e ai canali privati.',
            'unlock'    => 'Sblocca ruoli Discord',
        ],
        'title'     => 'Integrazione App',
    ],
    'billing'       => [
        'placeholder'   => 'Se desideri aggiungere ulteriori informazioni di contatto o fiscali alle tue ricevute (indirizzo dell\'azienda, numero di partita IVA, ecc.), inseriscile qui sotto e appariranno su tutte le tue ricevute.',
        'save'          => 'Salva le informazioni di fattura',
        'title'         => 'Informazioni di Fattura',
    ],
    'boost'         => [
        'exceptions'    => [
            'already_boosted'       => 'La campagna :name è stata già potenziata.',
            'exhausted_boosts'      => 'Hai finito i potenziamenti da dare. Rimuovi il potenziamento da una campagna prima di darlo a un\'altra.',
            'exhausted_superboosts' => 'Hai finito i potenziamenti. Sono necessari 3 potenziamenti per superpotenziare una campagna.',
        ],
    ],
    'countries'     => [
        'austria'       => 'Austria',
        'belgium'       => 'Belgio',
        'france'        => 'Francia',
        'germany'       => 'Germania',
        'italy'         => 'Italia',
        'netherlands'   => 'Paesi Bassi',
        'spain'         => 'Spagna',
    ],
    'layout'        => [
        'title' => 'Configurazione',
    ],
    'menu'          => [
        'account'               => 'Account',
        'api'                   => 'API',
        'appearance'            => 'Aspetto',
        'apps'                  => 'App',
        'boosters'              => 'Potenziamenti',
        'notifications'         => 'Notifiche',
        'other'                 => 'Altro',
        'patreon'               => 'Patreon',
        'payment_options'       => 'Opzioni di Pagamento',
        'personal_settings'     => 'Impostazioni Personali',
        'premium'               => 'Campagne Premium',
        'profile'               => 'Profilo Pubblico',
        'settings'              => 'Impostazioni',
        'subscription'          => 'Abbonamento',
        'subscription_status'   => 'Stato di Abbonamento',
    ],
    'patreon'       => [
        'deprecated'    => 'Funzionalità disattivata - se desideri supportare Kanka, per favore fallo tramite un :subscription. Il collegamento con Patreon è ancora attivo per coloro che lo avevano collegato prima dell\'abbandono di Patreon.',
        'pledge'        => 'Contributo :name',
        'remove'        => [
            'button'    => 'Scollega il tuo account Patreon',
            'success'   => 'Il tuo account Patreon è stato scollegato.',
            'text'      => 'Scollegare il tuo account Patreon da Kanka rimuoverà i tuoi bonus, il tuo nome nella Sala delle Glorie, i potenziamenti delle campagne e altre caratteristiche legate al supporto di Kanka. Nessuno dei tuoi contenuti potenziati andrà perduto (ad esempio, le intestazioni delle entità). Iscrivendosi di nuovo, avrai accesso a tutti i dati precedenti, compresa la possibilità di sbloccare le campagne precedentemente premium.',
            'title'     => 'Scollega il tuo account Patreon da Kanka',
        ],
        'title'         => 'Patreon',
    ],
    'profile'       => [
        'actions'   => [
            'update_profile'    => 'Aggiorna profilo',
        ],
        'avatar'    => 'Immagine del Profilo',
        'success'   => 'Profilo aggiornato.',
        'title'     => 'Profilo Pubblico',
    ],
    'subscription'  => [
        'actions'               => [
            'cancel_sub'        => 'Cancella abbonamento',
            'subscribe'         => 'Abbonati',
            'update_currency'   => 'Salva la valuta di fatturazione',
        ],
        'billing'               => [
            'helper'    => 'I dati di fatturazione vengono elaborati e conservati in modo sicuro tramite :stripe. Questo metodo di pagamento viene utilizzato per tutti gli abbonamenti.',
            'saved'     => 'Metodo di pagamento salvato',
        ],
        'cancel'                => [
            'options'   => [
                'competitor'        => 'Passo a un sito concorrente',
                'financial'         => 'L\'abbonamento è troppo costoso',
                'missing_features'  => 'Funzioni mancanti',
                'not_for'           => 'L\'abbonamento non fa per me',
                'not_playing'       => 'Non gioco/scrivo più o la campagna è in pausa',
                'not_using'         => 'Non uso Kanka al momento',
                'other'             => 'Altro',
            ],
            'text'      => 'Siamo spiacenti di vederti andare via! L\'annullamento dell\'abbonamento lo manterrà attivo fino a :date, dopodiché perderà i potenziamenti delle campagne e gli altri vantaggi legati al sostegno di Kanka. Non esitare a compilare il seguente modulo per informarci su cosa possiamo fare di meglio o su cosa ti ha portato a prendere questa decisione.',
        ],
        'cancelled'             => 'L\'abbonamento è stato annullato. Puoi rinnovare l\'abbonamento una volta che l\'abbonamento attuale scade dopo la data :date.',
        'change'                => [
            'text'  => [
                'monthly'   => 'Stai sottoscrivendo l\'abbonamento per il grado :tier, da pagare mensilmente in cifra pari a :amount.',
                'yearly'    => 'Stai sottoscrivendo l\'abbonamento per il grado :tier, da pagare annualmente in cifra pari a :amount.',
            ],
            'title' => 'Cambia Grado di Abbonamento',
        ],
        'coupon'                => [
            'check'         => 'controlla il codice promozionale',
            'invalid'       => 'Codice promozionale invalido',
            'label'         => 'Codice promozionale',
            'percent_off'   => 'Sconteremo il tuo primo abbonamento annuale del :percent%!',
        ],
        'currencies'            => [
            'eur'   => 'EUR',
            'usd'   => 'USD',
        ],
        'currency'              => [
            'title' => 'Cambia la valuta di fatturazione preferita',
        ],
        'errors'                => [
            'callback'      => 'Il nostro fornitore di pagamenti ha segnalato un errore. Riprova per favore, o contattaci se il problema persiste.',
            'failed'        => 'Attualmente si stanno verificando problemi con il nostro sistema di fatturazione. Contattaci all\'indirizzo :email per ricevere assistenza.',
            'subscribed'    => 'Non è stato possibile elaborare l\'abbonamento. Stripe ha fornito il seguente suggerimento.',
        ],
        'fields'                => [
            'active_since'      => 'Attivo da',
            'active_until'      => 'Attivo fino',
            'billing'           => 'Fatturazione',
            'currency'          => 'Valuta di Fatturazione',
            'payment_method'    => 'Metodo di pagamento',
            'plan'              => 'Piano attuale',
            'reason'            => 'Motivazione',
        ],
        'helpers'               => [
            'alternatives'          => 'Paga l\'abbonamento con il metodo :method. Questo metodo di pagamento non si rinnova automaticamente alla fine dell\'abbonamento. :method è disponibile solo in euro.',
            'alternatives-2'        => 'Paga il tuo abbonamento usando :method. Si tratta di un pagamento unico che non si rinnova automaticamente alla fine dell\'abbonamento.',
            'alternatives_warning'  => 'Non è possibile aggiornare l\'abbonamento utilizzando questo metodo. Sottoscrivi nuovamente l\'abbonamento al termine di quello attuale.',
            'alternatives_yearly'   => 'Accettiamo abbonamenti annuali solo con :method',
            'paypal_v3'             => 'Paga in tutta sicurezza il tuo abbonamento annuale con PayPal.',
            'stripe'                => 'I dati di fatturazione vengono elaborati e conservati in modo sicuro tramite :stripe.',
        ],
        'manage_subscription'   => 'Gestisci abbonamento',
        'payment_method'        => [
            'actions'       => [
                'add'               => 'Aggiungi',
                'add_new'           => 'Aggiungi nuovo metodo di pagamento',
                'change'            => 'Cambia metodo di pagamento',
                'save'              => 'Salva metodo di pagamento',
                'show_alternatives' => 'Metodi di pagamento alternativi',
            ],
            'add_one'       => 'Non hai attualmente metodi di pagamento salvati.',
            'alternatives'  => 'Puoi abbonarti utilizzando queste opzioni di pagamento alternative. Questa azione addebiterà il conto una volta sola e non rinnoverà automaticamente l\'abbonamento ogni mese.',
            'card'          => 'Carta',
            'card_name'     => 'Nome sulla carta',
            'country'       => 'Nazione di residenza',
            'ending'        => 'Che finisce con',
            'helper'        => 'Questa carta verrà usata per tutti i tuoi abbonamenti.',
            'new_card'      => 'Aggiungi un nuovo metodo di pagamento',
            'saved'         => ':brand **** :last4',
        ],
        'periods'               => [
            'monthly'   => 'Mensilmente',
            'yearly'    => 'Annualmente',
        ],
        'placeholders'          => [
            'downgrade_reason'  => 'Indica facoltativamente il motivo del declassamento dell\'abbonamento.',
            'reason'            => 'Indica facoltativamente il motivo per cui non supporti più Kanka. Mancava una funzione? La tua situazione finanziaria è cambiata?',
        ],
        'plans'                 => [
            'cost_monthly'  => ':currency :amount fatturati mensilmente',
            'cost_yearly'   => ':currency :amount fatturati annualmente',
        ],
        'sub_status'            => 'Informazioni di abbonamento',
        'subscription'          => [
            'actions'   => [
                'cancel'            => 'Cancella abbonamento',
                'downgrading'       => 'Si prega di contattarci per il declassamento',
                'rollback'          => 'Cambia a Coboldo',
                'subscribe'         => 'Cambia a :tier mensilmente',
                'subscribe_annual'  => 'Cambia a :tier annualmente',
            ],
        ],
        'success'               => [
            'alternative'   => 'Il pagamento è stato registrato. Riceverai una notifica non appena il pagamento sarà stato elaborato e l\'abbonamento sarà attivo.',
            'callback'      => 'La sottocrizione dell\'abbonamento è andata a buon fine. L\'account verrà aggiornato non appena il nostro fornitore di pagamenti ci informerà della modifica (potrebbero essere necessari alcuni minuti).',
            'cancel'        => 'L\'abbonamento è stato annullato. Continuerà a essere attivo fino alla fine del periodo di fatturazione corrente.',
            'currency'      => 'L\'impostazione della valuta preferita è stata aggiornata.',
            'subscribed'    => 'La tua iscrizione è andata a buon fine! Non dimenticarti di iscriverti alla newsletter del Community Vote per essere avvisato quando una votazione viene effettuata. Inoltre, puoi dare un\'occhiata al nostro discord e diventare parte della comunità',
        ],
        'tiers'                 => 'Gradi di Abbonamento',
        'trial_period'          => 'Gli abbonamenti annuali prevedono una politica di cancellazione di 14 giorni. Contattaci all\'indirizzo :email se desideri cancellare il vostro abbonamento annuale e ottenere un rimborso.',
        'upgrade_downgrade'     => [
            'button'    => 'Informazioni su Potenziamenti e Declassamenti',
            'cancel'    => [
                'bullets'   => [
                    'bonuses'   => 'I bonus rimangono abilitati fino alla fine del periodo di pagamento.',
                    'boosts'    => 'Lo stesso accade per le campagne potenziate. Le funzioni potenziate diventano invisibili, ma non vengono eliminate quando una campagna non è più potenziata.',
                    'kobold'    => 'Per annullare l\'abbonamento passa al grado Coboldo.',
                    'premium'   => 'Lo stesso accade per le campagne premium. Le funzioni premium diventano invisibili, ma non vengono eliminate quando una campagna non è più premium.',
                ],
                'title'     => 'Quando cancelli il tuo abbonamento',
            ],
            'downgrade' => [
                'bullets'           => [
                    'end'   => 'Il livello attuale rimarrà attivo fino alla fine del ciclo di fatturazione in corso, dopodiché verrai declassato al nuovo livello.',
                ],
                'provide_reason'    => 'Se è possibile, spiegaci il motivo del declassamento dell\'abbonamento.',
                'title'             => 'Quando declassi a un grado inferiore',
            ],
            'upgrade'   => [
                'bullets'   => [
                    'immediate' => 'Il metodo di pagamento verrà addebitato immediatamente e avrai accesso al nuovo grado.',
                    'prorate'   => 'Quando passi da Orsogufo a Elementale, ti verrà addebitata solo la differenza rispetto al nuovo grado.',
                ],
                'title'     => 'Quando passi a un grado superiore',
            ],
        ],
        'warnings'              => [
            'incomplete'    => 'Non è stato possibile addebitare la carta di credito. Ti preghiamo di aggiornare i dati della tua carta di credito e riproveremo ad addebitarla nei prossimi giorni. Se l\'operazione non dovesse andare a buon fine, l\'abbonamento verrà annullato.',
            'patreon'       => 'Il tuo account è attualmente collegato a Patreon. Per favore, scollega il tuo account nelle impostazioni di :patreon prima di passare a un abbonamento a Kanka.',
        ],
    ],
];
