<?php

return [
    'actions'                           => [],
    'create'                            => [
        'success'   => 'Campagna creata.',
        'title'     => 'Nuova campagna',
    ],
    'destroy'                           => [],
    'edit'                              => [
        'success'   => 'Campagna aggiornata.',
    ],
    'entity_personality_visibilities'   => [
        'private'   => 'I nuovi personaggi hanno la loro personalità privata in maniera predefinita.',
    ],
    'entity_visibilities'               => [
        'private'   => 'Le nuove entità sono private',
    ],
    'errors'                            => [
        'access'        => 'Non hai accesso a questa campagna.',
        'premium'       => 'Questa funzione è disponibile solo per le campagne premium.',
        'unknown_id'    => 'Campagna Sconosciuta.',
    ],
    'export'                            => [],
    'fields'                            => [
        'boosted'                           => 'Potenziata da',
        'character_personality_visibility'  => 'Visibilità della personalità del personaggio predefinita',
        'connections'                       => 'Mostra i legami dell\'entità in modo predefinito (invece dell\'esploratore delle relazioni per le campagne potenziate)',
        'css'                               => 'CSS',
        'description'                       => 'Descrizione',
        'entity_count'                      => 'Numero di Entità',
        'entity_privacy'                    => 'Privacy predefinita per nuova entità',
        'entry'                             => 'Descrizione della Campagna',
        'excerpt'                           => 'Testo della Pagina Principale',
        'followers'                         => 'Seguaci',
        'gallery_visibility'                => 'Visibilità della Galleria di Immagini Predefinita',
        'genre'                             => 'Genere(i)',
        'header_image'                      => 'Immagine di copertina della Pagina Principale',
        'image'                             => 'Immagine della Barra Laterale',
        'is_discreet'                       => 'Riservato',
        'locale'                            => 'Lingua',
        'name'                              => 'Nome',
        'open'                              => 'Aperto a candidature',
        'post_collapsed'                    => 'I nuovi post sulle entità sono ripiegati in modo predefinito.',
        'premium'                           => 'Premium sbloccato da :name',
        'public'                            => 'Visibilità della campagna',
        'public_campaign_filters'           => 'Filtri Campagna Pubblica',
        'related_visibility'                => 'Visibilità degli Elementi Correlati',
        'superboosted'                      => 'Superpotenziato da',
        'system'                            => 'Sistema',
        'theme'                             => 'Tema',
        'vanity'                            => 'URL personalizzato',
        'visibility'                        => 'Visibilità',
    ],
    'following'                         => 'Che Segui',
    'helpers'                           => [
        'boosted'                           => 'Alcune caratteristiche sono sbloccate perché questa campagna è stata potenziata. Scopri di più nella pagina :settings.',
        'character_personality_visibility'  => 'Quando crei un nuovo personaggio come amministratore, seleziona l\'impostazione predefinita della privacy per i tratti della personalità.',
        'css'                               => 'Scrivi i tuoi CSS che saranno caricati all\'interno della pagina della tua campagna. Considera che qualsiasi abuso di questa funzionalità può portare alla rimozione dei tuoi CSS personalizzati. Le offese ripetute o gravi possono portare alla rimozione della campagna.',
        'dashboard'                         => 'Per personalizzare la visualizzazione del widget della dashboard della campagna, compila i seguenti campi.',
        'entity_count_v3'                   => 'Questo numero è ricalcolato ogni :amount ore.',
        'entity_privacy'                    => 'Quando crei una nuova entità come amministratore, seleziona l\'impostazione predefinita della privacy per la nuova entità.',
        'excerpt'                           => 'Il contenuto di questo campo sarà visualizzato sulla Pagina Princiapel nel widget dell\'intestazione della campagna, quindi scrivi qualche frase di presentazione del tuo mondo. Se questo campo è vuoto, verranno utilizzati i primi 1000 caratteri della descrizione della campagna.',
        'gallery_visibility'                => 'Valore di Visibilità predefinito quando si caricano le immagini nella galleria.',
        'header_image'                      => 'Immagine visualizzata come sfondo nel widget dell\'intestazione della campagna.',
        'hide_history'                      => 'Se abilitato, solo i membri con il ruolo :admin della campagna avranno accesso alla cronologia (registro delle modifiche) di un\'entità.',
        'hide_members'                      => 'Se abilitato, solo i membri del ruolo :admin della campagna avranno accesso alla lista dei membri della campagna.',
        'is_discreet'                       => 'Se abilitato quando la campagna è pubblica, non sarà visualizzato nelle campagne :public-campaigns.',
        'is_discreet_locked'                => 'Le campagne premium possono essere impostate in modo da essere visibili pubblicamente, ma non venire visualizzate nelle :public-campaigns.',
        'locale'                            => 'La lingua in cui la tua campagna è scritta. Questa specificazione è sfruttata per generare contenuti e raggruppare le campagne pubbliche.',
        'name'                              => 'La tua campagna/mondo può avere qualsiasi nome, a patto che che contenga almeno 4 lettere o numeri.',
        'no_entry'                          => 'Sembra che la campagna non abbia ancora una descrizione! Risolviamo il problema.',
        'permissions_tab'                   => 'Controlla le impostazioni predefinite di privacy e visibilità dei nuovi elementi con le seguenti opzioni.',
        'premium'                           => 'Alcune funzioni sono disponibili perché le funzioni premium di questa campagna sono sbloccate. Per saperne di più, visita la pagina :settings',
        'public_campaign_filters'           => 'Aiuta altre persone a trovare la campagna tra altre campagne pubbliche fornendo le seguenti informazioni.',
        'public_no_visibility'              => 'Attenzione! La campagna è pubblica, ma il ruolo pubblico della campagna non può accedere a nulla. :fix.',
        'related_visibility'                => 'Valore predefinito di Visibilità quando si crea un nuovo elemento con questo campo (post, relazioni, abilità, ecc.)',
        'system'                            => 'Se la tua campagna è visibile pubblicamente, il sistema sarà visualizzato nella pagina :link.',
        'systems'                           => 'Per evitare di confondere gli utenti con una sovrabbondanza di opzioni, alcune di esse sono disponibili solamente per specifici sistemi RPG (per esempio il blocco delle statistiche dei mostri di D&D 5e). Aggiungere un sistema supportato qui abiliterà queste funzionalità.',
        'theme'                             => 'Forza il tema della campagna, sovrascrivendo le preferenze delle utenze.',
        'view_public'                       => 'Per visualizzare la tua campagna come farebbe uno spettatore pubblico, apri :link in una finestra di navigazione in incognito.',
        'visibility'                        => 'Rendere pubblica una campagna significa che chiunque abbia il link può vederla.',
    ],
    'index'                             => [],
    'invites'                           => [
        'actions'               => [
            'copy'  => 'Copia il link nei tuoi appunti',
            'link'  => 'Invita persone',
        ],
        'create'                => [
            'buttons'       => [
                'create'    => 'Genera link',
            ],
            'success_link'  => 'Link creato: :link',
            'title'         => 'Invita qualcuno in :campaign',
        ],
        'destroy'               => [
            'success'   => 'Invito rimosso.',
        ],
        'error'                 => [
            'inactive_token'    => 'Questo token è già stato utilizzato o la campagna non esiste più.',
            'invalid_token'     => 'Questo token non è più valido.',
            'join'              => 'Per favore accedi o registrati con un nuovo account per entrare in :campaign.',
        ],
        'fields'                => [
            'created'   => 'Creato',
            'role'      => 'Ruolo',
            'token'     => 'Token',
            'type'      => 'Tipo',
            'usage'     => 'Scade dopo',
        ],
        'unlimited_validity'    => 'Nessun Limite',
        'usages'                => [
            'five'      => '5 usi',
            'no_limit'  => 'Nessun limite',
            'once'      => '1 uso',
            'ten'       => '10 usi',
        ],
    ],
    'leave'                             => [
        'confirm'           => 'Sei sicuro di voler abbandonare la campagna :name? Non potrai più accedere, a meno che un amministratore della campagna non ti inviti nuovamente.',
        'confirm-button'    => 'Si, abbandona la campagna.',
        'error'             => 'Non puoi abbandonare la campagna.',
        'fix'               => 'Vai ai membri della campagna',
        'no-admin-left'     => 'Lasciare la campagna non è possibile perché la lascerebbe senza amministratori. Assegna il ruolo di admin prima a un altro membro.',
        'success'           => 'Hai abbandonato la campagna.',
        'title'             => 'Lasciare la campagna',
    ],
    'members'                           => [
        'actions'               => [
            'remove'        => 'Rimuovi dalla campagna',
            'switch'        => 'Passa a',
            'switch-back'   => 'Torna al mio utente',
            'switch-entity' => 'Visualizza come',
        ],
        'fields'                => [
            'banned'        => 'L\'utente è bannato',
            'joined'        => 'Unito',
            'last_login'    => 'Ultimo Login',
            'name'          => 'Utente',
            'role'          => 'Ruolo',
            'roles'         => 'Ruoli',
        ],
        'helpers'               => [
            'switch'    => 'Passa a questo utente',
        ],
        'impersonating'         => [
            'message'   => 'Stai visualizzando la campagna come un altro utente. Alcune caratteristiche sono state disabilitate, ma il resto viene mostrato esattamente come lo vedrebbe quell\'utente.',
            'title'     => 'Stai impersonando :name',
        ],
        'invite'                => [
            'description'   => 'Puoi invitare i tuoi amici nella tua campagna indicandoci i loro indirizzi e-mail. Una volta che avranno accettato il loro invito verranno aggiunti come membri nel ruolo indicato.',
            'more'          => 'Puoi aggiungere ulteriori ruoli su :link.',
            'title'         => 'Invita',
        ],
        'removal'               => 'Stai rimuovendo ":membro" dalla campagna.',
        'roles'                 => [
            'member'    => 'Membro',
            'owner'     => 'Amministratore',
            'player'    => 'Giocatore',
            'public'    => 'Pubblico',
            'viewer'    => 'Spettatore',
        ],
        'switch_back_success'   => 'Ora sei tornato al tuo utente originale.',
    ],
    'modules'                           => [
        'permission-disabled'   => 'Questo modulo è disattivato.',
    ],
    'overview'                          => [
        'entity-count'      => '{0} Nessuna entità|{1} :amount entità|[2,] :amount entità',
        'follower-count'    => '{0} Nessun seguace|{1} :amount seguace|[2,] :amount seguaci',
    ],
    'panels'                            => [
        'dashboard' => 'Pagina Principale',
        'permission'=> 'Permessi',
        'setup'     => 'Configurazione',
        'sharing'   => 'Condivisione',
        'systems'   => 'Sistemi',
        'ui'        => 'Interfaccia',
    ],
    'placeholders'                      => [
        'locale'    => 'Codice di lingua',
        'name'      => 'Il nome della tua campagna',
        'system'    => 'D&D 5e, Pathfinder, Fate, Gurps, DSA',
    ],
    'privacy'                           => [
        'hidden'    => 'Nascosto',
        'private'   => 'Privato',
        'visible'   => 'Visibile',
    ],
    'public'                            => [
        'helpers'   => [
            'introduction'  => 'Le campagne sono private per impostazione predefinita e possono essere rese pubbliche. Questo permette a chiunque di accedervi e le rende disponibili nella pagina :public-campaigns se hanno entità visibili al ruolo :public-role. Una campagna pubblica è visibile a tutti, ma affinché il suo contenuto sia visibile, il ruolo :public-role ha bisogno di permessi adeguati.',
        ],
    ],
    'roles'                             => [
        'actions'       => [
            'add'           => 'Aggiungi un ruolo',
            'duplicate'     => 'Duplica ruolo',
            'permissions'   => 'Gestire le autorizzazioni',
            'rename'        => 'Rinomina ruolo',
            'save'          => 'Salva ruolo',
        ],
        'admin_role'    => 'Ruolo di amministratore',
        'bulks'         => [
            'delete'    => '{1} Rimosso :count ruolo.|[2,*] Rimossi :count ruoli.',
            'edit'      => '{1} Aggiornato :count ruolo.|[2,*] Aggiornati :count ruoli.',
        ],
        'create'        => [
            'success'   => 'Ruolo :name creato.',
            'title'     => 'Crea un nuovo ruolo',
        ],
        'destroy'       => [
            'success'   => 'Ruolo :name rimosso.',
        ],
        'edit'          => [
            'success'   => 'Ruolo :name aggiornato.',
            'title'     => 'Modifica il ruolo :name',
        ],
        'fields'        => [
            'copy_permissions'  => 'Copia autorizzazioni',
            'name'              => 'Nome',
            'permissions'       => 'Permessi',
            'type'              => 'Tipo',
            'users'             => 'Utenti',
        ],
        'helper'        => [
            '1'                     => 'Una campagna può avere tanti ruoli quanti ne desideri. Il ruolo :admin ti dà automaticamente accesso a tutto nella campagna, ma ogni altro ruolo può avere permessi specifici su diversi tipi di entità (personaggio, luogo, ecc).',
            '2'                     => 'I permessi delle entità possono essere perfezionati utilizzando la tabella "Permessi" di unl\'entità. Questa tabella appare quando la tua campagna ha più ruoli o membri.',
            '3'                     => 'Puoi usare un sistema "opt-out", dove ai ruoli è dato il permesso di vedere tutte le entità, e usare la spunta "Privato" sull\'entità per nasconderla. Oppure puoi dare ai ruoli pochi permessi, ma impostare ogni entità come visibile.',
            '4'                     => 'Campagne Potenziate possono avere un numero illimitato di ruoli',
            'permissions_helper'    => 'Duplica tutte le autorizzazioni del ruolo, sia dei moduli che delle entità',
        ],
        'hints'         => [
            'campaign_not_public'   => 'Il ruolo pubblico ha dei permessi, ma la campagna è privata. Puoi cambiare questa impostazione sulla tabella Condivisione mentre modifichi la campagna.',
            'empty_role'            => 'Il ruolo non ha ancora nessun membro all\'interno.',
            'role_admin'            => 'Il ruolo :name garantisce automaticamente ai suoi membri l\'accesso a tutto ciò che è presente nella campagna.',
            'role_permissions'      => 'Abilita il ruolo :name per le seguenti funzioni su tutte le entità.',
        ],
        'members'       => 'Membri',
        'modals'        => [
            'details'   => [
                'campaign'  => 'Le autorizzazioni della campagna consentono quanto segue.',
                'entities'  => 'Ecco un breve riepilogo di ciò che i membri di questo ruolo ottengono quando viene impostata un\'autorizzazione.',
                'more'      => 'Per maggiori dettagli, guarda il nostro video tutorial su Youtube',
                'title'     => 'Dettagli di autorizzazione',
            ],
        ],
        'permissions'   => [
            'actions'   => [
                'add'           => 'Crea',
                'dashboard'     => 'Pagina Principale',
                'delete'        => 'Elimina',
                'edit'          => 'Modifica',
                'entity-note'   => 'Post',
                'gallery'       => [
                    'browse'    => 'Ricerca',
                    'manage'    => 'Pieno controllo',
                    'upload'    => 'Aggiorna',
                ],
                'manage'        => 'Gestisci',
                'members'       => 'Membri',
                'permission'    => 'Autorizzazioni',
                'read'          => 'Visualizza',
                'toggle'        => 'Cambia per tutte',
            ],
            'helpers'   => [
                'add'           => 'Consente la creazione di entità di questo tipo. Gli utenti saranno automaticamente autorizzati a visualizzare e modificare le entità che creano, se non hanno l\'autorizzazione di visualizzazione o modifica.',
                'dashboard'     => 'Consente la modifica della Pagina Principale e dei widget della Pagina Principale.',
                'delete'        => 'Consente la rimozione di tutte le entità di questo tipo.',
                'edit'          => 'Consente la modifica di tutte le entità di questo tipo.',
                'entity_note'   => 'Questo permette ad utenti che non hanno il permesso di modificare un\'entità di aggiungere note ad essa.',
                'gallery'       => [
                    'browse'    => 'Consente di visualizzare la galleria e di impostare l\'immagine di un\'entità dalla galleria.',
                    'manage'    => 'Consente tutto ciò che è possibile fare nella galleria come un amministratore, compresa la modifica e l\'eliminazione delle immagini.',
                    'upload'    => 'Consente di caricare immagini nella galleria. Se non è abbinato al permesso di cercare immagini, l\'utente vedrà solo le immagini che ha caricato.',
                ],
                'manage'        => 'Consente la modifica della campagna come farebbe l\'amministratore di una campagna, senza permettere ai membri di cancellare la campagna.',
                'members'       => 'Consente di invitare nuovi membri alla campagna.',
                'not_public'    => 'La campagna non è pubblica. Le autorizzazioni per il ruolo pubblico possono essere impostate, ma saranno ignorate. Modifica la campagna per renderla pubblica.',
                'permission'    => 'Consente di impostare le autorizzazioni sulle entità di questo tipo che possono modificare.',
                'read'          => 'Consente di visualizzare tutte le entità di questo tipo che non sono private.',
            ],
        ],
        'placeholders'  => [
            'name'  => 'Nome del ruolo',
        ],
        'title'         => 'Ruoli della campagna :name',
        'types'         => [
            'owner'     => 'Amministratore',
            'public'    => 'Pubblico',
            'standard'  => 'Predefinito',
        ],
        'users'         => [
            'actions'   => [
                'add'           => 'Aggiungi membro',
                'remove'        => ':user dal ruolo :role',
                'remove_user'   => 'Rimuovi l\'utente dal ruolo',
            ],
            'create'    => [
                'success'   => ':user aggiunto al ruolo :role.',
                'title'     => 'Aggiungi un membro al ruolo :name',
            ],
            'destroy'   => [
                'success'   => ':user rimosso dal ruolo :role.',
            ],
            'errors'    => [
                'cant_kick_admins'  => 'Per evitare eventuali abusi, non è possibile rimuovere altri membri dal ruolo di :admin della campagna. In caso di problemi, contattataci su :discord o all\'indirizzo :email.',
                'needs_more_roles'  => 'È necessario aggiungersi a un altro ruolo nella campagna prima di potersi rimuovere dal ruolo :admin.',
            ],
            'fields'    => [
                'name'  => 'Nome',
            ],
        ],
    ],
    'settings'                          => [
        'actions'       => [
            'enable'    => 'Abilita',
        ],
        'boosted'       => 'Questa funzionalità è in beta e al momento è disponibile solo per :boosted.',
        'deprecated'    => [
            'help'  => 'Questo modulo è obsoleto, il che significa che non viene più mantenuto e che i bug non vengono risolti a ogni nuovo aggiornamento. Utilizza questo modulo sapendo che alla fine verrà rimosso da Kanka.',
            'title' => 'Obsoleto',
        ],
        'disabled'      => 'Il modulo :module è disabilitato.',
        'enabled'       => 'Il modulo :module è abilitato.',
        'errors'        => [
            'module-disabled'   => 'Il modulo richiesto è attualmente disabilitato nelle impostazioni della campagna. :fix.',
        ],
        'helpers'       => [
            'abilities'         => 'Crea abilità, siano esse talenti, incantesimi o poteri che possono essere assegnati alle entità.',
            'assets'            => 'Carica file, imposta link e crea alias per le singole entità.',
            'bookmarks'         => 'Crea segnalibri alle entità o agli elenchi filtrati che appaiono nella barra laterale.',
            'calendars'         => 'Un\'area dove definire i calendari del tuo mondo.',
            'characters'        => 'Le persone che abitano il tuo mondo.',
            'conversations'     => 'Conversazioni fittizie tra i personaggi o gli utenti della campagna.',
            'creatures'         => 'Crea le creature, gli animali e i mostri del tuo mondo con il modulo delle creature.',
            'dice_rolls'        => 'Per quelli che utilizzano Kanka per una campagna GDR, un modo per gestire i tiri di dado.',
            'entity_attributes' => 'Tieni traccia degli attributi delle entità della campagna, ad esempio PF o VELOCITÀ.',
            'events'            => 'Vacanze, feste, disastri, compleanni, guerre.',
            'families'          => 'Clan o famiglie, le loro relazioni e i loro membri.',
            'inventories'       => 'Gestisci gli inventari delle tue entità',
            'items'             => 'Armi, veicoli, reliquie, pozioni.',
            'journals'          => 'Osservazioni scritte dai personaggi, o preparazione per le sessioni del dungeon master.',
            'locations'         => 'Pianeti, piani, continenti, fiumi, nazioni, insediamenti, templi, taverne.',
            'maps'              => 'Carica mappe con livelli e indicatori che portano ad altre entità nella campagna.',
            'notes'             => 'Tradizioni, religioni, storia, magia, culture.',
            'organisations'     => 'Culti, religioni, fazioni, gilde.',
            'quests'            => 'Per tener traccia di varie missioni con personaggi e luoghi.',
            'races'             => 'Traccia le origini, le etnie e i tratti di specie dei personaggi del mondo con il modulo della stirpe.',
            'tags'              => 'Ogni entità può avere diversi tag. I tag possono appartenere ad altri tag e le entità possono essere filtrate per tag.',
            'timelines'         => 'Narra la storia del tuo mondo con le linee temporali',
        ],
    ],
    'sharing'                           => [
        'filters'   => 'Le campagne pubbliche sono visibili nella pagina :public-campaigns. La compilazione di questi campi aiuta la gente a trovare la campagna.',
        'language'  => 'La lingua in cui sono scritti i contenuti della campagna.',
        'system'    => 'Se giochi a un GDR, il sistema utilizzato per giocare nella campagna.',
    ],
    'show'                              => [
        'actions'   => [
            'edit'  => 'Modifica Campagna',
            'leave' => 'Abbandona Campagna',
        ],
        'menus'     => [
            'configuration'     => 'Configurazione',
            'overview'          => 'Panoramica',
            'user_management'   => 'Gestione utente',
        ],
        'tabs'      => [
            'achievements'      => 'Obbiettivi',
            'applications'      => 'Candidature',
            'campaign'          => 'Campagna',
            'customisation'     => 'Personalizzazione',
            'data'              => 'Dati',
            'default-images'    => 'Anteprime predefinite',
            'export'            => 'Esporta',
            'import'            => 'Importa',
            'information'       => 'Informazioni',
            'management'        => 'Gestione',
            'members'           => 'Membri',
            'modules'           => 'Moduli',
            'plugins'           => 'Plugin',
            'recovery'          => 'Recupero',
            'roles'             => 'Ruoli',
            'sidebar'           => 'Configurazione della barra laterale',
            'styles'            => 'Tema',
            'webhooks'          => 'Webhooks',
        ],
        'title'     => 'Panoramica - :name',
    ],
    'themes'                            => [
        'none'  => 'Nessuno (predefinito alle impostazioni utente)',
    ],
    'ui'                                => [
        'collapsed'         => [
            'collapsed' => 'Ripiegato',
            'default'   => 'Predefinito',
        ],
        'connections'       => [
            'explorer'  => 'Esploratore di Relazioni (se disponibile, per campagne Potenziate)',
            'list'      => 'Elenco Interfaccia',
        ],
        'entity_history'    => [
            'hidden'    => 'Visibile solo agli amministratori della campagna',
            'visible'   => 'Visibile ai membri',
        ],
        'fields'            => [
            'connections'       => 'Interfaccia connessioni dell\'entità predefinita',
            'connections_mode'  => 'Modalità Esploratore di Relazioni predefinita',
            'entity_history'    => 'Cronologia dell\'entità',
            'entity_image'      => 'Immagine dell\'entità',
            'member_list'       => 'Lista dei membri della campagna',
            'post_collapsed'    => 'Valore predefinito del nuovo post ripiegato',
        ],
        'helpers'           => [
            'connections'       => 'Quando fai clic sulla sottopagina delle connessioni di un\'entità, seleziona l\'interfaccia predefinita mostrata.',
            'connections_mode'  => 'Quando visualizzi l\'esploratore di relazioni di un\'entità, seleziona l\'interfaccia predefinita mostrata.',
            'entity-history'    => 'Controlla chi può vedere le modifiche recenti apportate alle singole entità della campagna.',
            'member-list'       => 'Controlla chi può vedere chi partecipa alla campagna.',
            'other'             => 'Altre opzioni grafiche per la campagna',
            'post_collapsed'    => 'Quando crei un nuovo post in un\'entità, seleziona il valore predefinito del campo ripiegato.',
            'theme'             => 'Visualizza la campagna nel tema dell\'utente o usa uno dei temi seguenti per tutti gli utenti.',
            'tooltip'           => 'Controlla quale informazione è visibile passando il mouse sul nome di un\'entità nella sua descrizione popup.',
        ],
        'members'           => [
            'hidden'    => 'Visibile solo agli amministratori della campagna',
            'visible'   => 'Visibile ai membri',
        ],
        'other'             => 'Altro',
    ],
    'visibilities'                      => [
        'private'   => 'Campagna Privata',
        'public'    => 'Campagna Pubblica',
        'review'    => 'In attesa di revisione',
    ],
    'warning'                           => [],
];
