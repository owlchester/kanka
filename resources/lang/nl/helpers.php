<?php

return [
    'age'           => [
        'description'   => 'Je kunt een personage aan een kalender van de campaign koppelen door een personage te bekijken en naar het tabblad Herinneringen te gaan. Voeg vanaf daar een nieuwe herinnering toe en stel het type in op Geboorte of Overlijden om automatisch de leeftijd van het personage te berekenen. Als er zowel geboorte als overlijden aanwezig is, worden beide datums weergegeven, evenals de leeftijd bij overlijden. Als alleen de geboorte is ingesteld, worden de datum en de huidige leeftijd weergegeven. Als alleen het overlijden is vastgelegd, worden de datum en de jaren sinds het overlijden weergegeven.',
        'title'         => 'Personage Leeftijd en Overlijden',
    ],
    'attributes'    => [
        'con'           => 'Con',
        'description'   => 'Gebruik attributen om waarden weer te geven die aan een entiteit zijn gekoppeld en die geen tekst zijn. Je kunt verwijzen naar entiteiten in attributen met behulp van de geavanceerde syntaxis voor vermeldingen :mention. Je kunt ook naar andere attributen verwijzen door de :attribute syntaxis te gebruiken.',
        'level'         => 'Level',
        'link'          => 'Attribuut opties',
        'math'          => 'Je kunt ook creatief worden met enkele elementaire wiskundige opties. Bijvoorbeeld :example zal de :level en :con attributen van deze entiteit vermenigvuldigen. Als je naar boven of beneden wilt afronden, kan je gebruik maken van :floorr of :ceil',
        'pinned'        => 'Als je een attribuut vastzet met het pictogram :icon, verschijnt het in het menu van de entiteit onder de afbeelding.',
        'private'       => 'Privé attributen die het :icon gebruiken, maken ze alleen zichtbaar voor campaign beheerders.',
        'title'         => 'Attributen',
    ],
    'dice'          => [
        'description'               => 'Het gooien van algemene dobbelstenen is mogelijk door "d20", "4d4 + 4", "d%" voor percentiel en "df" voor fudge te schrijven.',
        'description_attributes'    => 'Het is ook mogelijk om het attribuut van een personage op te halen door de syntaxis {character.attribute_name} te gebruiken. Bijvoorbeeld {character.level}d6+{character.wisdom}.',
        'more'                      => 'Meer opties zijn beschikbaar en uitgelegd op de dobbelstenen werper plugin pagina.',
        'title'                     => 'Dobbelstenen Worpen',
    ],
    'filters'       => [
        'description'   => 'Je kunt filters gebruiken om het aantal resultaten dat in lijsten wordt weergegeven, te beperken. Tekstvelden ondersteunen verschillende opties om in meer detail te bepalen wat eruit wordt gefilterd.',
        'empty'         => ':tag schrijven in een veld zoekt naar alle entiteiten waar dit veld leeg is.',
        'ending_with'   => 'Door een :tag aan het einde van je tekst te plaatsen, kun je zoeken naar elke entiteit met exact deze tekst in het veld.',
        'multiple'      => 'Je kunt zoekopties op tekstvelden combineren door :syntax te schrijven. Bijvoorbeeld :example',
        'session'       => 'Filters en geordende kolommen die zijn ingesteld voor een entiteitenlijst, worden in je sessie opgeslagen, dus zolang je verbonden blijft, hoef je ze niet op elke pagina opnieuw in te stellen.',
        'starting_with' => 'Door een :tag voor je tekst te plaatsen, kun je zoeken naar alles dat de tekst in het veld niet bevat.',
        'title'         => 'Filters gebruiken',
    ],
    'link'          => [
        'auto_update'       => 'Koppelingen naar andere entiteiten worden automatisch bijgewerkt wanneer de naam of beschrijving van het doel wordt gewijzigd.',
        'description'       => 'Je kunt eenvoudig koppelen naar andere entiteiten in je campaign met behulp van de volgende afkortingen.',
        'formatting'        => [
            'text'  => 'De lijst met toegestane HTML-tags en attributen is te zien op onze :github.',
            'title' => 'Formatteren',
        ],
        'friendly_mentions' => 'Koppel naar andere entiteiten door :code en de eerste paar tekens van een entiteit te typen om ernaar te zoeken. Dit zal :example injecteren in de teksteditor, en renderen als een link naar de entiteit bij het bekijken van de entiteit.',
        'mention_helpers'   => 'Als je entiteit naam een spatie heeft, gebruikt je :example in plaats van spatie. Als je wilt zoeken naar een entiteit met precies die naam, typ dan :exact.',
        'mentions'          => 'Maak een koppeling naar andere entiteiten door :code en de eerste paar tekens van een entiteit te typen om ernaar te zoeken. Dit zal :example injecteren in de teksteditor. Om de naam van de weergegeven entiteit aan te passen, typ je :example_naam. Gebruik :example_page om de subpagina van de entiteit in te stellen. Gebruik :example_tab om het tabblad van de entiteit in te stellen.',
        'months'            => 'Typ :code om een lijst met maanden uit je kalenders te krijgen.',
        'title'             => 'Koppelen naar andere invoeren en snelkoppelingen',
    ],
    'map'           => [
        'description'   => 'Door een kaart naar een locatie te uploaden, wordt het menu \'Kaart\' op de weergavepagina van de locatie geactiveerd, en een directe link naar de kaart vanaf de locatiespagina van de campaign. Vanuit de kaartweergave kunnen gebruikers die de locatie kunnen bewerken de \'Bewerkingsmodus\' activeren waarmee ze Paart Punten op de kaart kunnen plaatsen. Deze kunnen linken naar een bestaande entiteit of een label zijn, en hebben verschillende vormen en maten.',
        'private'       => 'Leden met de Beheerder rol van de campaign kunnen een kaart privé maken. Hierdoor kunnen gebruikers een locatie bekijken, maar beheerders kunnen de kaart geheim houden.',
        'title'         => 'Locatie Kaarten',
    ],
    'public'        => 'Bekijk een instructievideo op YouTube waarin openbare campaigns worden uitgelegd.',
    'title'         => 'Helpers',
];
