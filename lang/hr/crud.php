<?php

return [
    'actions'           => [
        'actions'           => 'Akcije',
        'apply'             => 'Primijeni',
        'back'              => 'Natrag',
        'copy'              => 'Kopiraj',
        'copy_mention'      => 'Kopiraj [ ] spominjanje',
        'copy_to_campaign'  => 'Kopiraj u kampanju',
        'explore_view'      => 'Ugniježđeni pregled',
        'export'            => 'Izvoz',
        'find_out_more'     => 'Saznaj više',
        'go_to'             => 'Idi na :name',
        'json-export'       => 'Izvoz (json)',
        'manage_links'      => 'Upravljanje poveznicama',
        'move'              => 'Pomakni',
        'new'               => 'Novo',
        'new_post'          => 'Nova bilješka entiteta',
        'next'              => 'Sljedeće',
        'reset'             => 'Resetiraj',
        'transform'         => 'Transformiranje',
    ],
    'add'               => 'Dodaj',
    'alerts'            => [
        'copy_attribute'    => 'Spomen atributa kopiran je u tvoj međuspremnik.',
        'copy_mention'      => 'Napredno spominjanje entiteta kopirano je u međuspremnik.',
    ],
    'bulk'              => [
        'actions'       => [
            'edit'  => 'Skupno uređivanje i označavanje',
        ],
        'age'           => [
            'helper'    => 'Možeš koristiti + i - prije broja za ažuriranje dobi za taj iznos.',
        ],
        'delete'        => [
            'warning'   => 'Jesi li siguran/a da želiš izbrisati odabrane entitete?',
        ],
        'edit'          => [
            'tagging'   => 'Akcija za oznake',
            'tags'      => [
                'add'       => 'Dodaj',
                'remove'    => 'Ukloni',
            ],
            'title'     => 'Uređivanje više entiteta',
        ],
        'errors'        => [
            'admin'     => 'Samo administratori kampanje mogu promijeniti privatni status entiteta.',
            'general'   => 'Došlo je do pogreške prilikom obrade tvoje akcije. Pokušaj ponovo i kontaktiraj nas ako se problem nastavi. Poruka o pogrešci: :hint.',
        ],
        'permissions'   => [
            'fields'    => [
                'override'  => 'Pregazi postojeće',
            ],
            'helpers'   => [
                'override'  => 'Ako je uključeno, dopuštenja odabranih entiteta će biti pregažena s ovima. Ako nije uključeno, odabrana dopuštenja će biti dodana postojećim.',
            ],
            'title'     => 'Promijeni dopuštenja za nekoliko entiteta',
        ],
        'success'       => [
            'copy_to_campaign'  => '{1} :count entitet kopiran u :campaign.|{2,4} :count entiteta kopirana u :campaign.|{5,*} :count entiteta kopirano u :campaign.',
            'editing'           => '{1} :count entitet je ažuriran.|[2,4] :count entiteta su ažurirana.|[5, *] :count entiteta je ažurirano.',
            'permissions'       => '{1} Ovlasti promijenjene za :count entitet.|[2,*] Ovlasti promijenjene za :count entiteta.',
            'private'           => '{1} :count entitet je sad privatan.|[2,4] :count entiteta su sad privatna.|[5, *] :count entiteta su sad privatno.',
            'public'            => '{1} :count entitet je sad vidljiv.|[2,4] :count entiteta su sad vidljiva.|[5, *] :count entiteta je sad vidljivo.',
            'templates'         => '{1} :count entitet ima primjenjen predložak.|[2,*] :count entiteta ima primjenjen predložak.',
        ],
    ],
    'bulk_templates'    => [
        'bulk_title'    => 'Primijeni predložak na više entiteta',
    ],
    'cancel'            => 'Otkaži',
    'click_modal'       => [],
    'copy_to_campaign'  => [
        'bulk_title'    => 'Kopiraj entitete u drugu kampanju',
        'panel'         => 'Kopiraj',
        'title'         => 'Kopiraj ":name" u drugu kampanju',
    ],
    'create'            => 'Kreiraj',
    'datagrid'          => [
        'empty' => 'Nema ništa za prikazati.',
    ],
    'delete_modal'      => [
        'title' => 'Izbriši potvrdu',
    ],
    'destroy_many'      => [
        'success'   => 'Obrisano :count entitet|Obrisano :count entiteta.',
    ],
    'edit'              => 'Uredi',
    'errors'            => [
        'boosted_campaigns'     => 'Ova funkcionalnost je dostupna samo za :boosted.',
        'unavailable_feature'   => 'Nedostupna funkcionalnost',
    ],
    'events'            => [],
    'fields'            => [
        'calendar_date'     => 'Datum kalendara',
        'closed'            => 'Zatvoreno',
        'colour'            => 'Boja',
        'copy_abilities'    => 'Kopiraj Sposobnosti',
        'copy_attributes'   => 'Kopiraj atribute',
        'copy_inventory'    => 'Kopiraj Inventar',
        'copy_links'        => 'Kopiraj Poveznice entiteta',
        'creator'           => 'Tvorac',
        'entity'            => 'Entitet',
        'entity_type'       => 'Tip entiteta',
        'entry'             => 'Unos',
        'excerpt'           => 'Isječak',
        'files'             => 'Datoteke',
        'gallery_header'    => 'Zaglavlje galerije',
        'gallery_image'     => 'Slika galerije',
        'has_entity_files'  => 'Ima datoteke entiteta',
        'has_image'         => 'Ima sliku',
        'header_image'      => 'Slika zaglavlja',
        'image'             => 'Slika',
        'is_closed'         => 'Razgovor će biti zatvoren i više neće prihvaćati nove poruke.',
        'is_private'        => 'Privatno',
        'is_star'           => 'Prikvačeno',
        'locations'         => ':first u :second',
        'name'              => 'Naziv',
        'position'          => 'Položaj',
        'privacy'           => 'Privatnost',
        'tooltip'           => 'Kratki opis',
        'type'              => 'Tip',
        'visibility'        => 'Vidljivost',
    ],
    'files'             => [
        'errors'    => [
            'max'       => 'Dosegnut maksimalni broj (:max) datoteka za ovaj entitet.',
            'no_files'  => 'Nema datoteka.',
        ],
        'hints'     => [
            'limit'         => 'Svaki entitet može imati maksimalno  :max datoteka prenesenih na njega.',
            'limitations'   => 'Podržani formati: :formats. Maksimalna veličina datoteke: :size',
        ],
    ],
    'filter'            => 'Filtar',
    'filters'           => [
        'all'               => 'Filtriraj na sve potomke',
        'clear'             => 'Očistite filtre',
        'copy_helper'       => 'Kopirane filtre u međuspremniku koristi kao vrijednosti za filtre na programčićima naslovne ploče i brzim vezama.',
        'copy_to_clipboard' => 'Kopiraj filtre u međuspremnik',
        'direct'            => 'Filtriraj na direktne potomke',
        'filtered'          => 'Prikazuje se :count od :total :entity.',
        'mobile'            => [
            'clear' => 'Očisti',
            'copy'  => 'Međuspremnik',
        ],
        'options'           => [
            'exclude'   => 'Izuzmi',
            'include'   => 'Uključi',
            'none'      => 'Ništa',
        ],
        'show'              => 'Prikaži filtre',
        'sorting'           => [
            'asc'       => ':field uzlazno',
            'desc'      => ':field silazno',
            'helper'    => 'Kontroliraj u kojem se prikazuju rezultati.',
        ],
        'title'             => 'Filteri',
    ],
    'fix-this-issue'    => 'Riješi ovaj problem',
    'forms'             => [
        'actions'       => [
            'calendar'  => 'Dodajte datum kalendara',
        ],
        'copy_options'  => 'Opcije kopiranja',
    ],
    'helpers'           => [
        'copy_options'  => 'Kopiraj sljedeće povezane elemente iz izvora u novi entitet.',
    ],
    'hidden'            => 'Skriveno',
    'hints'             => [
        'attribute_template'    => 'Primijeni predložak atributa izravno prilikom stvaranja ovog entiteta.',
        'calendar_date'         => 'Datum kalendara omogućava jednostavno filtriranje u popisima, također održavajući događaj kalendara u odabranom kalendaru.',
        'image_limitations'     => 'Podržani formati: :formats. Maksimalna veličina datoteke: :size.',
        'is_star'               => 'Prikvačeni elementi pojavit će se na izborniku entiteta',
        'tooltip'               => 'Zamijeni automatski generirani kratki opis sljedećim sadržajem.',
    ],
    'history'           => [
        'unknown'   => 'Nepoznato',
        'view'      => 'Pogledaj zapisnik entiteta',
    ],
    'image'             => [
        'error' => 'Nismo uspjeli dobiti sliku koju ste tražili. Može biti da nam web mjesto ne dopušta preuzimanje slike (uobičajeno za Squarespace i DeviantArt) ili da veza više nije valjana. Provjerite također da slika nije veća od :size.',
    ],
    'is_private'        => 'Ovaj je entitet privatan i vidljiv samo članovima administratorske uloge.',
    'move'              => [],
    'navigation'        => [
        'cancel'    => 'otkaži',
        'or_cancel' => 'ili :cancel',
    ],
    'new_entity'        => [],
    'panels'            => [],
    'permissions'       => [
        'actions'           => [
            'bulk'          => [
                'add'       => 'Dodaj',
                'deny'      => 'Zabrani',
                'ignore'    => 'Ignoriraj',
                'remove'    => 'Ukloni',
            ],
            'bulk_entity'   => [
                'allow'     => 'Dopusti',
                'deny'      => 'Zabrani',
                'inherit'   => 'Naslijedi',
            ],
            'delete'        => 'Brisanje',
            'edit'          => 'Uređivanje',
            'toggle'        => 'Uključi ili isključi',
        ],
        'fields'            => [
            'member'    => 'Član',
            'role'      => 'Uloga',
        ],
        'helpers'           => [
            'setup' => 'Koristi ovo sučelje za detaljno namještanje ovlasti uloga i korisnika za ovaj entitet. :allow će dopustiti korisniku ili ulozi da odradi tu akciju. :deny će zabraniti akciju. :inherit će koristiti ovlasti korisnikove ili glavne uloge. Korisnik kojemu je postavljano :allow, može odrađivati akciju čak i ako uloga čiji je član ima :deny.',
        ],
        'success'           => 'Ovlasti spremljene.',
        'title'             => 'Ovlasti',
        'too_many_members'  => 'Ova kampanja ima previše članova (> 10) za prikaz u ovom sučelju. Upotrijebite gumb Ovlasti na prikazu entiteta za detaljnu kontrolu ovlasti.',
    ],
    'placeholders'      => [
        'ability'       => 'Izaberi sposobnost',
        'calendar'      => 'Izaberi kalendar',
        'character'     => 'Izaberi lika',
        'entity'        => 'Entitet',
        'event'         => 'Izaberi događaj',
        'family'        => 'Izaberi obitelj',
        'gallery_image' => 'Odaberi sliku iz galerije kampanje',
        'image_url'     => 'Umjesto toga možete prenijeti sliku sa URL-a',
        'item'          => 'Izaberi predmet',
        'journal'       => 'Odaberi dnevnik',
        'location'      => 'Izaberi lokaciju',
        'map'           => 'Izaberi kartu',
        'note'          => 'Odaberi bilješku',
        'organisation'  => 'Izaberi organizaciju',
        'quest'         => 'Izaberi zadatak',
        'race'          => 'Izaberi rasu',
        'tag'           => 'Izaberi oznaku',
        'timeline'      => 'Odaberite kronologiju',
    ],
    'relations'         => [],
    'remove'            => 'Ukloni',
    'rename'            => 'Preimenuj',
    'save'              => 'Spremi',
    'save_and_close'    => 'Spremi i zatvori',
    'save_and_copy'     => 'Spremi i kopiraj',
    'save_and_new'      => 'Spremi i kreni na novo',
    'save_and_update'   => 'Spremi i ažuriraj',
    'save_and_view'     => 'Spremi i pogledaj',
    'search'            => 'Pretraži',
    'select'            => 'Odaberi',
    'tabs'              => [
        'abilities'     => 'Sposobnosti',
        'assets'        => 'Imovina',
        'attributes'    => 'Atributi',
        'boost'         => 'Pojačavanje',
        'connections'   => 'Veze',
        'inventory'     => 'Inventar',
        'links'         => 'Poveznice',
        'permissions'   => 'Ovlasti',
        'profile'       => 'Profil',
        'relations'     => 'Odnosi',
        'reminders'     => 'Podsjetnici',
        'story'         => 'Priča',
    ],
    'update'            => 'Ažuriraj',
    'users'             => [
        'unknown'   => 'Nepoznato',
    ],
    'view'              => 'Vidljivost',
    'visibilities'      => [
        'admin'         => 'Administratori',
        'admin-self'    => 'Ja i administratori',
        'all'           => 'Svi',
        'members'       => 'Članovi',
        'self'          => 'Samo ja',
    ],
];
