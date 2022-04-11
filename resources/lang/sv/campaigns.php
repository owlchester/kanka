<?php

return [
    'create'                            => [
        'description'           => 'Skapa en ny kampanj',
        'helper'                => [
            'title'     => 'Välkommen till :name',
            'welcome'   => <<<'TEXT'
Innan du kan fortsätta behöver du välja ett namn på din kampanj. Detta är namnet på din värld. Om du inte har ett bra namn än behöver du inte oroa dig, du kan alltid ändra det senare eller skapa fler kampanjer.

Tack för att du valt Kanka och välkommen till vår blomstrande Community!
TEXT
,
        ],
        'success'               => 'Kampanj skapad.',
        'success_first_time'    => 'Din kampanj har skapats! Eftersom det är din första kampanj så har vi skapat några saker för att hjälpa dig komma igång och förhoppningsvis ge en smula inspiration för vad du kan göra.',
        'title'                 => 'Ny Kampanj',
    ],
    'destroy'                           => [
        'action'    => 'Ta bort Kampanj',
        'helper'    => 'Du kan bara ta bort kampanjen om du är den enda medlemmen i den.',
        'success'   => 'Kampanj borttagen.',
    ],
    'edit'                              => [
        'success'   => 'Kampanj uppdaterad',
        'title'     => 'Redigera Kampanj :campaign',
    ],
    'entity_note_visibility'            => [],
    'entity_personality_visibilities'   => [
        'private'   => 'Nya karaktärers personligheter är privata som standard.',
    ],
    'entity_visibilities'               => [
        'private'   => 'Nya entiteter är privata',
    ],
    'errors'                            => [
        'access'        => 'Du har inte tillgång till denna kampanj.',
        'superboosted'  => 'Denna funktion är bara tillgängliga för superboostade kampanjer.',
        'unknown_id'    => 'Okänd Kampanj.',
    ],
    'export'                            => [
        'errors'            => [
            'limit' => 'Du har nått gränsen på max en export per dag. Vänligen försök igen imorgon.',
        ],
        'helper'            => 'Exportera din kampanj. En notifikation med en nedladdningslänk kommer bli tillgänglig.',
        'helper_secondary'  => 'Två filer kommer göras tillgängliga, en med entiteterna exporterade som JSON, och en annan med bilder uppladdade till entiteter. Vänligen notera att på större kampanjer kraschar bild exporten och kan bara återhämtas genom att använda :api.',
        'success'           => 'Exporten av din kampanj förbereds. Du kommer få en notifikation i Kanka med en nedladdningsbar zip-fil så fort den är klar.',
        'title'             => 'Kampanj :name Exporterad',
    ],
    'fields'                            => [
        'boosted'                   => 'Boostad av',
        'css'                       => 'CSS',
        'description'               => 'Beskrivning',
        'entity_count'              => 'Entitet Antal',
        'excerpt'                   => 'Utdrag',
        'followers'                 => 'Följare',
        'header_image'              => 'Titelbild',
        'image'                     => 'Bild',
        'locale'                    => 'Språk',
        'name'                      => 'Namn',
        'public_campaign_filters'   => 'Offentlig Kampanj Filter',
        'related_visibility'        => 'Relaterade Elements Synlighet',
        'rpg_system'                => 'RPG System',
        'system'                    => 'System',
        'theme'                     => 'Tema',
        'visibility'                => 'Synlighet',
    ],
    'following'                         => 'Följer',
    'helpers'                           => [
        'boost_required'            => 'Denna funktion kräver att kampanjen är boostad. Mer info på :settings sidan.',
        'boosted'                   => 'Några funktioner är upplåsta för att denna kampanj är boostad. Läs mer på :settings sidan.',
        'css'                       => 'Skriv din egen CSS som kommer laddas in på sidorna för din kampanj. Vänligen notera att allt missbruk av denna funktion kan leda till borttagandet av din anpassade CSS. Upprepade eller grova överträdelser kan leda till borttagandet av din kampanj.',
        'excerpt'                   => 'Kampanjutdraget kommer att visas på dashboarden, så skriv några meningar som introducerar din värld. Håll det kortfattat för bästa resultat.',
        'hide_history'              => 'Välj detta för att dölja entiteters historia från icke-admin medlemmar i kampanjen.',
        'hide_members'              => 'Välj detta för att dölja kampanjens medlemslista från icke-admin medlemmar.',
        'locale'                    => 'Språket din kampanj är skriven på. Detta används för att generera innehåll och gruppera publika kampanjer.',
        'name'                      => 'Din kampanj/värld kan ha vilket namn som helst så länge det innehåller minst 4 bokstäver eller siffror.',
        'public_campaign_filters'   => 'Hjälp andra hitta kampanjen bland andra offentliga kampanjer genom att ge följande information.',
        'related_visibility'        => 'Standard Synlighetsvärde när ett nytt element skapas genom detta fält (entitetsanteckningar, förbindelser, förmågor, osv.)',
        'system'                    => 'Om din kampanj är offentligt synlig så visas systemet på :link sidan.',
        'systems'                   => 'För att undvika att överväldiga användare med val så är några funktioner i Kanka bara tillgängliga med visa RPG system (dvs. D&D 5e monster stat blocken). Genom att lägga till stödda system aktiveras dessa funktioner',
        'theme'                     => 'Tvinga temat för kampanjen och ignorera en användares preferens.',
        'view_public'               => 'För att se kampanjen som en offentlig användare gör, öppna :link i ett inkognito fönster.',
        'visibility'                => 'Att göra en kampanj offentlig innebär att vem som helst med länken kan se den.',
    ],
    'index'                             => [
        'actions'   => [
            'new'   => [
                'title' => 'Ny Kampanj',
            ],
        ],
        'title'     => 'Kampanj',
    ],
    'invites'                           => [
        'actions'               => [
            'add'   => 'Bjud in',
            'copy'  => 'Kopiera länken till dina urklipp',
            'link'  => 'Ny länk',
        ],
        'create'                => [
            'success'   => 'Inbjudan skickad.',
            'title'     => 'Bjud in någon till din kampanj',
        ],
        'destroy'               => [
            'success'   => 'Inbjudan borttagen.',
        ],
        'email'                 => [
            'subject'   => ':name har bjudit in dig till sin kampanj \':campaign\' på kanka.io! Använd följande länk för att acceptera deras inbjudan.',
            'title'     => 'Inbjudan från :name',
        ],
        'error'                 => [
            'already_member'    => 'Du är redan medlem i den kampanjen.',
            'inactive_token'    => 'Denna token har redan använts, eller så finns inte kampanjen längre.',
            'invalid_token'     => 'Denna token är inte längre giltig.',
            'login'             => 'Vänligen logga in eller registrera dig för att gå med i kampanjen.',
        ],
        'fields'                => [
            'created'   => 'Skickat',
            'email'     => 'Epost',
            'role'      => 'Roll',
            'type'      => 'Typ',
        ],
        'helpers'               => [
            'email'     => 'Våra mail blir ofta flaggade som skräppost och kan ta upp till några timmar att dyka upp i din inkorg.',
            'validity'  => 'Hur många användare som kan använda denna länk innan den inaktiveras. Lämna tomt för obegränsat',
        ],
        'placeholders'          => [
            'email' => 'Epost adress till personen du vill bjuda in.',
        ],
        'types'                 => [
            'email' => 'Epost',
            'link'  => 'Länk',
        ],
        'unlimited_validity'    => 'Obegränsad',
    ],
    'leave'                             => [
        'confirm'   => 'Är du säker på att du vill lämna :name kampanjen? Du kommer inte ha åtkomst till den längre, om inte en Admin bjuder in dig igen.',
        'error'     => 'Kan inte lämna kampanjen.',
        'success'   => 'Du har lämnat kampanjen.',
    ],
    'members'                           => [
        'actions'               => [
            'switch'        => 'Byt',
            'switch-back'   => 'Tillbaka till min användare',
        ],
        'create'                => [
            'title' => 'Lägg till en medlem i din kampanj',
        ],
        'edit'                  => [
            'title' => 'Redigera medlem :name',
        ],
        'fields'                => [
            'joined'        => 'Gått med',
            'last_login'    => 'Senaste inloggning',
            'name'          => 'Användare',
            'role'          => 'Roll',
            'roles'         => 'Roller',
        ],
        'help'                  => 'Kampanjer kan ha ett obegränsat antal medlemmar.',
        'helpers'               => [
            'admin' => 'Som en medlem av kampanjens Admin roll kan du bjuda in nya användare, ta bort inaktiva och ändra deras behörigheter. För att testa behörigheter för en medlem, använd Byt knappen. Du kan läsa mer om denna funktion på :link',
            'switch'=> 'Byt till denna användare',
        ],
        'impersonating'         => [
            'message'   => 'Du ser kampanjen som en annan användare. Visa funktioner har inaktiverats, men resten ser ut precis som användaren skulle se det. För att byta tillbaka, använd \'Tillbaka till min användare\' knappen som finns där \'Logga ut\' knappen brukar finnas.',
            'title'     => 'Imiterar :user',
        ],
        'invite'                => [
            'description'   => 'Du kan bjuda in vänner att gå med i din kampanj genom att ge dem en Inbjudnings-länk. När de accepterar sin inbjudan läggs de till som en medlem med efterfrågad rollen. Du kan också skicka en inbjudan via epost.',
            'more'          => 'Du kan lägga till fler roller på :link',
            'roles_page'    => 'Roller sidan',
            'title'         => 'Bjud in',
        ],
        'roles'                 => [
            'member'    => 'Medlem',
            'owner'     => 'Admin',
            'player'    => 'Spelare',
            'public'    => 'Offentlig',
            'viewer'    => 'Tittare',
        ],
        'switch_back_success'   => 'Du är nu tillbaka i din ursprungliga användare.',
        'title'                 => 'Kampanj :name Medlemmar',
        'your_role'             => 'Din roll: <i>:role</i>',
    ],
    'panels'                            => [
        'boosted'   => 'Boostad',
        'dashboard' => 'Dashboard',
        'permission'=> 'Behörighet',
        'sharing'   => 'Delning',
        'systems'   => 'System',
        'ui'        => 'Gränssnitt',
    ],
    'placeholders'                      => [
        'description'   => 'En kort summering av din kampanj',
        'locale'        => 'Språkkod',
        'name'          => 'Ditt kampanj namn',
        'system'        => 'D&D, Pathfinder, Fate, DSA',
    ],
    'roles'                             => [
        'actions'       => [
            'add'   => 'Skapa en roll',
        ],
        'create'        => [
            'success'   => 'Roll skapad.',
            'title'     => 'Skapa en ny roll för :name',
        ],
        'destroy'       => [
            'success'   => 'Roll borttagen.',
        ],
        'edit'          => [
            'success'   => 'Roll uppdaterad.',
            'title'     => 'Redigera Roll :name',
        ],
        'fields'        => [
            'name'          => 'Namn',
            'permissions'   => 'Behörigheter',
            'type'          => 'Typ',
            'users'         => 'Användare',
        ],
        'helper'        => [
            '1' => 'En kampanj kan ha hur många roller man vill. "Admin" rollen har automatiskt tillgång till allt i kampanjen, men alla andra roller kan ha specifika behörigheter på olika typer av entiteter (karaktär, plats, osv).',
            '2' => 'Entiteter kan ha mer anpassade behörigheter under "Behörigheter" fliken på en entitet. Denna flik visas när din kampanj har flera roller eller medlemmar.',
            '3' => 'Man kan antingen använda ett "opt-out" system där roller har tillgång till alla entiteter och använda "Privat" kryssrutan för entiteter för att gömma dem. Eller så kan man ge roller färre behörigheter men sätta varje entitets synlighet individuellt.',
        ],
        'hints'         => [
            'campaign_not_public'   => 'Offentlig rollen har behörigheter men kampanjen är privat. Du kan ändra denna inställning under \'Delning\' fliken när du redigerar kampanjen.',
            'public'                => 'Offentlig rollen används när någon tittar på din offentliga kampanj. :more',
            'role_permissions'      => 'Tillåter \':name\' rollen att göra följande handlingar på alla entiteter.',
        ],
        'members'       => 'Medlemmar',
        'permissions'   => [
            'actions'   => [
                'add'           => 'Skapa',
                'dashboard'     => 'Dashboard',
                'delete'        => 'Ta bort',
                'edit'          => 'Redigera',
                'entity-note'   => 'Entitetsanteckning',
                'manage'        => 'Hantera',
                'members'       => 'Medlemmar',
                'permission'    => 'Behörigheter',
                'read'          => 'Visa',
                'toggle'        => 'Ändra för alla',
            ],
            'helpers'   => [
                'entity_note'   => 'Detta tillåter användare som inte har Redigera behörigheter för en entitet att lägga till Entitetsanteckningar till den.',
            ],
            'hint'      => 'Denna roll har automatiskt tillgång till allt.',
        ],
        'placeholders'  => [
            'name'  => 'Rollens namn',
        ],
        'show'          => [
            'title' => 'Kampanj Roll \':role\'',
        ],
        'title'         => 'Kampanj :name Roller',
        'types'         => [
            'owner'     => 'Admin',
            'public'    => 'Offentlig',
            'standard'  => 'Standard',
        ],
        'users'         => [
            'actions'   => [
                'add'   => 'Lägg till medlem',
            ],
            'create'    => [
                'success'   => 'Användare tillagd till rollen.',
                'title'     => 'Lägg till en medlem till :name rollen',
            ],
            'destroy'   => [
                'success'   => 'Användare borttagen från rollen.',
            ],
            'fields'    => [
                'name'  => 'Namn',
            ],
        ],
    ],
    'settings'                          => [
        'actions'   => [
            'enable'    => 'Lägg till',
        ],
        'boosted'   => 'Denna funktion är i early access och endast tillgänglig för :boosted.',
        'edit'      => [
            'success'   => 'Kampanj inställningar uppdaterade.',
        ],
        'helper'    => 'Alla moduler i en kampanj kan aktiveras och inaktiveras när man vill. Inaktivera en modul kommer bara dölja gränssnitts elementen relaterade till den och redan existerande entiteter kommer döljas men dom existerar fortfarande i bakgrunden, utifall du ändrar dig. Dessa ändringar påverkar alla användare i kampanjen, även Admin användare.',
        'helpers'   => [
            'abilities'     => 'Skapa förmågor, det kan vara bedrifter, trollformler eller krafter som kan tilldelas till entiteter.',
            'calendars'     => 'En plats att definiera kalendrarna från din värld.',
            'characters'    => 'Folket som bor i din värld.',
            'conversations' => 'Fiktiva samtal mellan karaktärer eller kampanj användare. Denna modul håller på att fasas ut.',
            'dice_rolls'    => 'Ett sätt att hantera tärningskast för dom som använder Kanka för rollspelskampanjer. Denna modul håller på att fasas ut.',
            'events'        => 'Helger, festivaler, katastrofer, födelsedagar, krig.',
            'families'      => 'Klaner eller familjer, deras relationer och medlemmar.',
            'items'         => 'Vapen, fordon, reliker, trolldrycker.',
            'journals'      => 'Observationer skrivna av karaktärer, eller spelförberedelser för spelledaren.',
            'locations'     => 'Planeter, existensplan, kontinenter, floder, stater, bosättningar, tempel, värdshus.',
            'maps'          => 'Ladda upp kartor med lager och markeringar som pekar till andra entiteter i din kampanj.',
            'menu_links'    => 'Anpassade meny länkar i sidofältet.',
            'notes'         => 'Kunskap, religioner, historia, magi, raser.',
            'organisations' => 'Kulter, militärförband, faktioner, gillen.',
            'quests'        => 'För att hålla ordning på diverse uppdrag med karaktärer och platser.',
            'races'         => 'Om din kampanj har flera raser så kommer detta hjälpa dig hålla ordning på dem.',
            'tags'          => 'Varje entitet kan ha flera taggar. Taggar kan tillhöra andra taggar och entiteter kan filtreras efter taggar.',
            'timelines'     => 'Representera din världs historia med tidslinjer.',
        ],
        'title'     => 'Kampanj :name Modules',
    ],
    'show'                              => [
        'actions'   => [
            'boost' => 'Boosta kampanj',
            'edit'  => 'Redigera kampanj',
            'leave' => 'Lämna kampanj',
        ],
        'tabs'      => [
            'achievements'      => 'Achievements',
            'default-images'    => 'Standard Bilder',
            'export'            => 'Exportera',
            'information'       => 'Information',
            'members'           => 'Medlemar',
            'plugins'           => 'Pluginer',
            'recovery'          => 'Återställning',
            'roles'             => 'Roller',
            'settings'          => 'Moduler',
        ],
        'title'     => 'Kampanj :namn',
    ],
    'superboosted'                      => [
        'gallery'   => [
            'error' => [
                'text'  => 'Uppladdning av bilder i text redigeraren är en funktion endast tillgänglig för :superboosted.',
                'title' => 'Kampanj Galleri Bild Uppladdning',
            ],
        ],
    ],
    'ui'                                => [],
    'visibilities'                      => [
        'private'   => 'Privat',
        'public'    => 'Offentlig',
        'review'    => 'Inväntar Värdering',
    ],
];
