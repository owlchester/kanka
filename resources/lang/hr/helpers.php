<?php

return [
    'age'           => [
        'description'   => 'Možeš povezati Lika s kalendarom kampanje tako da pogledaš Lika i otvoriš karticu Podsjetnici. Odatle dodaj novi podsjetnik i postavi vrstu na Rođenje ili Smrt kako bi se dob lika automatski izračunala. Ako su prisutni i rođenje i smrt, prikazat će se oba datuma i dob pri smrti. Ako je postavljeno samo rođenje, prikazat će se datum i trenutna dob. Ako se postavi samo smrt, prikazat će se datum i godine od smrti.',
        'title'         => 'Dob i smrt lika',
    ],
    'attributes'    => [
        'con'           => 'Konstitucija',
        'description'   => 'Upotrijebi atribute za predstavljanje vrijednosti pridruženih entitetu koji nije tekst. Entitete možete referencirati u atributima koristeći naprednu sintaksu spominjanja :mention. Također se možete pozivati ​​na druge atribute koristeći sintaksu :attribute.',
        'level'         => 'Razina',
        'link'          => 'Opcije atributa',
        'math'          => 'Možeš kreativno koristiti i neke osnovne matematičke operacije. Na primjer, :example će pomnožiti atribute entiteta :level and :con. Ako želite zaokružiti prema gore ili dolje, možete koristiti :floor ili :ceil',
        'title'         => 'Atributi',
    ],
    'dice'          => [
        'description'               => 'Generičko bacanje kockica je moguće pisanjem "d20", "4d4 + 4", "d%" za postotak i "df" za gluposti.',
        'description_attributes'    => 'Također je moguće dobiti atribut lika koristeći sintaksu {lik.naziv_atributa}. Na primjer, {lik.level}d6+{lik.mudrost}.',
        'more'                      => 'Dodatne mogućnosti dostupne su i objašnjene na stranici s dodatkom za bacanje kockica.',
        'title'                     => 'Bacanje kockica',
    ],
    'filters'       => [
        'description'   => 'Pomoću filtara možeš ograničiti količinu rezultata prikazanih na popisima. Tekstualna polja podržavaju različite opcije za daljnju kontrolu onoga što je filtrirano.',
        'empty'         => 'Pisanje :tag u polju pretražit će sve entitete u kojima je ovo polje prazno.',
        'ending_with'   => 'Postavljanjem :tag na kraju teksta možeš potražiti svaki entitet s točno ovim tekstom u polju.',
        'session'       => 'Filtri i posloženi stupci postavljeni za popis entiteta spremaju se u sesiju, tako da sve dok ostaneš povezan ne moraš ih ponovno postavljati na svaku stranicu.',
        'starting_with' => 'Postavljanjem :tag ispred svog teksta možeš pretražiti sve što ne sadrži taj tekst u polju.',
        'title'         => 'Kako koristiti filtre',
    ],
    'link'          => [
        'attributes'        => 'Atribute entiteta možeš referencirati upisivanjem :code. Ovo radi samo za postojeće atribute entiteta.',
        'auto_update'       => 'Poveznice do drugih entiteta se automatski ažuriraju kada se promijeni ime ili opis cilja.',
        'description'       => 'Možeš se jednostavno povezati s drugim entitetima u kampanji pomoću sljedećih kratica.',
        'formatting'        => [
            'text'  => 'Popis dopuštenih HTML oznaka i atributa može se vidjeti na našem :github.',
            'title' => 'Oblikovanje',
        ],
        'friendly_mentions' => 'Poveži s drugim entitetima tako da upišeš :code i prvih nekoliko znakova entiteta da ga potražiš. Ovo će umetnuti :example u uređivač teksta i prikazat će se kao poveznica do entiteta prilikom pregleda navedenog entiteta.',
        'limitations'       => 'Imaj na umu da zbog tehničkih ograničenja ove skraćenice ne rade na Android mobilnim uređajima.',
        'mentions'          => 'Poveži s drugim entitetima tako da upišeš :code i prvih nekoliko znakova entiteta da ga potražiš. Ovo će umetnuti :example u uređivač teksta. Za prilagodbu imena prikazanog entiteta, možeš uptikati :example_name. Kako bi postavio podstranicu entiteta, koristi :example_page. Kako bi postavio karticu entiteta, koristi :example_tab.',
        'months'            => 'Upiši :code da dobiješ popis mjeseci iz svojih kalendara.',
        'title'             => 'Povezivanje s ostalim unosima i prečacima',
    ],
    'map'           => [
        'description'   => 'Učitavanje karte na lokaciju omogućit će izbornik "Karta" na stranici prikaza lokacije, te izravnu vezu na kartu sa stranice lokacije kampanje. Iz prikaza karte korisnici koji mogu uređivati lokaciju mogu aktivirati "Način uređivanja" koji im omogućuje postavljanje točaka karte na kartu. One se mogu povezati s postojećim entitetom ili biti natpis, i imati različite oblike i veličine.',
        'private'       => 'Članovi u administrativnoj ulozi kampanje mogu kartu učiniti privatnom. To omogućuje korisnicima da pregledaju lokaciju, ali administratorima da kartu čuvaju u tajnosti.',
        'title'         => 'Karte lokacije',
    ],
    'public'        => 'Pogledajte Youtube vodič na koji objašnjava javne kampanje.',
    'title'         => 'Pomagači',
];
