<?php

return [
    'actions'           => [
        'actions'           => 'Azioni',
        'apply'             => 'Applica',
        'back'              => 'Indietro',
        'copy'              => 'Copia',
        'copy_mention'      => 'Copia [ ] menzione',
        'copy_to_campaign'  => 'Copia nella Campagna',
        'explore_view'      => 'Vista annidata',
        'export'            => 'Esporta (PDF)',
        'find_out_more'     => 'Scopri di più',
        'go_to'             => 'Vai a :name',
        'json-export'       => 'Esporta (JSON)',
        'more'              => 'Più Azioni',
        'move'              => 'Sposta',
        'new'               => 'Nuovo',
        'next'              => 'Prossimo',
        'private'           => 'Privato',
        'public'            => 'Pubblico',
        'reset'             => 'Resetta',
    ],
    'add'               => 'Aggiungi',
    'alerts'            => [
        'copy_mention'  => 'La menzione avanzata dell\'entità è stata copiata nei tuoi appunti.',
    ],
    'attributes'        => [
        'actions'       => [
            'add'               => 'Aggiungi un attributo',
            'add_block'         => 'Aggiungi un blocco',
            'add_checkbox'      => 'Aggiungi un checkbox',
            'add_text'          => 'Aggiungi un testo',
            'apply_template'    => 'Applica un Template per gli Attributi',
            'manage'            => 'Gestisci',
            'remove_all'        => 'Cancella tutti',
        ],
        'create'        => [
            'description'   => 'Crea un nuovo attributo',
            'success'       => 'L\'Attributo :name è stato aggiunto a :entity',
            'title'         => 'Nuovo Attributo per :name',
        ],
        'destroy'       => [
            'success'   => 'L\'attributo :name è stato rimosso da :entity',
        ],
        'edit'          => [
            'description'   => 'Aggiorna un attributo esistente',
            'success'       => 'L\'attributo :name per :entity è stato aggiornato.',
            'title'         => 'Aggiorna l\'attributo per :name',
        ],
        'fields'        => [
            'attribute'             => 'Attributo',
            'community_templates'   => 'Templates della Community',
            'is_private'            => 'Attributi Privati',
            'is_star'               => 'Fissato',
            'template'              => 'Template',
            'value'                 => 'Valore',
        ],
        'helpers'       => [
            'delete_all'    => 'Sei sicuro di voler cancellare tutti gli attributi di questa entità?',
        ],
        'hints'         => [
            'is_private'    => 'Puoi nascondere tutti gli attributi di un\'entità per tutti i membri al di fuori del gruppo degli amministratori rendendoli privati.',
        ],
        'index'         => [
            'success'   => 'Attributo aggiornato per :entity.',
            'title'     => 'Attributi per :name',
        ],
        'placeholders'  => [
            'attribute' => 'Numero di conquiste, Grado di Sfida, Iniziativa, Popolazione',
            'block'     => 'Nome del blocco',
            'checkbox'  => 'Nome del checkbox',
            'section'   => 'Nome della sezione',
            'template'  => 'Seleziona un template',
            'value'     => 'Valore dell\'attributo',
        ],
        'template'      => [
            'success'   => 'Il Template di Attributi :name è stato applicato su :entity',
            'title'     => 'Applica un Template degli Attributi per :name',
        ],
        'types'         => [
            'attribute' => 'Attributo',
            'block'     => 'Blocco',
            'checkbox'  => 'Checkbox',
            'section'   => 'Sezione',
            'text'      => 'Testo multilinea',
        ],
        'visibility'    => [
            'entry'     => 'Gli Attributi sono mostrati nella tab Principale.',
            'private'   => 'Attributo visibile solamente ai membri del ruolo "Admin".',
            'public'    => 'Attributo visibile a tutti i membri.',
            'tab'       => 'Gli attributi sono visualizzati solamente nella tab degli Attributi.',
        ],
    ],
    'boosted'           => 'Potenziata',
    'boosted_campaigns' => 'Campagne potenziate',
    'bulk'              => [
        'actions'       => [
            'edit'  => 'Modifica in blocco & assegnazione dei tag',
        ],
        'age'           => [
            'helper'    => 'Puoi usare + e - prima del numero per aggiornare l\'età di quel quantitativo.',
        ],
        'delete'        => [
            'title'     => 'Rimuovendo molteplici entità',
            'warning'   => 'Sei sicuro di voler cancellare le entità selezionate?',
        ],
        'edit'          => [
            'tagging'   => 'Azione per i tag',
            'tags'      => [
                'add'       => 'Aggiungi',
                'remove'    => 'Rimuovi',
            ],
            'title'     => 'Modificando molteplici entità',
        ],
        'errors'        => [
            'admin'     => 'Solo gli amministratori della campagna possono cambiare lo stato di visibilità delle entità.',
            'general'   => 'C\'è stato un errore nell\'elaborazione della tua azione. Per favore prova di nuovo e contattaci qualora il problema dovesse persistere. Messaggio di errore: :hint.',
        ],
        'permissions'   => [
            'fields'    => [
                'override'  => 'Sovrascrivi',
            ],
            'helpers'   => [
                'override'  => 'Se selezionato, i permessi delle entità selezionate saranno sovrascritti con questi. Se non selezionato i permessi selezionati saranno aggiunti a quelli già assegnati.',
            ],
            'title'     => 'Cambia i permessi a più entità',
        ],
        'success'       => [
            'copy_to_campaign'  => '{1} :count entità copiata in :campaign.|[2,*] :count entità copiate in :campaign.',
            'editing'           => '{1} :count entità è stata aggiornata.|[2,*] :count entitià sono state aggiornate.',
            'permissions'       => '{1} Permessi modificati per :count entità.|[2,*] Permessi modificati per :count entità.',
            'private'           => '{1} :count entità è adesso privata|[2,*] :count entità sono adesso private.',
            'public'            => '{1} :count entità è adesso visibile|[2,*] :count entità sono adesso visibili.',
        ],
    ],
    'cancel'            => 'Annulla',
    'click_modal'       => [
        'close'     => 'Chiudi',
        'confirm'   => 'Conferma',
        'title'     => 'Conferma la tua azione',
    ],
    'copy_to_campaign'  => [
        'bulk_title'    => 'Copia le entità in un\'altra campagna',
        'panel'         => 'Copia',
        'title'         => 'Copia \':name\' in una\'ltra campagna',
    ],
    'create'            => 'Crea',
    'datagrid'          => [
        'empty' => 'Ancora non c\'è nulla da mostrare.',
    ],
    'delete_modal'      => [
        'close'         => 'Chiudi',
        'delete'        => 'Cancella',
        'description'   => 'Sei sicuro di voler rimuovere :tag?',
        'mirrored'      => 'Rimuovere la relazione speculare.',
        'title'         => 'Conferma di cancellazione',
    ],
    'destroy_many'      => [
        'success'   => 'Cancellata :count entità|Cancellate :count entità.',
    ],
    'edit'              => 'Modifica',
    'errors'            => [
        'boosted'                       => 'Questa funzionalità è disponibile solo per le campagne potenziate.',
        'node_must_not_be_a_descendant' => 'Nodo non valido (tag, luogo padre): sarebbe un discendente di sé stesso.',
    ],
    'events'            => [
        'hint'  => 'Qui sotto puoi vedere una lista di tutti i calendari ai quali questa entità è stata aggiunta usando "Aggiungi un evento ad un calendario".',
    ],
    'export'            => 'Esporta',
    'fields'            => [
        'ability'               => 'Abilità',
        'attribute_template'    => 'Template di Attributi',
        'calendar'              => 'Calendario',
        'calendar_date'         => 'Data del Calendario',
        'character'             => 'Personaggio',
        'colour'                => 'Colore',
        'copy_attributes'       => 'Copia Attributo',
        'copy_notes'            => 'Copia le Note dell\'Entità',
        'creator'               => 'Creatore',
        'dice_roll'             => 'Tiro di dado',
        'entity'                => 'Entità',
        'entity_type'           => 'Tipo di Entità',
        'entry'                 => 'Dato inserito',
        'event'                 => 'Evento',
        'excerpt'               => 'Estratto',
        'family'                => 'Famiglia',
        'files'                 => 'Files',
        'header_image'          => 'Immagine dell\'intestazione',
        'image'                 => 'Immagine',
        'is_private'            => 'Privato',
        'is_star'               => 'Fissato',
        'item'                  => 'Oggetto',
        'location'              => 'Luogo',
        'map'                   => 'Mappa',
        'name'                  => 'Nome',
        'organisation'          => 'Organizzazione',
        'race'                  => 'Razza',
        'tag'                   => 'Tag',
        'tags'                  => 'Tags',
        'tooltip'               => 'Tooltip',
        'type'                  => 'Tipo',
        'visibility'            => 'Visibilità',
    ],
    'files'             => [
        'actions'   => [
            'drop'      => 'Clicca per Aggiungere o Trascina un file',
            'manage'    => 'Gestisci i files dell\'entità',
        ],
        'errors'    => [
            'max'       => 'Hai raggiunto il numero massimo di file (:max) per questa entità.',
            'no_files'  => 'Nessun file.',
        ],
        'files'     => 'Files Caricati',
        'hints'     => [
            'limit'         => 'Ciascuna entità può avere un massimo di :max files caricati.',
            'limitations'   => 'Formati supportati: jpg, png, gif, e pdf. Dimensione massima del file: :size',
        ],
        'title'     => 'Files dell\'entità :name',
    ],
    'filter'            => 'Filtra',
    'filters'           => [
        'all'       => 'Filtra includendo tutti i discendenti',
        'clear'     => 'Pulisci i Filtri',
        'direct'    => 'Filtra includendo solamente i discendenti diretti',
        'filtered'  => 'Visualizzati :count di :total :entity.',
        'hide'      => 'Nascondi i Filtri',
        'show'      => 'Visualizza i Filtri',
        'sorting'   => [
            'asc'       => ':field in ordine crescente',
            'desc'      => ':field in ordine decrescente',
            'helper'    => 'Gestisci l\'ordine di visualizzazione dei risultati.',
        ],
        'title'     => 'Filtri',
    ],
    'forms'             => [
        'actions'       => [
            'calendar'  => 'Aggiungi una data del calendario',
        ],
        'copy_options'  => 'Copia opzioni',
    ],
    'hidden'            => 'Nascosto',
    'hints'             => [
        'attribute_template'    => 'Applica un template per gli attributi direttamente quando si crea questa entità.',
        'calendar_date'         => 'La data di un calendario permette un semplice filtro nelle liste e mantiene un evento nel calendario selezionato.',
        'header_image'          => 'Questa immagine è posizionata sopra all\' entità. Per un miglior risultato, utilizza un\'immagine larga.',
        'image_limitations'     => 'Formati supportati: :formats. Dimensione massima del file: :size.',
        'image_patreon'         => 'Aumentare la dimensione massima dei file?',
        'is_private'            => 'Se impostata come privata, questa entità sarà visibile solamente ai membri appartenenti al ruolo "Proprietario" della campagna.',
        'is_star'               => 'Gli elementi fissati appariranno nel menù dell\'entità',
        'tooltip'               => 'Sostituisci il tooltip generato automaticamente con il seguente contenuto.',
        'visibility'            => 'Impostare la visibilità agli amministratori significa che solamente i membri del ruolo "Proprietario" della campagna potranno visualizzarlo. Impostarlo a "Te stesso" significa che solo tu potrai vederlo.',
    ],
    'history'           => [
        'created'       => 'Creato da <strong>:name</strong> <span data-toggle="tooltip" title=":realdate">:date</span>',
        'created_date'  => 'Creato <span data-toggle="tooltip" title=":realdate">:date</span>',
        'unknown'       => 'Sconosciuto',
        'updated'       => 'Modificato l\'ultima volta da <strong>:name</strong> <span data-toggle="tooltip" title=":realdate">:date</span>',
        'updated_date'  => 'Ultima modifica <span data-toggle="tooltip" title=":realdate">:date</span>',
        'view'          => 'Visualizza i log dell\'entità',
    ],
    'image'             => [
        'error' => 'Non siamo stati in gradi di recuperare l\'immagine richiesta. Potrebbe essere che il sito web non ci permetta di scaricare l\'immagine (solitamente ciò riguarda Squarespace e DeviantArt) o che il link non sia più valido. Per favore controlla anche che la dimensione dell\'immagine non sia maggiore di :size.',
    ],
    'is_private'        => 'Questa entità è privata e visibile solamente ai membri del ruolo "Proprietario".',
    'linking_help'      => 'Come posso creare un collegamento ad altre entità?',
    'manage'            => 'Gestisci',
    'move'              => [
        'description'   => 'Sposta questa entità in un altro posto',
        'errors'        => [
            'permission'        => 'Non sei autorizzato a creare entità di questo tipo nella campagna selezionata.',
            'same_campaign'     => 'Devi selezionare un\'altra campagna verso cui spostare l\'entità.',
            'unknown_campaign'  => 'Campagna sconosciuta',
        ],
        'fields'        => [
            'campaign'  => 'Nuova campagna',
            'copy'      => 'Crea una copia',
            'target'    => 'Nuovo tipo',
        ],
        'hints'         => [
            'campaign'  => 'Puoi anche provare a spostare questa entità in un\'altra campagna',
            'copy'      => 'Seleziona questa opzione se vuoi crearne una copia nella nuova campagna.',
            'target'    => 'Per favore considera che alcuni dati potrebbero andare persi nel caso si spostasse un elemento da un tipo ad un altro.',
        ],
        'success'       => 'Entità \':name\' spostata.',
        'success_copy'  => 'Entità \':name\' copiata.',
        'title'         => 'Sposta :name',
    ],
    'new_entity'        => [
        'error' => 'Per favore controlla i tuoi valori.',
        'fields'=> [
            'name'  => 'Nome',
        ],
        'title' => 'Nuova entità',
    ],
    'or_cancel'         => 'o <a href=":url">annulla</a>',
    'panels'            => [
        'appearance'            => 'Aspetto',
        'attribute_template'    => 'Template di attributi',
        'calendar_date'         => 'Data del Calendario',
        'entry'                 => 'Elemento',
        'general_information'   => 'Informazioni Generali',
        'move'                  => 'Sposta',
        'system'                => 'Sistema',
    ],
    'permissions'       => [
        'action'            => 'Azione',
        'actions'           => [
            'bulk'          => [
                'add'       => 'Aggiungi',
                'deny'      => 'Nega',
                'ignore'    => 'Ignora',
                'remove'    => 'Rimuovi',
            ],
            'bulk_entity'   => [
                'allow'     => 'Permetti',
                'deny'      => 'Nega',
                'inherit'   => 'Eredita',
            ],
            'delete'        => 'Cancella',
            'edit'          => 'Modifica',
            'entity_note'   => 'Note dell\'Entità',
            'read'          => 'Lettura',
            'toggle'        => 'Attiva/Disattiva',
        ],
        'allowed'           => 'Permesso',
        'fields'            => [
            'member'    => 'Membro',
            'role'      => 'Ruolo',
        ],
        'helper'            => 'Utilizza questa interfaccia per rifinire e specificare quali utenti e ruoli possono interagire con questa entità.',
        'helpers'           => [
            'entity_note'   => 'Permetti agli utenti di creare Note per questa Entità. Senza questo permesso, essi saranno ancora in grado di vedere le note dell\'entità impostate come visibili per Tutti.',
            'setup'         => 'Utilizza questa interfaccia per rifinire e specificare come utenti e ruoli possono interagire con questa entità. :allow permetterà all\'utente o al ruolo di fare questa azione. :deny negherà loro tale azione. :inherit farà riferimento al ruolo dell\'utente o al permesso del ruolo. Un utente impostato come :allow sarà in grado di fare l\'azione anche se il suo ruolo sarà invece impostato su :deny.',
        ],
        'inherited'         => 'Questo ruolo ha già questo permesso impostato per questa tipologia di entità.',
        'inherited_by'      => 'Questo utente fa parte del ruolo \':role\' che gli conferisce questo permesso su questa tipologia di entità.',
        'success'           => 'Permessi salvati.',
        'title'             => 'Permessi',
        'too_many_members'  => 'Questa campagna ha troppi membri (più di 10) per poterli mostrare tutti in questa interfaccia. Ti preghiamo di usare il tasto Permessi sulla pagine dell\'entità per poter verificare i permessi nel dettaglio.',
    ],
    'placeholders'      => [
        'ability'       => 'Seleziona un\'abilità',
        'calendar'      => 'Seleziona un calendario',
        'character'     => 'Seleziona un personaggio',
        'entity'        => 'Entità',
        'event'         => 'Seleziona un evento',
        'family'        => 'Seleziona una famiglia',
        'image_url'     => 'Altrimenti puoi caricare un\'immagine da un URL',
        'item'          => 'Seleziona un\'oggetto',
        'location'      => 'Seleziona un luogo',
        'map'           => 'Seleziona una mappa',
        'organisation'  => 'Seleziona un\'organizzazione',
        'race'          => 'Seleziona una razza',
        'tag'           => 'Seleziona un tag',
    ],
    'relations'         => [
        'actions'   => [
            'add'   => 'Aggiungi una relazione',
        ],
        'fields'    => [
            'location'  => 'Luogo',
            'name'      => 'Nome',
            'relation'  => 'Relazione',
        ],
        'hint'      => 'Le relazioni fra le entità possono essere impostate per rappresentare le loro connessioni.',
    ],
    'remove'            => 'Rimuovi',
    'rename'            => 'Rinomina',
    'save'              => 'Salva',
    'save_and_close'    => 'Salva e Chiudi',
    'save_and_copy'     => 'Salva e Copia',
    'save_and_new'      => 'Salva e Crea Nuovo',
    'save_and_update'   => 'Salve e Aggiorna',
    'save_and_view'     => 'Salva e Visualizza',
    'search'            => 'Cerca',
    'select'            => 'Seleziona',
    'tabs'              => [
        'abilities'     => 'Abilità',
        'attributes'    => 'Attributi',
        'boost'         => 'Potenzia',
        'calendars'     => 'Calendari',
        'default'       => 'Predefinito',
        'events'        => 'Eventi',
        'inventory'     => 'Inventario',
        'map-points'    => 'Punti della Mappa',
        'mentions'      => 'Menzioni',
        'menu'          => 'Menù',
        'notes'         => 'Note',
        'permissions'   => 'Permessi',
        'relations'     => 'Relazioni',
        'reminders'     => 'Promemoria',
        'tooltip'       => 'Tooltip',
    ],
    'update'            => 'Aggiorna',
    'users'             => [
        'unknown'   => 'Sconosciuto',
    ],
    'view'              => 'Visualizza',
    'visibilities'      => [
        'admin'         => 'Proprietario',
        'admin-self'    => 'Te Stesso e Proprietario',
        'all'           => 'Tutti',
        'self'          => 'Te stesso',
    ],
];
