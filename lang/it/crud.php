<?php

return [
    'actions'                   => [],
    'alerts'                    => [
        'copy_attribute'    => 'La menzione dell\'attributo è stata copiata nei tuoi appunti.',
    ],
    'bulk'                      => [
        'edit'      => [
            'title' => 'Modifica molteplici entità',
        ],
        'success'   => [
            'editing'   => '{1} :count entità è stata aggiornata.|[2,*] :count entità sono state aggiornate.',
        ],
    ],
    'bulk_templates'            => [],
    'click_modal'               => [],
    'copy_to_campaign'          => [
        'title' => 'Copia \':name\' in un\'altra campagna',
    ],
    'datagrid'                  => [
        'empty' => 'Non c\'è ancora nulla da mostrare.',
    ],
    'delete_modal'              => [
        'callout'   => 'Hey!',
        'confirm'   => 'Conferma la cancellazione',
    ],
    'destroy_many'              => [],
    'errors'                    => [
        'invalid_node'  => 'Il genitore selezionato non è valido. Di solito è possibile risolvere il problema assegnando al genitore selezionato un genitore proprio e poi rimuovendolo.',
    ],
    'events'                    => [],
    'fields'                    => [
        'copy_attributes'   => 'Copia Attributi',
        'date_range'        => 'Intervallo di date',
        'gallery_header'    => 'Intestazione della Galleria',
        'has_attributes'    => 'Ha attributi',
        'has_entity_files'  => 'Ha file di entità',
        'has_posts'         => 'Ha post',
    ],
    'files'                     => [
        'actions'   => [
            'manage'    => 'Gestisci i file dell\'entità',
        ],
        'files'     => 'File Caricati',
        'hints'     => [
            'limit' => 'Ciascuna entità può avere un massimo di :max file caricati.',
        ],
        'title'     => 'File dell\'entità :name',
    ],
    'filters'                   => [
        'copy_helper'               => 'Utilizza i filtri copiati negli appunti come valori per i filtri dei widget della Pagina Principale e dei collegamenti rapidi.',
        'copy_helper_no_filters'    => 'Definisci prima alcuni filtri per poterli copiare negli appunti.',
    ],
    'forms'                     => [],
    'helpers'                   => [
        'learn_more'    => 'Scopri di più riguardo alla funzione nella nostra :documentation.',
        'nested_parent' => 'Visualizzazione dei figli di :parent.',
        'pagination'    => [
            'text'  => 'Puoi mostrare più risultati per pagina cambiando le tue :settings',
        ],
    ],
    'hints'                     => [
        'gallery_header'        => 'Se l\'entità non ha un\'intestazione, mostra invece un\'immagine dalla galleria della campagna.',
        'gallery_image'         => 'Se l\'entità non ha un\'immagine, mostra invece un\'immagine dalla galleria della campagna.',
        'image_recommendation'  => 'Dimensioni raccomandate :width per :height px.',
        'tooltip'               => 'Sostituisci il tooltip generato automaticamente con il seguente contenuto. Il codice HTML verrà eliminato, ma si potranno comunque citare altre entità utilizzando le menzioni avanzate.',
        'visibility'            => 'Impostare la visibilità agli amministratori significa che solamente i membri del ruolo "Amministratore" della campagna potranno visualizzarlo. Impostarlo a "Te stesso" significa che solo tu potrai vederlo.',
    ],
    'history'                   => [
        'created_clean'         => 'Creata da :name :date',
        'created_date_clean'    => 'Creata :date',
        'updated_clean'         => 'Ultima modifica da parte di :name :date',
        'updated_date_clean'    => 'Ultima modifica :date',
    ],
    'image'                     => [],
    'is_private'                => 'Questa entità è privata e visibile solamente ai membri del ruolo "Amministratore".',
    'navigation'                => [
        'or_cancel' => 'o :cancel',
    ],
    'new_entity'                => [],
    'panels'                    => [],
    'permissions'               => [
        'actions'           => [
            'read'  => 'Leggi',
        ],
        'helper'            => 'Utilizza questa interfaccia per rifinire e specificare quali utenti e ruoli possono interagire con questa entità. :allow',
        'too_many_members'  => 'Questa campagna ha troppi membri (>:number) per poterli mostrare tutti in questa interfaccia. Ti preghiamo di usare il tasto Permessi sulla pagine dell\'entità per poter verificare i permessi nel dettaglio.',
    ],
    'placeholders'              => [
        'creature'  => 'Seleziona una creatura',
        'entity'    => 'Seleziona un\'entità',
        'fallback'  => 'Seleziona un :module',
        'journal'   => 'Seleziona un diario',
        'note'      => 'Seleziona una nota',
        'parent'    => 'Seleziona un genitore',
        'quest'     => 'Seleziona una missione',
        'race'      => 'Seleziona una stirpe',
        'timeline'  => 'Seleziona una Linea Temporale',
        'user'      => 'Seleziona un utente',
    ],
    'relations'                 => [],
    'superboosted_campaigns'    => 'Campagne Superpotenziate',
    'tabs'                      => [
        'assets'    => 'Assets',
        'mentions'  => 'Menzioni',
    ],
    'titles'                    => [
        'editing'   => 'Modifica :name',
        'new'       => 'Nuovo :module',
    ],
    'tooltips'                  => [
        'new_post'  => 'Aggiungi un nuovo post a questa entità',
    ],
    'users'                     => [],
    'visibilities'              => [
        'admin'         => 'Amministratori',
        'admin-self'    => 'Te Stesso e Amministratori',
        'members'       => 'Membri della campagna',
    ],
];
