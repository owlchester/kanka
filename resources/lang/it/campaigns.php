<?php

return [
    'create'                => [
        'description'           => 'Crea una nuova campagna',
        'helper'                => [
            'first' => 'Ti ringraziamo per aver provato la nostra app! Prima di poter procedere abbiamo bisogno di una semplice cosa da te, il <b>nome della tua campagna</b>. Questo è il nome del tuo mondo e che lo separa dagli altri. Se non hai ancora un buon nome non ti preoccupare, potrai sempre <b>cambiarlo successivamente</b> o potrai creare altre campagne.',
            'second'=> 'Fin troppe chiacchere! Quindi, come sarà?',
            'title' => 'Un benvenuto a :name!',
        ],
        'success'               => 'Campagna creata.',
        'success_first_time'    => 'La tua campagna è stata creata! Siccome si tratta della tua prima campagna abbiamo provveduto a creare alcune cose per aiutarti ad iniziare e speriamo che ti possa dare un po\' di ispirazione per quello che potrai fare.',
        'title'                 => 'Nuova campagna',
    ],
    'destroy'               => [
        'success'   => 'Campagna eliminata.',
    ],
    'edit'                  => [
        'description'   => 'Modifica la tua campagna',
        'success'       => 'Campagna aggiornata.',
        'title'         => 'Modifica la campagna :campaign',
    ],
    'entity_visibilities'   => [
        'private'   => 'Le nuove entità sono private',
    ],
    'errors'                => [
        'access'        => 'Non hai accesso a questa campagna.',
        'unknown_id'    => 'Campagna sconosciuta.',
    ],
    'export'                => [
        'description'   => 'Esporta la campagna.',
        'errors'        => [
            'limit' => 'Hai superato il tuo massimo di un\'esportazione al giorno. Per favore riprova domani.',
        ],
        'helper'        => 'Esporta la tua campagna. Riceverai una notifica con il link per il download appena disponibile.',
        'success'       => 'L\'esportazione della tua campagna sta venendo preparata. Riceverai una notifica su Kanka con il link ad uno zip scaricabile non appena sarà pronto.',
        'title'         => 'Esportazione della Campagna :name',
    ],
    'fields'                => [
        'description'       => 'Descrizione',
        'entity_visibility' => 'Visibilità dell\'entità',
        'image'             => 'Immagine',
        'locale'            => 'Lingua',
        'name'              => 'Nome',
        'visibility'        => 'Visibilità',
    ],
    'helpers'               => [
        'entity_visibility' => 'Quando creerai una nuova entità, l\'opzione "Privato" sarà selezionato automaticamente.',
        'locale'            => 'La lingua in cui la tua campagna è scritta. Viene usato per generare contenuti e raggruppare le campagne pubbliche.',
        'name'              => 'Il tuo mondo/campagna può avere qualsiasi nome, basta che contenga almeno 4 lettere o numeri.',
        'visibility'        => 'Rendere pubblica una campagna significa che chiunque abbia il link può vederla.',
    ],
    'index'                 => [
        'actions'       => [
            'new'   => [
                'description'   => 'Crea una nuova campagna',
                'title'         => 'Nuova Campagna',
            ],
        ],
        'add'           => 'Nuova Campagna',
        'description'   => 'Gestisci le tue campagne',
        'list'          => 'Le tue campagne',
        'select'        => 'Seleziona una campagna',
        'title'         => 'Campagne',
    ],
    'invites'               => [
        'actions'       => [
            'add'   => 'Invita',
            'link'  => 'Nuovo collegamento',
        ],
        'create'        => [
            'button'        => 'Invita',
            'description'   => 'Invita un amico alla tua campagna',
            'link'          => 'Collegamento creato: <a href=":url" target="_blank">:url</a>',
            'success'       => 'Invito inviato.',
            'title'         => 'Invita qualcuno nella tua campagna',
        ],
        'destroy'       => [
            'success'   => 'Invito rimosso.',
        ],
        'email'         => [
            'link'      => '<a href=":link">Unisciti alla campagna di :name</a>',
            'subject'   => ':name ti ha invitato ad unirti alla sua campagna \':campaign\' su kanka.io! Usa il seguente link per accettare il suo invito.',
            'title'     => 'Invito da parte di :name',
        ],
        'error'         => [
            'already_member'    => 'Sei già un membro di questa campagna.',
            'inactive_token'    => 'Questo token è già stato utilizzato o la campagna non esiste più.',
            'invalid_token'     => 'Questo token non è più valido.',
            'login'             => 'Per favore accedi o registrati per unirti alla campagna.',
        ],
        'fields'        => [
            'created'   => 'Inviato',
            'email'     => 'E-Mail',
            'role'      => 'Ruolo',
            'type'      => 'Tipo',
            'validity'  => 'Validità',
        ],
        'helpers'       => [
            'validity'  => 'Quanti utenti possono usare questo link prima che sia disattivato.',
        ],
        'placeholders'  => [
            'email' => 'Indirizzo e-mail della persona che vorresti invitare',
        ],
        'types'         => [
            'email' => 'E-Mail',
            'link'  => 'Collegamento',
        ],
    ],
    'leave'                 => [
        'confirm'   => 'Sei sicuro di voler lasciare la campagna :name? Non potrai più accedere, a meno che il proprietario della campagna ti inviti di nuovo.',
        'error'     => 'Non puoi lasciare la campagna.',
        'success'   => 'Hai lasciato la campagna.',
    ],
    'members'               => [
        'create'        => [
            'title' => 'Aggiungi un membro alla tua campagna',
        ],
        'description'   => 'Gestisci i membri della campagna',
        'edit'          => [
            'description'   => 'Modifica un membro della tua campagna',
            'title'         => 'Modifica il membro :name',
        ],
        'fields'        => [
            'joined'    => 'Unito',
            'name'      => 'Utente',
            'role'      => 'Ruolo',
            'roles'     => 'Ruoli',
        ],
        'help'          => 'Non ci sono limiti all\'ammontare di membri che una campagna può avere, come Amministratore della campagna puoi rimuovere i membri che non sono più attivi.',
        'invite'        => [
            'description'   => 'Puoi invitare i tuoi amici nella tua campagna indicandoci i loro indirizzi e-mail. Una volta che avranno accettato il loro invito verranno aggiunti come membri nel ruolo indicato. Gli inviti inviati potranno essere cancellati in qualsiasi momento.',
            'title'         => 'Invita',
        ],
        'roles'         => [
            'member'    => 'Membro',
            'owner'     => 'Proprietario',
            'viewer'    => 'Visualizzatore',
        ],
        'title'         => 'Membri della Campagna :name',
        'your_role'     => 'Il tuo ruolo: <i>:role</i>',
    ],
    'placeholders'          => [
        'description'   => 'Un piccolo riassunto della tua campagna',
        'locale'        => 'Codice di lingua',
        'name'          => 'Il nome della tua campagna',
    ],
    'roles'                 => [
        'actions'       => [
            'add'   => 'Aggiungi un ruolo',
        ],
        'create'        => [
            'success'   => 'Ruolo creato.',
            'title'     => 'Crea un nuovo ruolo per :name',
        ],
        'description'   => 'Gestisci i ruoli per la campagna',
        'destroy'       => [
            'success'   => 'Ruolo rimosso.',
        ],
        'edit'          => [
            'success'   => 'Ruolo aggiornato.',
            'title'     => 'Modifica il ruolo :name',
        ],
        'fields'        => [
            'name'          => 'Nome',
            'permissions'   => 'Permessi',
            'type'          => 'Tipo',
            'users'         => 'Utenti',
        ],
        'helper'        => [
            '1' => 'Una campagna può avere tanti ruoli quanti ne vuoi. Il ruolo "Amministratore" ti da automaticamente accesso a tutto nella campagna, ma ogni altro ruolo può avere permessi specifici su diversi tipi di entità (personaggio, luogo, ecc)',
            '2' => 'I permessi delle entità possono essere perfezionati utilizzando la tabella "Permessi" dell\'entità. Questa tabella appare quando la tua campagna ha più ruoli o membri.',
            '3' => 'Puoi usare un sistema "opt-out", dove ai ruoli è dato il permesso di vedere tutte le entità, e usare la spunta "Privato" sull\'entità per nasconderla. Oppure puoi dare ai ruoli pochi permessi, ma impostare ogni entità come visibile.',
        ],
        'hints'         => [
            'role_permissions'  => 'Abilita il ruolo \':name\' per le seguenti funzioni su tutte le entità.',
        ],
        'members'       => 'Membri',
        'permissions'   => [
            'actions'   => [
                'add'           => 'Crea',
                'delete'        => 'Elimina',
                'edit'          => 'Modifica',
                'permission'    => 'Gestisci Permessi',
                'read'          => 'Visualizza',
            ],
            'hint'      => 'Questo ruolo ha automaticamente accesso a tutto.',
        ],
        'placeholders'  => [
            'name'  => 'Nome del ruolo',
        ],
        'show'          => [
            'description'   => 'Membri e Permessi di un ruolo della campagna',
            'title'         => 'Ruolo nella campagna \':role\'',
        ],
        'title'         => 'Ruoli della Campagna :name',
        'types'         => [
            'owner'     => 'Proprietario',
            'public'    => 'Pubblico',
            'standard'  => 'Predefinito',
        ],
        'users'         => [
            'actions'   => [
                'add'   => 'Aggiungi',
            ],
            'create'    => [
                'success'   => 'Utente aggiunto al ruolo.',
                'title'     => 'Aggiungi un membro al ruolo :name',
            ],
            'destroy'   => [
                'success'   => 'Utente rimosso da ruolo.',
            ],
            'fields'    => [
                'name'  => 'Nome',
            ],
        ],
    ],
    'settings'              => [
        'description'   => 'Abilita o disabilita moduli della campagna.',
        'edit'          => [
            'success'   => 'Impostazioni della campagna aggiornate.',
        ],
        'helper'        => 'Tutti i moduli di una campagna possono essere abilitati o disabilitati a volontà. Disabilitare un modulo nasconderà gli elementi dell\'interfaccia correlati, le entità esistenti saranno nascoste ma continueranno ad esistere, nel caso cambiassi idea. Questo cambiamento riguarda tutti i membri della campagna, inclusi i membri Amministratore.',
        'helpers'       => [
            'calendars'     => 'Un\'area dove definire i calendario del tuo mondo.',
            'characters'    => 'Le persone che abitano il tuo mondo.',
            'conversations' => 'Conversazioni fittizie tra i personaggi o gli utenti della campagna.',
            'dice_rolls'    => 'Per quelli che utilizzano Kanka per una campagna RPG, un modo per gestire i tiri di dado.',
            'events'        => 'Vacanza, festival, disastri, compleanni, guerre.',
            'families'      => 'Clan o famiglie, le loro relazioni ed io loro membri.',
            'items'         => 'Armi, veicoli, reliquie, pozioni.',
            'journals'      => 'Osservazioni scritte dai personaggi, o preparazione per le sessioni del dungeon master.',
            'locations'     => 'Pianeti, aerei, continenti, fiumi, stati, accampamenti, templi, taverne.',
            'menu_links'    => 'Collegamenti personalizzati nel menu laterale.',
            'notes'         => 'Tradizioni, religioni, storia, magia, razze.',
            'organisations' => 'Culti, unità militari, fazioni, gilde.',
            'quests'        => 'Per tener traccia di varie missioni con personaggi e luoghi.',
            'races'         => 'Se la tua campagna ha più di una razza, questo ti aiuterà a tenerne traccia facilmente.',
            'tags'          => 'Ogni entità può avere diversi tag. I tag possono appartenere ad altri tag e le entità possono essere filtrate per tag.',
        ],
        'title'         => 'Moduli della Campagna :name',
    ],
    'show'                  => [
        'actions'       => [
            'leave' => 'Abbandona campagna',
        ],
        'description'   => 'Una vista dettagliata di una campagna',
        'tabs'          => [
            'export'        => 'Esporta',
            'information'   => 'Informazioni',
            'members'       => 'Membri',
            'menu'          => 'Menù',
            'roles'         => 'Ruoli',
            'settings'      => 'Moduli',
        ],
        'title'         => 'Campagna :name',
    ],
    'visibilities'          => [
        'private'   => 'Privata',
        'public'    => 'Pubblica',
        'review'    => 'In attesa di Revisione',
    ],
];
