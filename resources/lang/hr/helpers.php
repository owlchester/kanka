<?php

return [
    'age'               => [
        'description'   => 'Možeš povezati Lika s kalendarom kampanje tako da pogledaš Lika i otvoriš karticu Podsjetnici. Odatle dodaj novi podsjetnik i postavi vrstu na Rođenje ili Smrt kako bi se dob lika automatski izračunala. Ako su prisutni i rođenje i smrt, prikazat će se oba datuma i dob pri smrti. Ako je postavljeno samo rođenje, prikazat će se datum i trenutna dob. Ako se postavi samo smrt, prikazat će se datum i godine od smrti.',
        'title'         => 'Dob i smrt lika',
    ],
    'attributes'        => [
        'con'               => 'Konstitucija',
        'description'       => 'Upotrijebi atribute za predstavljanje vrijednosti pridruženih entitetu koji nije tekst. Entitete možete referencirati u atributima koristeći naprednu sintaksu spominjanja :mention. Također se možete pozivati ​​na druge atribute koristeći sintaksu :attribute.',
        'level'             => 'Razina',
        'link'              => 'Opcije atributa',
        'math'              => 'Možeš kreativno koristiti i neke osnovne matematičke operacije. Na primjer, :example će pomnožiti atribute entiteta :level and :con. Ako želite zaokružiti prema gore ili dolje, možete koristiti :floor ili :ceil',
        'name'              => 'Možeš referencirati naziv entiteta s :name. Ako postoji atribut s time imenom, atribut će se koristiti umjesto entiteta.',
        'pinned'            => 'Prikvačivanje atributa pomoću ikone :icon prikazat će ga u izborniku entiteta ispod njegove slike.',
        'private'           => 'Privatni atributi koji koriste :icon učinit će ih vidljivima samo administratorima kampanje.',
        'random'            => 'Prilikom izrade ili uređivanja predloška atributa možeš postaviti nasumične atribute. To može biti nasumična vrijednost između dva broja odvojena :dash ili nasumična vrijednost s popisa vrijednosti odvojenih :comma. Vrijednost atributa određuje se kada se predložak primijeni na entitet ili kada se entitet spremi.',
        'random_examples'   => 'Na primjer, ako želiš broj između 1 i 100, upotrijebite :number. Ako želiš vrijednost s popisa opcija, upotrijebi :list.',
        'title'             => 'Atributi',
    ],
    'dice'              => [
        'description'               => 'Generičko bacanje kockica je moguće pisanjem "d20", "4d4 + 4", "d%" za postotak i "df" za gluposti.',
        'description_attributes'    => 'Također je moguće dobiti atribut lika koristeći sintaksu {lik.naziv_atributa}. Na primjer, {lik.level}d6+{lik.mudrost}.',
        'more'                      => 'Dodatne mogućnosti dostupne su i objašnjene na stranici s dodatkom za bacanje kockica.',
        'title'                     => 'Bacanje kockica',
    ],
    'entity_templates'  => [
        'description'   => 'Prilikom stvaranja novih entiteta, možeš stvoriti entitet na temelju predloška, umjesto započinjanja s praznim obrascem. Da bi postavio entitet kao predložak, pregledaj ga i klikni na :link u gumbu akcija :action u gornjem desnom kutu. Prilikom pregledavanja popisa entiteta, predlošci te vrste entiteta bit će dostupni pored gumba :new. Možeš imati više predložaka za svaku vrstu entiteta.',
        'link'          => 'Kako postaviti predloške',
        'remove'        => 'Da bi uklonio/la entitet kao predložak, klikni akciju :remove koja zamjenjuje gore opisanu radnju :link.',
        'title'         => 'Predlošci entiteta',
    ],
    'filters'           => [
        'clipboard'     => 'Kad su filtri aktivni, gumb za kopiranje u međuspremnik postaje aktivan. Ovo kopira filtre u tvoj međuspremnik, a možeš ih koristiti za filtre programčića naslovne ploče ili za brze veze.',
        'description'   => 'Pomoću filtara možeš ograničiti količinu rezultata prikazanih na popisima. Tekstualna polja podržavaju različite opcije za daljnju kontrolu onoga što je filtrirano.',
        'empty'         => 'Pisanje :tag u polju pretražit će sve entitete u kojima je ovo polje prazno.',
        'ending_with'   => 'Postavljanjem :tag na kraju teksta možeš potražiti svaki entitet s točno ovim tekstom u polju.',
        'multiple'      => 'Opcije pretraživanja u tekstualnim poljima možeš kombinirati tako da napišeš :syntax. Na primjer :example.',
        'session'       => 'Filtri i posloženi stupci postavljeni za popis entiteta spremaju se u sesiju, tako da sve dok ostaneš povezan ne moraš ih ponovno postavljati na svaku stranicu.',
        'starting_with' => 'Postavljanjem :tag ispred svog teksta možeš pretražiti sve što ne sadrži taj tekst u polju.',
        'title'         => 'Kako koristiti filtre',
    ],
    'link'              => [
        'auto_update'       => 'Poveznice do drugih entiteta se automatski ažuriraju kada se promijeni ime ili opis cilja.',
        'description'       => 'Možeš se jednostavno povezati s drugim entitetima u kampanji pomoću sljedećih kratica.',
        'formatting'        => [
            'text'  => 'Popis dopuštenih HTML oznaka i atributa može se vidjeti na našem :github.',
            'title' => 'Oblikovanje',
        ],
        'friendly_mentions' => 'Poveži s drugim entitetima tako da upišeš :code i prvih nekoliko znakova entiteta da ga potražiš. Ovo će umetnuti :example u uređivač teksta i prikazat će se kao poveznica do entiteta prilikom pregleda navedenog entiteta.',
        'mention_helpers'   => 'Ako ime entiteta ima razmak, umjesto razmaka upotrijebi :example. Ako želiš potražiti entitet s točno tim imenom, upiši :exact.',
        'mentions'          => 'Poveži s drugim entitetima tako da upišeš :code i prvih nekoliko znakova entiteta da ga potražiš. Ovo će umetnuti :example u uređivač teksta. Za prilagodbu imena prikazanog entiteta, možeš uptikati :example_name. Kako bi postavio podstranicu entiteta, koristi :example_page. Kako bi postavio karticu entiteta, koristi :example_tab.',
        'mentions_field'    => 'Također možeš prikazati polje entiteta umjesto njegovog imena u poveznici s :code.',
        'months'            => 'Upiši :code da dobiješ popis mjeseci iz svojih kalendara.',
        'options'           => 'Neke mogućnosti su :options.',
        'title'             => 'Povezivanje s ostalim unosima i prečacima',
    ],
    'map'               => [],
    'pins'              => [
        'description'   => 'Entiteti mogu imati odnose i atribute prikvačene s desne strane pogleda na priču. Da bi prikvačio/la element, idi i uredi relaciju ili atribute i postavi prikvačenu vrijednost na njih.',
        'title'         => 'Prikvačeno za entitet',
    ],
    'public'            => 'Pogledajte Youtube vodič na koji objašnjava javne kampanje.',
    'widget-filters'    => [
        'description'   => 'Možeš filtrirati entitete prikazane na programčiću s nedavno izmijenjenim entitetima pružajući popis polja entiteta i vrijednosti. Na primjer, možeš koristiti :example za filtriranje mrtvih likova s kojima igrači ne mogu igrati (NPC).',
        'link'          => 'Filteri programčića',
        'more'          => 'Možeš kopirati vrijednosti iz URL-a na popise entiteta. Na primjer, prilikom pregledavanja znakova kampanje, filtriraj vrstu znakova koje želiš prikazati i kopiraj vrijednosti nakon :question u URL-u.',
        'title'         => 'Filteri programčića naslovne ploče',
    ],
];
