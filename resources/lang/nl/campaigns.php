<?php

return [
    'create'                            => [
        'description'           => 'Maak een nieuwe campaign',
        'helper'                => [
            'title'     => 'Welkom :name',
            'welcome'   => <<<'TEXT'
Voordat je verder gaat, moet je een campaign naam kiezen. Dit is de naam van jouw wereld. Als je nog geen goede naam hebt, hoef je je geen zorgen te maken, je kunt deze altijd later wijzigen of meerdere campaigns maken.

Bedankt dat je lid bent geworden van Kanka en welkom bij onze bloeiende gemeenschap!
TEXT
,
        ],
        'success'               => 'Campaign gemaakt.',
        'success_first_time'    => 'Je campaign is gemaakt! Aangezien het je eerste campaign is, hebben we een paar dingen bedacht om je op weg te helpen en hopelijk een beetje inspiratie te bieden voor wat je kunt doen.',
        'title'                 => 'Nieuwe Campaign',
    ],
    'destroy'                           => [
        'action'    => 'Verwijder campaign',
        'helper'    => 'Je kunt de campaign alleen verwijderen als je het enige lid bent.',
        'success'   => 'Campaign verwijderd.',
    ],
    'edit'                              => [
        'success'   => 'Campaign bijgewerkt.',
        'title'     => 'Wijzig Campaign :campaign',
    ],
    'entity_note_visibility'            => [],
    'entity_personality_visibilities'   => [
        'private'   => 'Nieuwe personages hebben standaard hun persoonlijkheid privé.',
    ],
    'entity_visibilities'               => [
        'private'   => 'Nieuwe entiteiten zijn privé',
    ],
    'errors'                            => [
        'access'        => 'Je hebt geen toegang tot deze campaign.',
        'superboosted'  => 'Deze functie is alleen beschikbaar voor superboost-campaigns.',
        'unknown_id'    => 'Onbekende Campaign.',
    ],
    'export'                            => [
        'errors'            => [
            'limit' => 'Je hebt je maximum van één export per dag overschreden. Probeer het morgen opnieuw.',
        ],
        'helper'            => 'Exporteer je campaign. Een melding met een downloadlink wordt beschikbaar gesteld.',
        'helper_secondary'  => 'Er worden twee bestanden beschikbaar gemaakt, een met de entiteiten exporteur als JSON en een andere met afbeeldingen geüpload naar entiteiten. Houd er rekening mee dat bij grotere campagnes de export van afbeeldingen crasht en alleen kan worden hersteld met de :api.',
        'success'           => 'Je campaign-export wordt voorbereid. Je ontvangt een melding in Kanka voor een downloadbare zip zodra deze klaar is.',
        'title'             => 'Campaign :name Exporteren',
    ],
    'fields'                            => [
        'boosted'                   => 'Boosted door',
        'css'                       => 'CSS',
        'description'               => 'Omschrijving',
        'entity_count'              => 'Entiteit Telling',
        'entry'                     => 'Campaign beschrijving',
        'excerpt'                   => 'Excerpt',
        'followers'                 => 'Volgers',
        'header_image'              => 'Header Afbeelding',
        'image'                     => 'Afbeelding',
        'locale'                    => 'Lokale',
        'name'                      => 'Naam',
        'open'                      => 'Open voor sollicitaties',
        'public_campaign_filters'   => 'Openbare Campaign Filters',
        'related_visibility'        => 'Gerelateerde Elementen Zichtbaarheid',
        'rpg_system'                => 'RPG Systemen',
        'superboosted'              => 'Superboosted door',
        'system'                    => 'Systeem',
        'theme'                     => 'Thema',
        'visibility'                => 'Zichtbaarheid',
    ],
    'following'                         => 'Volgend',
    'helpers'                           => [
        'boost_required'            => 'Deze functie vereist een boost van de campaign. Meer info op de :settings pagina.',
        'boosted'                   => 'Sommige functies zijn ontgrendeld omdat deze campaign een boost krijgt. Lees meer op de :settings pagina.',
        'css'                       => 'Schrijf je eigen CSS die in de pagina\'s van je campaign wordt geladen. Houd er rekening mee dat elk misbruik van deze functie kan leiden tot het verwijderen van je aangepaste CSS. Herhaalde of ernstige overtredingen kunnen ertoe leiden dat je campaign wordt verwijderd.',
        'excerpt'                   => 'Het campaign excerpt wordt op het dashboard weergegeven, dus schrijf een paar zinnen die je wereld introduceren. Houd het kort voor het beste resultaat.',
        'hide_history'              => 'Schakel deze optie in om de geschiedenis van entiteiten te verbergen voor niet-beheerders van de campaign.',
        'hide_members'              => 'Schakel deze optie in om de lijst met campaign leden te verbergen voor niet-beheerders.',
        'locale'                    => 'De taal waarin je campaign is geschreven. Dit wordt gebruikt voor het genereren van inhoud en het groeperen van openbare campaigns.',
        'name'                      => 'Je campaign / wereld kan elke naam hebben, zolang deze maar minimaal 4 letters of cijfers bevat.',
        'public_campaign_filters'   => 'Help anderen de campaign te vinden naast andere openbare campaigns door de volgende informatie te verstrekken.',
        'related_visibility'        => 'Standaard Zichtbaarheid waarde bij het maken van een nieuw element met dit veld (entiteit notities, relaties, vaardigheden, enz.)',
        'system'                    => 'Als je campaign openbaar zichtbaar is, wordt het systeem weergegeven op de :link pagina.',
        'systems'                   => 'Om te voorkomen dat gebruikers volgestopt raken met opties, zijn sommige functies van Kanka alleen beschikbaar met specifieke RPG-systemen (dwz het D & D 5e monster stat-blok). Als je hier ondersteunde systemen toevoegt, worden deze functies ingeschakeld.',
        'theme'                     => 'Forceer het thema voor de campaign, waarbij de voorkeur van een gebruiker wordt overschreven.',
        'view_public'               => 'Om je campaign te bekijken zoals een openbare kijker dat zou doen, open je :link in een incognitovenster.',
        'visibility'                => 'Als je een campaign openbaar maakt, kan iedereen met een link ernaar de campaign zien.',
    ],
    'index'                             => [
        'actions'   => [
            'new'   => [
                'title' => 'Nieuwe Campaign',
            ],
        ],
        'title'     => 'Campaign',
    ],
    'invites'                           => [
        'actions'               => [
            'add'   => 'Uitnodigen',
            'copy'  => 'Kopieer de link naar je klembord',
            'link'  => 'Nieuwe Link',
        ],
        'create'                => [
            'buttons'   => [
                'create'    => 'Maak uitnodiging',
                'send'      => 'Verstuur uitnodiging',
            ],
            'success'   => 'Uitnodiging verstuurd.',
            'title'     => 'Nodig iemand uit voor je campaign',
        ],
        'destroy'               => [
            'success'   => 'Uitnodiging verwijderd.',
        ],
        'email'                 => [
            'subject'   => ':name heeft je uitgenodigd om deel te nemen aan hun campaign \':campaign\' op kanka.io! Gebruik de volgende link om hun uitnodiging te accepteren.',
            'title'     => 'Uitnodiging van :name',
        ],
        'error'                 => [
            'already_member'    => 'Je bent al lid van die campaign.',
            'inactive_token'    => 'Deze token is al gebruikt of de campaign bestaat niet meer.',
            'invalid_token'     => 'Dit token is niet meer geldig.',
            'login'             => 'Log in of registreer om deel te nemen aan de campaign.',
        ],
        'fields'                => [
            'created'   => 'Verstuurd',
            'email'     => 'E-mail',
            'role'      => 'Rol',
            'type'      => 'Type',
        ],
        'helpers'               => [
            'email'     => 'Onze e-mails worden vaak gemarkeerd als spam en het kan enkele uren duren voordat ze in je inbox verschijnen.',
            'validity'  => 'Hoeveel gebruikers kunnen deze link gebruiken voordat deze wordt gedeactiveerd. Laat leeg voor onbeperkt',
        ],
        'placeholders'          => [
            'email' => 'E-mailadres van de persoon die je wilt uitnodigen',
        ],
        'types'                 => [
            'email' => 'E-mail',
            'link'  => 'Link',
        ],
        'unlimited_validity'    => 'Onbeperkt',
    ],
    'leave'                             => [
        'confirm'   => 'Weet je zeker dat je de :name campaign wilt verlaten? Je hebt er geen toegang meer toe, tenzij een beheerder van de campagne je opnieuw uitnodigt.',
        'error'     => 'Kan de campaign niet verlaten.',
        'success'   => 'Je hebt de campaign verlaten.',
    ],
    'members'                           => [
        'actions'               => [
            'switch'        => 'Wissel',
            'switch-back'   => 'Terug naar mijn gebruiker',
        ],
        'create'                => [
            'title' => 'Voeg een lid toe aan je campaign',
        ],
        'edit'                  => [
            'title' => 'Wijzig lid :name',
        ],
        'fields'                => [
            'joined'        => 'Aangesloten',
            'last_login'    => 'Laatste Login',
            'name'          => 'Gebruiker',
            'role'          => 'Rol',
            'roles'         => 'Rollen',
        ],
        'help'                  => 'Campaigns kunnen een onbeperkt aantal leden hebben.',
        'helpers'               => [
            'admin' => 'Als lid van de campaign\'s beheerder rol kun je nieuwe gebruikers uitnodigen, inactieve gebruikers verwijderen en hun rechten wijzigen. Gebruik de knop Wissel om de machtigingen van een lid te testen. Je kunt meer over deze functie lezen in de :link.',
            'switch'=> 'Wissel naar deze gebruiker',
        ],
        'impersonating'         => [
            'message'   => 'Je bekijkt de campaign als een andere gebruiker. Sommige functies zijn uitgeschakeld, maar de rest werkt precies zoals de gebruiker het zou zien. Om terug te schakelen naar jouw gebruiker, gebruik je de knop Wissel Terug op de plaats waar de knop Uitloggen zich gewoonlijk bevindt.',
            'title'     => ':name aan het imiteren',
        ],
        'invite'                => [
            'description'   => 'Je kunt vrienden uitnodigen om deel te nemen aan je campaign door hen een Uitnodiging Link te geven. Na het accepteren van hun uitnodiging, worden ze toegevoegd als lid in de gevraagde rol. Je kunt ze ook een verzoek per e-mail sturen.',
            'more'          => 'Je kunt meer rollen toevoegen via de :link.',
            'roles_page'    => 'Rollen pagina',
            'title'         => 'Uitnodiging',
        ],
        'roles'                 => [
            'member'    => 'Lid',
            'owner'     => 'Beheerder',
            'player'    => 'Speler',
            'public'    => 'Openbaar',
            'viewer'    => 'Kijker',
        ],
        'switch_back_success'   => 'Je bent nu terug bij je oorspronkelijke gebruiker.',
        'title'                 => 'Campaign :name Leden',
        'your_role'             => 'Jouw rol: <i>:role</i>',
    ],
    'open_campaign'                     => [
        'helper'    => 'Met een openbare campaign die is ingesteld als open, kunnen gebruikers sollicitaties sturen om eraan deel te nemen. Vind de lijst met sollicitaties op onze :link pagina.',
        'link'      => 'campaign sollicitaties',
        'title'     => 'Open Campaign',
    ],
    'panels'                            => [
        'boosted'   => 'Boosted',
        'dashboard' => 'Dashboard',
        'permission'=> 'Permissie',
        'setup'     => 'Opstelling',
        'sharing'   => 'Delen',
        'systems'   => 'Systemen',
        'ui'        => 'Interface',
    ],
    'placeholders'                      => [
        'description'   => 'Een korte samenvatting van je campaign',
        'locale'        => 'Taal code',
        'name'          => 'Jouw campaign naam',
        'system'        => 'D&D, Pathfinder, Fate, DSA',
    ],
    'roles'                             => [
        'actions'       => [
            'add'   => 'Voeg een rol toe',
        ],
        'admin_role'    => 'Beheerder rol',
        'create'        => [
            'success'   => 'Rol gemaakt.',
            'title'     => 'Maak een nieuwe rol aan voor :name',
        ],
        'destroy'       => [
            'success'   => 'Rol verwijderd.',
        ],
        'edit'          => [
            'success'   => 'Rol bijgewerkt.',
            'title'     => 'Wijzig Rol :name',
        ],
        'fields'        => [
            'name'          => 'Naam',
            'permissions'   => 'Permissies',
            'type'          => 'Type',
            'users'         => 'Gebruikers',
        ],
        'helper'        => [
            '1' => 'Een campaign kan zoveel rollen hebben als je wilt. De rol "Beheerder" heeft automatisch toegang tot alles in een campaign, maar elke andere rol kan specifieke rechten hebben voor verschillende soorten entiteiten (personage, locatie, enz.).',
            '2' => 'Entiteiten kunnen meer verfijnde machtigingen hebben door het tabblad "Machtigingen" van een entiteit te bekijken. Dit tabblad wordt weergegeven zodra je campaign meerdere rollen of leden heeft.',
            '3' => 'Men kan ofwel kiezen voor een "opt-out" systeem, waarbij rollen toegang krijgen om alle entiteiten te bekijken, en het selectievakje "Privé" op entiteiten gebruiken om ze te verbergen. Of men kan rollen niet veel machtigingen geven, maar elke entiteit zo instellen dat deze afzonderlijk zichtbaar is.',
        ],
        'hints'         => [
            'campaign_not_public'   => 'De openbare rol heeft machtigingen, maar de campaign is privé. Je kunt deze instelling wijzigen op het tabblad Delen wanneer je de campaign bewerkt.',
            'public'                => 'De Openbaar rol wordt gebruikt wanneer iemand je openbare campaign doorbladert. :more',
            'role_permissions'      => 'Schakel de rol \':name\' in om de volgende acties op alle entiteiten uit te voeren.',
        ],
        'members'       => 'Leden',
        'permissions'   => [
            'actions'   => [
                'add'           => 'Maak',
                'dashboard'     => 'Dashboard',
                'delete'        => 'Verwijder',
                'edit'          => 'Wijzig',
                'entity-note'   => 'Entiteit Notitie',
                'manage'        => 'Beheer',
                'members'       => 'Leden',
                'permission'    => 'Permissies',
                'read'          => 'Bekijk',
                'toggle'        => 'Verander voor alle',
            ],
            'helpers'   => [
                'entity_note'   => 'Hierdoor kunnen gebruikers die geen Wijzig rechten voor een Entiteit hebben, er Entiteit Notities aan toevoegen.',
            ],
            'hint'      => 'Deze rol heeft automatisch toegang tot alles.',
        ],
        'placeholders'  => [
            'name'  => 'Naam van de rol',
        ],
        'show'          => [
            'title' => 'Campaign Rol \':role\'',
        ],
        'title'         => 'Campaign :name Rollen',
        'types'         => [
            'owner'     => 'Beheerder',
            'public'    => 'Openbaar',
            'standard'  => 'Standaard',
        ],
        'users'         => [
            'actions'   => [
                'add'   => 'Voeg een lid toe',
            ],
            'create'    => [
                'success'   => 'Gebruiker toegevoegd aan de rol.',
                'title'     => 'Voeg een lid toe aan de :name rol',
            ],
            'destroy'   => [
                'success'   => 'Gebruiker verwijderd van de rol.',
            ],
            'fields'    => [
                'name'  => 'Naam',
            ],
        ],
    ],
    'settings'                          => [
        'actions'   => [
            'enable'    => 'Inschakelen',
        ],
        'boosted'   => 'Deze functie is in vroege toegang en momenteel alleen beschikbaar voor :boosted.',
        'edit'      => [
            'success'   => 'Campaign instellingen bijgewerkt.',
        ],
        'helper'    => 'Alle modules van een campaign kunnen naar believen worden in- of uitgeschakeld. Als je een module uitschakelt, worden de interface-elementen die eraan gerelateerd zijn eenvoudig verborgen, en reeds bestaande entiteiten zullen verborgen zijn maar nog steeds op de achtergrond bestaan, voor het geval je van gedachten verandert. Deze wijzigingen zijn van invloed op alle gebruikers van een campaign, inclusief beheerders.',
        'helpers'   => [
            'abilities'     => 'Maak vaardigheden, of het nu gaat om prestaties, spreuken of krachten die aan entiteiten kunnen worden toegewezen.',
            'calendars'     => 'Een plek om de kalenders van je wereld te definiëren.',
            'characters'    => 'De mensen die jouw wereld bewonen.',
            'conversations' => 'Fictieve conversaties tussen personages of tussen campaign gebruikers. Deze module is verouderd.',
            'dice_rolls'    => 'Voor degenen die Kanka gebruiken voor RPG campaigns, een manier om met dobbelstenen te werken. Deze module is verouderd.',
            'events'        => 'Feestdagen, festivals, rampen, verjaardagen, oorlogen.',
            'families'      => 'Clans of families, hun relaties en hun leden.',
            'items'         => 'Wapens, voertuigen, relikwieën, potions.',
            'journals'      => 'Observaties geschreven door personages of sessie voorbereiding voor de dungeon master.',
            'locations'     => 'Planeten, vliegtuigen, continenten, rivieren, staten, nederzettingen, tempels, herbergen.',
            'maps'          => 'Upload kaarten met lagen en markeringen die naar andere entiteiten in de campaign verwijzen.',
            'menu_links'    => 'Aangepaste menu koppelingen in de zijbalk.',
            'notes'         => 'Lore, natuur, geschiedenis, magie, culturen.',
            'organisations' => 'Sekten, religies, facties, gilden.',
            'quests'        => 'Om verschillende quests bij te houden met personages en locaties.',
            'races'         => 'Als je campaign meer dan één ras heeft, maakt dit het bijhouden van het overzicht gemakkelijk.',
            'tags'          => 'Elke entiteit kan meerdere tags hebben. Tags kunnen bij andere tags horen en invoeringen kunnen op tag worden gefilterd.',
            'timelines'     => 'Geef de geschiedenis van je wereld weer met tijdlijnen.',
        ],
        'title'     => 'Campaign :name Modules',
    ],
    'show'                              => [
        'actions'   => [
            'boost' => 'Boost campaign',
            'edit'  => 'Wijzig Campaign',
            'leave' => 'Verlaat campaign',
        ],
        'menus'     => [
            'configuration'     => 'Configuratie',
            'overview'          => 'Overzicht',
            'user_management'   => 'Gebruikersbeheer',
        ],
        'tabs'      => [
            'achievements'      => 'Prestaties',
            'applications'      => 'Sollicitaties',
            'campaign'          => 'Campaign',
            'default-images'    => 'Standaard Afbeeldingen',
            'export'            => 'Exporteer',
            'information'       => 'Informatie',
            'members'           => 'Leden',
            'plugins'           => 'Plugins',
            'recovery'          => 'Herstel',
            'roles'             => 'Rollen',
            'settings'          => 'Modules',
        ],
        'title'     => 'Campaign :name',
    ],
    'superboosted'                      => [
        'gallery'   => [
            'error' => [
                'text'  => 'Het uploaden van afbeeldingen in de text editor is een functie die alleen beschikbaar is voor :superboosted.',
                'title' => 'Upload van Afbeeldingen in Campaign Galerij',
            ],
        ],
    ],
    'ui'                                => [],
    'visibilities'                      => [
        'private'   => 'Privé',
        'public'    => 'Openbaar',
        'review'    => 'Beoordeling Afwachten',
    ],
];
