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
    'conversations'         => [
        'answer'    => 'Le conversazioni possono essere impostate come discorsi fra Personaggio o fra Membri della Campagna. Se, per esempio, volessi documentare un\'importante discorso tra NPCs e PCs lo potresti fare utilizzando questo modulo. You puoi utilizzare anche per le campagna play-by-post.',
        'question'  => 'Che cosa sono le Conversazioni?',
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
    'map'                   => [
        'answer'    => <<<'TEXT'
Ogno luogo può contenere una mappa (png, jpg o svg) con all'interno dei "punti della mappa" che possono essere posizionati controllandone la dimensione, la forma, l'icona ed il colore impostandoli come collegamenti ad altre entità o semplici etichette.

Per favore considerate che le mappe prodotte da tool popolari come Azgaar e Medieval Fantasy Town Generator comprimono iol file generato rendendoli incompatibili con Kanka. Un fix è quello di aprire il file con Inkscape o Photoshop e salvarlo nuovamente prima di caricarlo su Kanka.
TEXT
,
        'question'  => 'Posso caricare delle mappe su Kanka?',
    ],
    'mobile'                => [
        'answer'    => 'Attualmente non vi è nessuna app mobile per Kanka ma la maggior parte delle funzionalità funzionano anche su di un dispositivo mobile. Una limitazione è lo strumento di menzione che non funziona nell\'editor testuale. Se il supporto su Patreon lo permetterà, spero un giorno di riuscire a pagare qualcuno per fare l\'app mobile ma non prevedo che succederà a breve.',
        'question'  => 'C\'è un\'app mobile? È pianificata?',
    ],
    'multiworld'            => [
        'answer'    => 'No non ne hai bisogno! Potrai creare tutte le "campagne" che vuoi e fare in modo che rappresentino dei mondi, settings o quello che vorrai. Quando avrai diverse campagne potrai comodamente passare da una all\'altra',
        'question'  => 'Io sto creando diversi mondi in sistemi differenti, necessiterò di un account differente per ogni mondo?',
    ],
    'permissions'           => [
        'answer'    => 'Assolutamente, questo è il perché noi abbiamo creato Kanka! Potrai invitare tutti i tuoi giocatori nella tua campagna ed assegnargli dei ruoli e dei permessi. Abbiamo costruito il tutto per essere estremamente flessibile (tu potrai utilizzare sia sia una configurazione opt-in che una opt-out) per coprire il maggiorn numero possibile di bisogni e situazioni.',
        'question'  => 'Io voglio utilizzare Kanka per costruire il mondo del mio RPG, ma voglio che i miei giocatori abbiano accesso ad alcune delle entità e possano modificare i loro personaggi. È possibile?',
    ],
    'plans'                 => [
        'answer'    => <<<'TEXT'
I piani a lungo termine per Kanka sono di creare un versatile strumento di gestione delle campagne e di creazione di mondi che sia indipendente dal sistema utilizzato con contenuti specifici per il systema gestiti dalla comunità nella forma di "Template della Comunità". Un traguardo successivo sarà quello di realezzare uno strumento che possa integrarsi con altre piattaforma come Virtual Table Top per collegarle con i mondi su Kanka.

Per quanto riguarda la seconda parte la maggior parte dei progetti obbistici finiscono per mancanza di fondi e con il creatore che li abbandona. Il Patreon è stato pensato per fare in modo che possa ridurre le mie ore lavorative per dedicare più tempo a Kanka senza sacrificare la sicurezza finanziaria della mia famiglia e per coprire i costi del server. Il progetto è anche open source e potrà essere gestito dalla comunità se quelcosa dovesse mai succedermi. I dati di ogni campagna possono essere esportati dall'amministratore della stessa una volta al giorno in caso fossi preoccupato per la possibilità di perdere tutti i tuoi contenuti.
TEXT
,
        'question'  => 'Quali sono i piani a lungo termine? Cosa succederebbe se Ilestis si stufasse di lavorare su Kanka?',
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
