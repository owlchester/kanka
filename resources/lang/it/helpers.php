<?php

return [
    'description'   => 'Qualche consiglio utile per aiutarti',
    'dice'          => [
        'description'               => 'E\' possibile creare tiri di dado generici scrivendo "d20", "4d4+4", "d%" per la percentuale e "df" per fudge.',
        'description_attributes'    => 'E\' anche possibile usare un attributo di un personaggio usando la sintassi {character.attribute_name}. Per esempio: {character.level}d6+{character.wisdom}.',
        'more'                      => 'Altre opzioni sono disponibili e spiegate nella pagina dei tiri di dado.',
        'title'                     => 'Tiri di Dado',
    ],
    'link'          => [
        'auto_update'   => 'I collecamenti alle altre entità saranno aggiornati automaticamente quando il nome o la descrizione dell\'entità collegata saranno aggiornate.',
        'description'   => 'Puoi facilmente linkare altre entità scrivendo \'@\'. Puoi anche scrivere \'#\' per avere una lista di mesi del tuo calendario.',
        'title'         => 'Linkando ad altre entità e scorciatoie',
    ],
    'map'           => [
        'description'   => 'Caricare una mappa ad un luogo abiliterà il menù `Mappa` nella pagina di visualizzazione del luogo ed un link diretto alla mappa dalla pagina dei luoghi della campgna. Dalla visualizzazione della mappa le utenze con il permesso di modifica del luogo potranno attivare la \'Modalità di modifica\' che gli permetterà di agiungere dei Segnalibri sulla mappa. Questi potranno avere differenti forme e dimensioni ed essere collegati ad un\'entità esistente o essere delle etichette.',
        'private'       => 'Gli amministratori della campagna possono rendere una mappa privata. Questo permette alle utenze di vedere il luogo e per gli amministratori di mantere la mappa segreta.',
        'title'         => 'Mappe del luogo',
    ],
    'public'        => 'Guarda un tutorial su Youtube sulle campagne pubbliche.',
    'title'         => 'Aiuti',
];
