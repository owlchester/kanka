<?php

return [
    'description'   => 'Nekoliko korisnih savjeta i trikova koji će ti pomoći',
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
        'auto_update'       => 'Poveznice do drugih entiteta se automatski ažuriraju kada se promijeni ime ili opis cilja.',
        'description'       => 'Možeš se jednostavno povezati s drugim entitetima u kampanji pomoću sljedećih kratica.',
        'friendly_mentions' => 'Poveži s drugim entitetima tako da upišeš :code i prvih nekoliko znakova entiteta da ga potražiš. Ovo će umetnuti :example u uređivač teksta i prikazat će se kao poveznica do entiteta prilikom pregleda navedenog entiteta.',
        'limitations'       => 'Imaj na umu da zbog tehničkih ograničenja ove skraćenice ne rade na Android mobilnim uređajima.',
        'mentions'          => 'Poveži s drugim entitetima tako da upišeš :code i prvih nekoliko znakova entiteta da ga potražiš. Ovo će umetnuti :example u uređivač teksta. Za prilagodbu imena prikazanog entiteta, možeš uptikati :example_name. Kako bi postavio podstranicu entiteta, koristi :example_page. Kako bi postavio karticu entiteta, koristi :example_tab.',
        'months'            => 'Upiši :code da dobiješ popis mjeseci iz svojih kalendara.',
        'title'             => 'Povezivanje s ostalim unosima i prečacima',
    ],
    'map'           => [
        'description'   => 'Učitavanje karte na lokaciju omogućit će izbornik "Karta" na stranici prikaza lokacije, te izravnu vezu na kartu sa stranice lokacije kampanje. Iz prikaza karte korisnici koji mogu uređivati lokaciju mogu aktivirati "Način uređivanja" koji im omogućuje postavljanje točaka karte na kartu. One se mogu povezati s postojećim entitetom ili biti labela, i imati različite oblike i veličine.',
        'private'       => 'Članovi u administrativnoj ulozi kampanje mogu kartu učiniti privatnom. To omogućuje korisnicima da pregledaju lokaciju, ali administratorima da kartu čuvaju u tajnosti.',
        'title'         => 'Karte lokacije',
    ],
    'public'        => 'Pogledajte Youtube vodič na koji objašnjava javne kampanje.',
    'title'         => 'Pomagači',
];
