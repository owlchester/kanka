<?php

return [
    'attribute-templates'   => [
        'answer'    => <<<'TEXT'
Il miglior modo in cui possiamo spiegarti i Template di Attributi è con un esempio. Immaginiamo per esempio che il tuo mondo abbia molti Luoghi e su molti di questi luoghi vuoi ricordarti di creare degli attributi personalizzati per "Popolazione", "Clima", "Livello di Criminalità".

Ora, puoi facilmente farlo su ogni Luogo ma può diventare tedioso e potresti dimenticarti qualche volta di reare l'attributo "Livello di Criminalità". Qui è dove i Template di Attributi entrano in gioco.

Puoi creare un Template di Attributi con questi attributi (Popolazione, Clima, Livello di Criminalità, etc.), e successivamente applicare questo template sui tuoi luoghi. Questo creerà gli attributi del template nel tuo luogo quindi tutto quello che dovrai fare sarà cambiarne i valori e non ricordarti degli attributi da creare!
TEXT
,
        'question'  => 'Templates di Attributi, che cosa sono?',
    ],
    'fields'                => [
        'answer'    => 'Risposta',
        'category'  => 'Categoria',
        'locale'    => 'Locale',
        'order'     => 'Ordine',
        'question'  => 'Domanda',
    ],
    'free'                  => [
        'answer'    => <<<'TEXT'
Sì! Noij crediamo nel fatto che il tuo stato finanziario non deve impattare la gioia del giocare di ruolo o di creare nuovi mondi e così manterremo sempre l'app gratuita. Grazie ai nostri generosi Patrons su Patreon siamo in grado di coprire il costo mensile dei server e mantenere l'app senza pubblicità!

Supportarci su Patreon però ti permette di incrementare il limite di dimensione dei file che puoi caricare, aggiunge il tuo nome al wall of fame dei Patreon, avere delle icone di default più curate, votare per prioritizzare cosa verrà sviluppato ed altro ancora!
TEXT
,
        'question'  => 'L\'app resterà gratuita?',
    ],
    'help'                  => [
        'answer'    => 'Prima di tutto grazie per volerci aiutare! Siamo sempre interessati in persone che possono aiutarci con le traduzioni, nel testare le nuove funzionalità o che possano aiutare i nuovi utenti. Adoriamo anche quando le persone promuovono Kanka per raggiungere nuove utenze in posti a cui non avevamo pensato. La miglior cosa che puoi fare è unirti a noi su Discord dove un canale è dedicato all\'aiuto degli utenti. Adoriamo anche i nostri patrons su Patreon se vuoi supportarci e ottenere l\'accesso a qualche vantaggio!',
        'question'  => 'Voglio aiutare! Cosa posso fare?',
    ],
    'multiworld'            => [
        'answer'    => 'No non ne hai bisogno! Potrai creare tutte le "campagne" che vuoi e fare in modo che rappresentino dei mondi, settings o quello che vorrai. Quando avrai diverse campagne potrai comodamente passare da una all\'altra',
        'question'  => 'Io sto creando diversi mondi in sistemi differenti, necessiterò di un account differente per ogni mondo?',
    ],
    'permissions'           => [
        'answer'    => 'Assolutamente, questo è il perché noi abbiamo creato Kanka! Potrai invitare tutti i tuoi giocatori nella tua campagna ed assegnargli dei ruoli e dei permessi. Abbiamo costruito il tutto per essere estremamente flessibile (tu potrai utilizzare sia sia una configurazione opt-in che una opt-out) per coprire il maggiorn numero possibile di bisogni e situazioni.',
        'question'  => 'Io voglio utilizzare Kanka per costruire il mondo del mio RPG, ma voglio che i miei giocatori abbiano accesso ad alcune delle entità e possano modificare i loro personaggi. È possibile?',
    ],
    'show'                  => [
        'return'    => 'Ritorna alle FAQ',
        'timestamp' => 'Ultimo aggiornamento: date',
        'title'     => 'FAQ :name',
    ],
    'visibility'            => [
        'answer'    => 'Solo le persone che hai invitato alla tua campagna potranno vedere ed interagire con quello che hai creato. I tuoi dati sono provati e sempre sotto il tuo controllo.',
        'question'  => 'Chiunque può vedere il mio mondo?',
    ],
];
