<?php

return [
    'app_backup'            => [
        'answer'    => 'We maken twee back-ups per dag om dataverlies te voorkomen. Onze eigen campaigns staan op de server, dus we willen geen enkel risico nemen!',
        'question'  => 'Hoe vaak wordt er een back-up gemaakt van de gegevens op Kanka?',
    ],
    'attribute-templates'   => [
        'answer'    => <<<'TEXT'
De beste manier waarop we attribuutsjablonen kunnen uitleggen, is met een voorbeeld. Stel dat je wereld veel locaties heeft en dat je op veel van die locaties een aangepast Attribuut wilt maken voor "Bevolking", "Klimaat", "Misdaadniveau".

Nu zou je dat gemakkelijk op elke locatie kunnen doen, maar het kan vervelend worden, en je zou soms kunnen vergeten om het attribuut "Misdaadniveau" aan te maken. Dit is waar attribuutsjablonen in het spel komen.

Je kunt een Attribuutsjabloon maken met die attributen (bevolking, klimaat, misdaadniveau, enz.), En die sjabloon later op je locaties toepassen. Hiermee worden de attributen van de sjabloon op de locaties gemaakt, dus het enige wat je hoeft te doen is de waarden te wijzigen en de attributen niet te onthouden!
TEXT
,
        'question'  => 'Attribuutsjablonen, wat zijn dat?',
    ],
    'backup'                => [
        'answer'    => 'Een keer per dag kun je al je campaign gegevens exporteren als een ZIP-bestand. Klik in de app op "Campaign" in het linkermenu en klik op "Exporteren". Hierdoor wordt een export gemaakt die 30 minuten beschikbaar is. Je kunt deze export niet uploaden naar Kanka, het is alleen bedoeld voor je eigen gemoedsrust of als je niet langer van plan bent de app te gebruiken.',
        'question'  => 'Hoe kan ik een back-up maken van mijn campaign of deze exporteren?',
    ],
    'bugs'                  => [
        'answer'    => 'Word gewoon lid van onze :discord server en meld je bug in het  #error-and-bugs kanaal.',
        'question'  => 'Hoe kan ik een bug melden?',
    ],
    'campaign-sync'         => [
        'answer'    => 'Kanka heeft deze functie niet. Als je echter meerdere speelgroepen in dezelfde wereld probeert te hebben, overweeg dan om dezelfde campaign te gebruiken en je groepen te scheiden door een combinatie van speurtochten, tags en permissies',
        'question'  => 'Kan ik entiteiten over meerdere campagnes synchroniseren?',
    ],
    'conversations'         => [
        'answer'    => 'Conversaties kunnen worden opgezet als gesprekken tussen Personages of tussen Campaign Leden. Als je bijvoorbeeld een belangrijk gesprek tussen NPC\'s en de PC\'s wilt documenteren, kun je dat doen met deze module. Je kunt ze ook gebruiken voor campaigns per post.',
        'question'  => 'Wat zijn conversaties?',
    ],
    'custom'                => [
        'answer'    => 'Kanka wordt geleverd met een set vooraf gedefinieerde entiteit typen die met elkaar communiceren. Om aangepaste entiteit typen toe te staan, zou de app helemaal opnieuw moeten worden opgebouwd en zou het doel van een tool met vooraf gedefinieerde typen om mensen te helpen met worldbuilding teniet doen, in plaats van uit te zoeken hoe ze dingen moeten organiseren. Bovendien is Kanka flexibel met Tags die de meeste scenario\'s van het type entiteit kunnen vertegenwoordigen.',
        'question'  => 'Kan ik aangepaste entiteit typen maken?',
    ],
    'delete-campaign'       => [
        'answer'    => 'Ga naar je campaign dashboard en klik op \'Campaign\' in het linkermenu. Er verschijnt een campaign knop "Verwijderen" als je het laatste lid van de campaign bent. Het verwijderen van een campaign is een permanente actie waarbij alle gegevens die op onze servers zijn opgeslagen, inclusief afbeeldingen, worden verwijderd.',
        'question'  => 'Hoe kan ik een campaign verwijderen?',
    ],
    'early-access'          => [
        'answer'    => 'Early Access is voor ons een manier om onze geweldige abonnees te belonen door ze een exclusieve periode van 30 dagen te geven waarin ze de nieuwste modules kunnen uitproberen voor iemand anders.',
        'question'  => 'Wat is Early Access?',
    ],
    'entity-notes'          => [
        'answer'    => 'Alle entiteiten hebben een tabblad \'Entiteit Notities\'. Dit zijn kleine tekstfragmenten die kunnen worden ingesteld om alleen zichtbaar te zijn voor jou (handig bij co-dming), alleen voor leden van de beheerdersrol of zichtbaar voor iedereen. Je kunt je spelers ook toestemming geven om entiteit notities voor entiteiten te maken en te bewerken zonder dat ze een hele entiteit hoeven te bewerken.',
        'question'  => 'Hoe gaat Kanka om met gedeeltelijk verborgen informatie?',
    ],
    'fields'                => [
        'answer'    => 'Antwoord',
        'category'  => 'Categorie',
        'locale'    => 'Locale',
        'order'     => 'Volgorde',
        'question'  => 'Vraag',
    ],
    'free'                  => [
        'answer'    => <<<'TEXT'
Ja! We zijn ervan overtuigd dat je financiële situatie geen invloed mag hebben op je plezier in RPG's of worldbuilding en we zullen de kernapp altijd gratis houden. Als je echter een actievere rol op deze reis wilt spelen, ons wilt steunen en wilt stemmen over de functies die voor jou het belangrijkst zijn, kun je dit doen via onze abonnementen.

Naast het stemmen over de richting die Kanka inslaat, kun je door ons te steunen toegang krijgen tot :boosters, uploadlimieten voor bestandsgrootte verhogen, je naam toevoegen aan de hall of fame, mooiere standaard pictogrammen en meer!
TEXT
,
        'question'  => 'Blijft de app gratis?',
    ],
    'gods-and-religions'    => [
        'answer'    => 'We raden aan om Goden als Parakters te creëren en religies te creëren als Organisaties. Als je snel je goden wilt vinden, raden we je aan ze te taggen met een geschikte tag en / of type.',
        'question'  => 'Waar kun je goden en religies creëren?',
    ],
    'help'                  => [
        'answer'    => 'Allereerst bedankt dat je wilt helpen! We zijn altijd geïnteresseerd in mensen die kunnen helpen met vertalingen, nieuwe functies kunnen testen of die nieuwe gebruikers kunnen helpen. We vinden het ook geweldig als mensen Kanka promoten om nieuwe gebruikers te bereiken op plaatsen waar we niet aan hadden gedacht. Je beste manier van handelen is om je bij ons aan te sluiten op de :discord, waar een kanaal is toegewijd om te helpen.',
        'question'  => 'Hoe kan ik helpen?',
    ],
    'map'                   => [
        'answer'    => 'De Kaarten module ondersteunt PNG-, JPG- en SVG-afbeeldingen. Deze kaarten kunnen lagen, groepen en markeringen hebben die verschillende vormen en maten hebben die naar andere entiteiten in een campaign verwijzen.',
        'question'  => 'Kan ik kaarten uploaden naar Kanka?',
    ],
    'mobile'                => [
        'answer'    => 'Er is momenteel geen speciale mobiele app voor Kanka, maar de meeste functies van de app werkt op een mobiel apparaat. We hopen dat we dankzij de ondersteuning via abonnementen ooit iemand kunnen betalen om een mobiele app te bouwen, maar voorzien dat niet in de nabije toekomst.',
        'question'  => 'Is er een mobiele app? Is er een gepland?',
    ],
    'monsters'              => [
        'answer'    => 'We raden aan om de Rassen module te gebruiken voor mensen, soorten, monsters en alles wat leeft dat geen personage is.',
        'question'  => 'Waar monsters te maken?',
    ],
    'multiworld'            => [
        'answer'    => 'Je kunt deelnemen aan zoveel campaigns als je wilt, inclusief de campaigns die je hebt gemaakt. Om over te schakelen of een nieuwe campaign te maken, ga je naar je campaign dashboard en kun je rechtsboven op je huidige campaign klikken om de interface van de campaign wisselaar weer te geven.',
        'question'  => 'Kan ik meer dan één campaign hebben?',
    ],
    'nested'                => [
        'answer'    => 'Als je jouw entiteiten liever standaard in een geneste weergave bekijkt (in bijvoorbeeld de knop Geneste Weergave in de lijst met locaties), kun je dit doen door naar je Profiel- en Lay-out opties te gaan. Daar kun je de optie Geneste Weergave controleren. Dit is alleen voor jouw account en niet voor je campaigns.',
        'question'  => 'Kan ik instellen dat de lijsten standaard worden genest?',
    ],
    'permissions'           => [
        'answer'    => 'Absoluut, daarom hebben we Kanka gebouwd! Je kunt al je spelers voor je campaigns uitnodigen en hen rollen en permissies geven. We hebben het systeem zo gebouwd dat het uiterst flexibel is (je kunt zowel een opt-in- als een opt-out-configuratie gebruiken) om in zoveel mogelijk behoeften en situaties te voorzien.',
        'question'  => 'Kan ik de informatie beperken die mijn spelers in mijn campagne zien?',
    ],
    'plans'                 => [
        'answer'    => <<<'TEXT'
Het langetermijnplan voor Kanka is om een veelzijdige tool voor worldbuilding en campaign beheer te bouwen die systeemonafhankelijk is met inhoud die wordt beheerd door de gemeenschap in de vorm van "Community Sjablonen". Een ander doel van ons is om tools te bouwen die kunnen worden geïntegreerd met andere platforms, zoals Virtual Tabletop apps.

We gebruiken Kanka zelf, dus we hebben geen plannen om ooit te stoppen met het ontwikkelen en verbeteren ervan. Voor de zekerheid is het project echter ook open source en kan het worden opgepikt door de community als er ooit iets met ons zou gebeuren.
TEXT
,
        'question'  => 'Wat zijn de langetermijnplannen?',
    ],
    'public-campaigns'      => [
        'answer'    => 'Je kunt bladeren op de :public-campaigns pagina om te zien hoe anderen Kanka gebruiken voor hun campaigns.',
        'question'  => 'Hoe gebruiken anderen Kanka?',
    ],
    'renaming-modules'      => [
        'answer'    => 'Standaard staat Kanka je niet toe de naam van modules te wijzigen. Dit komt door de grammaticale correctheid en gebruikerservaringen voor talen die gendergerelateerde woorden gebruiken. Een boosted campaign kan echter de naam van modules in de zijbalk wijzigen door Aangepaste CSS te gebruiken.',
        'question'  => 'Kan ik modules hernoemen? Bijvoorbeeld Families in Clans, of Organisaties in Facties?',
    ],
    'sections'              => [
        'community'     => 'Community',
        'general'       => 'Algemeen',
        'other'         => 'Andere',
        'permissions'   => 'Permissies',
        'pricing'       => 'Prijzen',
        'worldbuilding' => 'Worldbuilding',
    ],
    'show'                  => [
        'return'    => 'Ga terug naar de FAQ',
        'timestamp' => 'Laatst bijgewerkt :date',
        'title'     => 'FAQ :name',
    ],
    'unboost'               => [
        'answer'    => 'Als je een campaign boost ongedaan maakt, worden geen gegevens verwijderd die tijdens de boost zijn gemaakt, maar worden alleen de informatie en functies verborgen. Als je een campaign opnieuw een boost geeft, zijn de informatie en functies weer beschikbaar met dezelfde instellingen als voordat je een campaign boost ongedaan maakte.',
        'question'  => 'Wat gebeurt er als een campaign niet langer wordt ge-boost?',
    ],
    'user-switch'           => [
        'answer'    => 'Permissies kunnen lastig worden, vooral bij grote campaigns. Als campaign beheerder kun je naar de ledenpagina van de campaign navigeren en op de knop "Schakelen" klikken die wordt weergegeven naast niet-beheerders van de campaign. Als je dit doet, log je in als die gebruiker en kun je de campaign zien zoals zij dat zouden doen. Dit is de gemakkelijkste manier om de permissies van je campaign te controleren.',
        'question'  => 'Mijn campaign permissies zijn ingesteld, hoe kan ik ze testen?',
    ],
    'visibility'            => [
        'answer'    => 'Alleen de mensen die je voor je campaign uitnodigt, kunnen de door jou gecreëerde  zien en ermee communiceren. Je gegevens zijn privé en altijd onder jouw controle. Je kunt je campaign ook instellen op openbaar, zodat niet-geregistreerde gebruikers deze kunnen bekijken.',
        'question'  => 'Kan iedereen mijn wereld zien?',
    ],
];
