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
        'name'              => 'Nome',
        'visibility'        => 'Visibilità',
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
            'title' => 'Invito da parte di :name',
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
        ],
        'placeholders'  => [
            'email' => 'Indirizzo e-mail della persona che vorresti invitare',
        ],
        'types'         => [
            'email' => 'E-Mail',
            'link'  => 'Collegamento',
        ],
    ],
    'members'               => [
        'fields'    => [
            'name'  => 'Utente',
            'role'  => 'Ruolo',
            'roles' => 'Ruoli',
        ],
        'invite'    => [
            'description'   => 'Puoi invitare i tuoi amici nella tua campagna indicandoci i loro indirizzi e-mail. Una volta che avranno accettato il loro invito verranno aggiunti come membri nel ruolo indicato. Gli inviti inviati potranno essere cancellati in qualsiasi momento.',
            'title'         => 'Invita',
        ],
        'roles'     => [
            'member'    => 'Membro',
            'owner'     => 'Proprietario',
            'viewer'    => 'Visualizzatore',
        ],
        'your_role' => 'Il tuo ruolo: <i>:role</i>',
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
            'users'         => 'Utenti',
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
        ],
        'placeholders'  => [
            'name'  => 'Nome del ruolo',
        ],
        'show'          => [
            'title' => 'Ruolo nella campagna \':role\'',
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
        'helpers'       => [
            'calendars'     => 'Un\'area dove definire i calendario del tuo mondo.',
            'dice_rolls'    => 'Per quelli che utilizzano Kanka per una campagna RPG, un modo per gestire i tiri di dado.',
            'events'        => 'Vacanza, festival, disastri, compleanni, guerre.',
            'families'      => 'Clan o famiglie, le loro relazioni ed io loro membri.',
            'items'         => 'Armi, veicoli, reliquie, pozioni.',
            'locations'     => 'Pianeti, aerei, continenti, fiumi, stati, accampamenti, templi, taverne.',
            'menu_links'    => 'Collegamenti personalizzati nel menu laterale.',
            'notes'         => 'Tradizioni, religioni, storia, magia, razze.',
            'organisations' => 'Culti, unità militari, fazioni, gilde.',
            'quests'        => 'Per tener traccia di varie missioni con personaggi e luoghi.',
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
