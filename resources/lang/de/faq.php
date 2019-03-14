<?php

return [
    'attribute-templates'   => [
        'answer'    => <<<'TEXT'
Die beste Art Attributvorlagen zu erklären, ist mit einem Beispiel. Stellen wir uns, dass deine Welt eine Menge Orte hat. Für viele dieser Orte möchtest du eigene Attribute wie "Bewohnerzahl", "Klima" und "Kriminalitätsgrad" haben.

Nun kannst du diese Attribute in jedem Ort einzeln hinzufügen, das wird aber schnell mühsam und manchmal vergisst man das Attribut "Kriminalitätsgrad" zu hinterlegen. Hier kommen die Attributvorlagen zum Einsatz.

Du kannst eine Attributvorlage mit deinen Attributen "Bewohnerzahl", "Klima" und "Kriminalitätsgrad" füllen und später diese Vorlage bei deinen Orten benutzen. Das wird die Attribute der Vorlage automatisch in dem Ort hinterlegen und du musst nur noch die Werte der Attribute füllen!
TEXT
,
        'question'  => 'Attributvorlagen, was sind die?',
    ],
    'fields'                => [
        'answer'    => 'Antwort',
        'category'  => 'Kategorie',
        'question'  => 'Frage',
    ],
    'free'                  => [
        'answer'    => <<<'TEXT'
Ja! Wir glauben, dass unsere finanzielle Situation keinen Einfluss auf euer Vergnügen beim Rollenspiel oder beim Welten bauen haben sollte, weswegen wir die App immer kostenfrei halten werden. Dank unserer großzügigen Patrone auf :patreon, ist es uns möglich die monatlichen Serverkosten zu bezahlen und die Plattform werbefrei zu halten!

Uns auf Patreon zu unterstützen ermöglicht es euch allerdings das Upload Limit von Dateien zu erhöhen, euer Name kommt auf die Patreon Wall of Fame, ihr bekommt schönere Standard Icons, könnt abstimmen was bei der Weiterentwicklung prioritisiert werden soll und mehr!
TEXT
,
        'question'  => 'Wird die App kostenfrei bleiben?',
    ],
    'help'                  => [
        'answer'    => 'Als Erstes: Danke, dass du helfen möchtest! Wir sind immer an Leuten interessiert, die uns bei Übersetzungen unterstützen, neue Funktionen testen oder die neuen Usern helfen können. Wir lieben es auch wenn Leute Kanka weiterempfehlen, um neue User an Orten zu erreichen an die wir nicht gedacht haben. Am besten ist es, wenn du auf :discord zu uns stößt, wo es einen Kanal für\'s Aushelfen gibt. Wir lieben auch unsere Patrone auf Patreon, wenn du uns unterstützen möchtest und ein paar Extras bekommen möchtest!',
        'question'  => 'Ich möchte helfen! Was kann ich tun?',
    ],
    'multiworld'            => [
        'answer'    => 'Nein, brauchst du nicht! Du kannst so viele "Kampagnen" in der App haben, wie du möchtest. Jede Kampagne kann für eine Welt, ein Setting oder was immer du willst genutzt werden. Sobald du mehrere Kampagnen hast, kannst du einfach zwischen ihnen wechseln.',
        'question'  => 'Ich baue mehrere Welten in verschiedenen Settings auf. benötige ich für jede Welt einen anderes Konto?',
    ],
    'permissions'           => [
        'answer'    => 'Ja absolut, deswegen haben wir Kanka gemacht! Du kannst all deine Spieler zu deiner Kampagne einladen und ihnen Rollen und Berechtigungen erteilen.  Wir haben das System für  große Flexibiliät gebaut (sowohl opt-in als auch opt-out Konfigurationen möglich), um so viele Ansprüche und Situationen wie möglich abzudecken.',
        'question'  => 'Ich möchte Kanka nutzen, um meine RPG Welt aufzubauen. Meinen Spielern möchte ich ermöglichen manche Objekte und ihre Charakter zu bearbeiten. Geht das?',
    ],
    'show'                  => [
        'return'    => 'Zurück zum FAQ',
        'timestamp' => 'Letzte Aktualisierung am :date',
        'title'     => 'FAQ :name',
    ],
    'visibility'            => [
        'answer'    => 'Nur die Leute, die du zu deiner Kampagne eingeladen hast, können deine Welt sehen und bearbeiten. Deine Daten sind privat und immer unter deiner Kontrolle.',
        'question'  => 'Kann jeder meine Welt sehen?',
    ],
];
