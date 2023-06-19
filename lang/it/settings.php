<?php

return [
    'account'       => [
        '2fa'               => [
            'actions'               => [
                'disable'   => 'Disattiva l\'identificazione a due fattori',
                'finish'    => 'Finisci la configurazione e accedi',
            ],
            'activation_helper'     => 'Per completare la configurazione dell\'identificazione a due fattori per il tuo account, segui le seguenti istruzioni.',
            'disable'               => [
                'helper'    => 'Se vuoi disabilitare l\'identificazione a due fattori, clicca sul tasto qui sotto. Tieni a mente che ciò può rendere il tuo account vulnerabile verso chi conosce le tue informazioni di accesso.',
                'title'     => 'Disattiva l\'identificazione a due fattori',
            ],
            'enable_instructions'   => 'Per iniziare il processo di attivazione, genera il QR code della tua autentificazione, scansionalo con Google Authenticator App (:ios, :android), o altre app di identificazione simili.',
            'enabled'               => 'L\'identificazione a due fattori al momento è abilitata sul tuo account.',
            'error_enable'          => 'Codice non valido, prova di nuovo',
            'fields'                => [
                'otp'       => 'Immetti la One Time Password (OTP) fornita dall\'app di autenticazione',
                'qrcode'    => 'Scansiona il seguente QR code con un\'app di autentificazione per generare una One Time Password (OTP)',
            ],
            'generate_qr'           => 'Genera un QR code',
            'helper'                => 'L\'identificazione a due fattori (2FA) rafforza la sicurezza richiedendo due metodi (anche detti fattori) durante l\'accesso per verificare la propria identità ad ogni login.',
            'learn_more'            => 'Scopri di più sull\'identificazione a due fattori',
            'social'                => 'L\'identificazione a due fattori di Kanka è abilitata per gli utenti che accedono usando la propria e-mail e password. Cambia il tuo metodo di accesso nelle impostazioni dell\'account  per poter abilitare questa funzionalità.',
            'success_disable'       => 'L\'identificazione a due fattori è stata disabilitata con successo.',
            'success_enable'        => 'L\'identificazione a due fattori è stata abilitata con successo. Per favore, accedi al tuo account per completare la configurazione.',
            'success_key'           => 'Il tuo QR code sicuro è stato generato con successo. Per favore, completa la configurazione per attivare l\'identificazione a due fattori.',
            'title'                 => 'Identificazione a due fattori',
        ],
        'actions'           => [
            'social'            => 'Vai al Login Kanka',
            'update_email'      => 'Aggiorna e-mail',
            'update_password'   => 'Aggiorna password',
        ],
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
    'api'           => [
        'helper'    => 'Benvenuti sull\'APIs di Kanka. Genera un gettone di Accesso Personalizzato per usare la tua richiesta API per raccogliere informazioni riguardo le campagne a cui partecipi.',
        'link'      => 'Leggi la documentazione delle API',
        'title'     => 'API',
    ],
    'apps'          => [
        'actions'   => [
            'connect'   => 'Connetti',
            'remove'    => 'Rimuovi',
        ],
        'benefits'  => 'Kanka utilizza alcune integrazioni fornite da servizi di terze parti. Maggiori integrazioni sono previste per il futuro.',
        'discord'   => [
            'confirm'   => 'Sei sicuro di voler disconnettere il tuo account da Discord? Tale azione rimuoverà qualunque ruolo a cui eri sincronizzato.',
            'errors'    => [
                'add'   => 'Si è verificato un errore durante la sincronizzazione fra il tuo account Discord e Kanka. Per favore, riprova. Se il problema dovesse persistere, ricorda che Discord ha un limite di 100 server aggiunti mentre usi le loro APIs.',
            ],
            'success'   => [
                'add'       => 'Il tuo account Discord è stato collegato.',
                'remove'    => 'Il tuo account Discord è stato scollegato.',
            ],
            'text'      => 'Collega il tuo account Discord a Kanka per accedere automaticamente al tuo abbonamento e ai tuoi canali privati.',
            'unlock'    => 'Sblocca i ruoli di Discord',
        ],
        'title'     => 'Integrazioni App',
    ],
    'billing'       => [
        'placeholder'   => 'Se hai bisogno di aggiungere ulteriori informazioni di contatto o sulle tasse alle tue ricevute (indirizzo commerciale, IVA ecc.), scrivilo qui sotto e apparirà nella ricevuta.',
        'save'          => 'Salva le informazioni di pagamento',
        'title'         => 'Informazioni di pagamento',
    ],
    'boost'         => [
        'exceptions'    => [
            'already_boosted'       => 'La campagna :nome è stata già potenziata.',
            'exhausted_boosts'      => 'Non hai più potenziamenti da dare. Rimuovi un potenziamento da una campagna prima di darlo ad un\'altra.',
            'exhausted_superboosts' => 'Non hai più potenziamenti. Hai bisogno di tre potenziamenti per potenziare una campagna.',
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
        'title' => 'Layout',
    ],
    'menu'          => [
        'account'               => 'Account',
        'api'                   => 'API',
        'appearance'            => 'Aspetto',
        'apps'                  => 'Applicazioni',
        'boosters'              => 'Potenziamenti',
        'notifications'         => 'Notifiche',
        'other'                 => 'Altro',
        'patreon'               => 'Patreon',
        'payment_options'       => 'Opzioni di pagamento',
        'personal_settings'     => 'Impostazioni Personali',
        'premium'               => 'Campagne Premium',
        'profile'               => 'Profilo',
        'settings'              => 'Impostazioni',
        'subscription'          => 'Abbonamento',
        'subscription_status'   => 'Stato dell\'abbonamento',
    ],
    'patreon'       => [
        'deprecated'    => 'Funzionalità disattivata - se desideri supportare Kanka, per favore fallo tramite un :abbonamento. Il collegamento con Patreon è ancora attivo per coloro che lo avevano collegato prima dell\'abbandono di Patreon.',
        'pledge'        => 'Pledge: :name',
        'remove'        => [
            'button'    => 'Scollega il tuo account Patreon',
            'success'   => 'Il tuo account Patreon è stato scollegato.',
            'text'      => 'La disconnessione del tuo account Patreon da Kanka rimuoverà i tuoi bonus, il tuo nome nella hall of fame, i boost delle campagne e altre funzioni legate al supporto di Kanka. Nessuno dei tuoi contenuti potenziati andrà perduto (ad esempio, le intestazioni delle entità). Iscrivendosi di nuovo, avrai accesso a tutti i dati precedenti, compresa la possibilità di sbloccare le campagne precedentemente premium.',
            'title'     => 'Scollega il tuo account Patreon da Kanka',
        ],
        'title'         => 'Patreon',
    ],
    'profile'       => [
        'actions'   => [
            'update_profile'    => 'Aggiorna profilo',
        ],
        'avatar'    => 'Immagine del profilo',
        'success'   => 'Profilo aggiornato.',
        'title'     => 'Profilo Personale',
    ],
    'subscription'  => [
        'actions'               => [
            'cancel_sub'        => 'Cancella abbonamento',
            'subscribe'         => 'Abbonati',
            'update_currency'   => 'Salva valuta di fatturazione',
        ],
        'billing'               => [
            'helper'    => 'I dati di fatturazione vengono elaborati e conservati in modo sicuro tramite :stripe. Questo metodo di pagamento viene utilizzato per tutti i tuoi abbonamenti.',
            'saved'     => 'Metodo di pagamento salvato',
        ],
        'cancel'                => [
            'options'   => [
                'competitor'        => 'Ho deciso di passare alla concorrenza',
                'financial'         => 'L\'abbonamento è troppo costoso',
                'missing_features'  => 'Mancanza di alcune funzionalità',
                'not_for'           => 'L\'abbonamento non fa per me',
                'not_using'         => 'Al momento non uso Kanka',
                'other'             => 'Altro',
            ],
            'text'      => 'Ci dispiace vederti andare via! Il tuo abbonamento resterà attivo fino a :date, dopodiché perderai i potenziamenti alla tua campagna e gli altri vantaggi relativi al tuo sostegno verso Kanka. Ti preghiamo di compilare il seguente modulo per permetterci di migliorare e per capire i motivi della tua decisione.',
        ],
        'cancelled'             => 'Il tuo abbonamento è stato cancellato. Puoi rinnovarlo dopo che il tuo abbonamento corrente sarà scaduto in :date.',
        'change'                => [
            'text'  => [
                'monthly'   => 'Stai sottoscrivendo l\'abbonamento per il :grado grado, da pagare mensilmente in cifra pari a :amount.',
                'yearly'    => 'Stai sottoscrivendo l\'abbonamento per il :grado grado, da pagare annulamente in cifra pari a :amount.',
            ],
            'title' => 'Cambia grado di abbonamento',
        ],
        'coupon'                => [
            'check'         => 'Controlla un codice promozionale',
            'invalid'       => 'Codice promozionale non valido.',
            'label'         => 'Codice promozionale',
            'percent_off'   => 'Ti faremo uno sconto sul tuo primo abbonamento annuale pari al :percent%!',
        ],
        'currencies'            => [
            'eur'   => 'EUR',
            'usd'   => 'USD',
        ],
        'currency'              => [
            'title' => 'Cambia la tua valuta di fatturazione preferita',
        ],
        'errors'                => [
            'callback'      => 'Il nostro gestore dei pagamenti ha segnalato un errore. Per favore, riprova o contattaci se il problema persiste.',
            'failed'        => 'Attualmente si stanno verificando problemi con il nostro sistema di fatturazione. Contattateci all\'indirizzo :email per ricevere assistenza.',
            'subscribed'    => 'Non è stato possibile elaborare l\'abbonamento. Stripe ha fornito il seguente suggerimento.',
        ],
        'fields'                => [
            'active_since'      => 'Attivo da',
            'active_until'      => 'Attivo fino',
            'billing'           => 'Fatturazione',
            'currency'          => 'Valuta di Fatturazione',
            'payment_method'    => 'Metodo di pagamento',
            'plan'              => 'Piano attuale',
            'reason'            => 'Motivo',
        ],
        'helpers'               => [
            'alternatives'          => 'Paga il tuo abbonamento con :method. Questo metodo di pagamento non si rinnova automaticamente alla fine dell\'abbonamento. :method è disponibile solo in euro.',
            'alternatives-2'        => 'Paga il tuo abbonamento con :method. Si tratta di un pagamento unico che non si rinnova automaticamente alla fine dell\'abbonamento.',
            'alternatives_warning'  => 'Non è possibile aggiornare l\'abbonamento utilizzando questo metodo. Per favore, sottoscrivi nuovamente l\'abbonamento al termine di quello attuale.',
            'alternatives_yearly'   => 'Accettiamo abbonamenti annuali solo con :method',
            'currency_blocked'      => 'Non puoi cambiare valuta dopo aver sottoscritto un abbonamento attivo a Kanka. Contattaci all\'indirizzo :email per ricevere assistenza.',
            'paypal'                => 'Vuoi invece utilizzare Paypal? Contattaci a :email se desideri sottoscrivere un piano annuale utilizzando Paypal.',
            'paypal_v2'             => 'Accettiamo PayPal per gli abbonamenti annuali. Contattaci all\'indirizzo :e-mail indicando l\'e-mail del vostro account Kanka, il livello a cui desideri abbonarti e la valuta (USD o EUR) in cui desideri essere fatturato.',
            'paypal_v3'             => 'Paga in sicurezza per il tuo abbonamento annuale con PayPal.',
            'stripe'                => 'I dati di fatturazione vengono elaborati e conservati in modo sicuro tramite :stripe.',
        ],
        'manage_subscription'   => 'Gestisci l\'abbonamento',
        'payment_method'        => [
            'actions'       => [
                'add'               => 'Aggiungi',
                'add_new'           => 'Aggiungi un nuovo metodo di pagamento',
                'change'            => 'Cambia il metodo di pagamento',
                'save'              => 'Salva il metodo di pagamento',
                'show_alternatives' => 'Opzioni di pagamento alternative',
            ],
            'add_one'       => 'Non hai attualmente metodi di pagamento salvati.',
            'alternatives'  => 'Puoi abbonarti utilizzando queste opzioni di pagamento alternative. In questo modo si addebiterà il conto una volta sola e non si rinnoverà automaticamente l\'abbonamento ogni mese.',
            'card'          => 'Carta',
            'card_name'     => 'Nome sulla carta',
            'country'       => 'Stato di residenza',
            'ending'        => 'Che finisce in',
            'helper'        => 'Questa carta verrà usata in tutti i tuoi abbonamenti.',
            'new_card'      => 'Aggiungi un nuovo metodo di pagamento',
            'saved'         => ':brand **** :last4',
        ],
        'periods'               => [
            'monthly'   => 'Mensilmente',
            'yearly'    => 'Annualmente',
        ],
        'placeholders'          => [
            'downgrade_reason'  => 'Indica, se desideri, il motivo del declassamento dell\'abbonamento.',
            'reason'            => 'Indica, se desideri, il motivo per cui non supporti più Kanka. Mancava una funzione specifica? La tua situazione finanziaria è cambiata?',
        ],
        'plans'                 => [
            'cost_monthly'  => ':currency :amount fatturati mensilmente',
            'cost_yearly'   => ':currency :amount fatturati annualmente',
        ],
        'sub_status'            => 'Informazioni sull\'abbonamento',
        'subscription'          => [
            'actions'   => [
                'cancel'            => 'Cancella l\'abbonamento',
                'downgrading'       => 'Per favore, contattaci per il declassamento',
                'rollback'          => 'Cambia a Coboldo',
                'subscribe'         => 'Cambia a :tier mensilmente',
                'subscribe_annual'  => 'Cambia a :tier annualmente',
            ],
        ],
        'success'               => [
            'alternative'   => 'Il pagamento è stato registrato. Riceverai una notifica non appena il pagamento sarà stato elaborato e l\'abbonamento sarà attivo.',
            'callback'      => 'L\'abbonamento è andato a buon fine. L\'account verrà aggiornato non appena il nostro fornitore di pagamenti ci informerà della modifica (potrebbero essere necessari alcuni minuti).',
            'cancel'        => 'L\'abbonamento è stato annullato. Continuerà a essere attivo fino alla fine del periodo di fatturazione corrente.',
            'currency'      => 'L\'impostazione della valuta preferita è stata aggiornata.',
            'subscribed'    => 'La tua iscrizione è andata a buon fine! Non dimenticarti di iscriverti alla newsletter del Voto della Comunità per essere avvisato quando inizia una nuova votazione. Inoltre, puoi dare un\'occhiata al nostro discord e diventarne parte!',
        ],
        'tiers'                 => 'Livelli di Abbonamento',
        'trial_period'          => 'Gli abbonamenti annuali hanno una durata di annullamento di 14 giorni. Contattaci all\'indirizzo :email se desideri cancellare il tuo abbonamento annuale e ottenere un rimborso.',
        'upgrade_downgrade'     => [
            'button'    => 'Informazioni su Potenziamenti e Declassamenti',
            'cancel'    => [
                'bullets'   => [
                    'bonuses'   => 'I bonus rimangono abilitati fino alla fine del periodo di pagamento.',
                    'boosts'    => 'Lo stesso accade per le campagne potenziate. Le funzioni potenziate diventano invisibili, ma non vengono eliminate quando una campagna non è più potenziata.',
                    'kobold'    => 'Per annullare l\'abbonamento, cambialo al livello Coboldo.',
                    'premium'   => 'Lo stesso accade per le campagne premium. Le funzioni premium diventano invisibili, ma non vengono eliminate quando una campagna non è più premium.',
                ],
                'title'     => 'Quando cancelli il tuo abbonamento',
            ],
            'downgrade' => [
                'bullets'           => [
                    'end'   => 'Il livello attuale rimarrà attivo fino alla fine del ciclo di fatturazione in corso, dopodiché verrai declassato al tuo nuovo livello.',
                ],
                'provide_reason'    => 'Se desideri, spiegaci perché stai declassando il tuo abbonamento.',
                'title'             => 'Quando declassi a un livello inferiore',
            ],
            'upgrade'   => [
                'bullets'   => [
                    'immediate' => 'Il metodo di pagamento verrà addebitato immediatamente e avrai accesso al nuovo livello.',
                    'prorate'   => 'Quando potenzi da Orsogufo a Elementale, ti verrà addebitata solo la differenza rispetto al nuovo livello.',
                ],
                'title'     => 'Quando potenzi a un livello superiore',
            ],
        ],
        'warnings'              => [
            'incomplete'    => 'Non è stato possibile addebitare la carta di credito. Ti preghiamo di aggiornare i dati della tua carta di credito e riproveremo ad addebitarla nei prossimi giorni. Se l\'operazione non dovesse andare a buon fine, l\'abbonamento verrà annullato.',
            'patreon'       => 'Il tuo account è attualmente collegato a Patreon. Per favore, scollega il tuo account nelle impostazioni di :patreon prima di passare a un abbonamento a Kanka.',
        ],
    ],
];
