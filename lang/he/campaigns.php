<?php

return [
    'create'                            => [
        'description'           => 'צור מערכה חדשה',
        'helper'                => [
            'title'     => 'ברוכים הבאים ל:name!',
            'welcome'   => <<<'TEXT'
תודה שאתם מנסים את הכלי שלנו! לפני שנוכל להמשיך, עליכם את <b>שם המערכה</b>. זה יהיה השם של העולם, שיפריד אותו מהאחרים. אם אין לך שם טוב כרגע, אל תדאג, <b>תמיד אפשר לשנות אותו אחר כך</b> וליצור עולמות מערכה חדשים.

תודה על הצטרפותכם לKanka, וברוכים הבאים לקהילה שלנו!
TEXT
,
        ],
        'success'               => 'עולם המערכה נוצר.',
        'success_first_time'    => 'עולם המערכה שלך נוצר! מאחר שזוהי המערכה הראשונה שלך, יצרנו מספר דברים כדי לעזור לך להתחיל, ובתקווה לספק קצת השראה למה שתוכל לעשות.',
        'title'                 => 'מערכה חדשה.',
    ],
    'destroy'                           => [
        'success'   => 'המערכה הוסרה.',
    ],
    'edit'                              => [
        'success'   => 'המערכה עודכנה.',
        'title'     => 'ערוך מערכה :campaign',
    ],
    'entity_personality_visibilities'   => [
        'private'   => 'האישיות של דמות חדשה מוסתרת כברירת מחדל.',
    ],
    'entity_visibilities'               => [
        'private'   => 'דמויות חדשות הן פרטיות',
    ],
    'errors'                            => [
        'access'        => 'אין לך גישה למערכה הזו.',
        'unknown_id'    => 'מערכה לא ידועה.',
    ],
    'export'                            => [],
    'fields'                            => [
        'boosted'                   => 'מוגבר על ידי',
        'css'                       => 'CSS',
        'description'               => 'תיאור',
        'entity_count'              => 'מספר אובייקטים',
        'excerpt'                   => 'תקציר',
        'followers'                 => 'עוקבים',
        'header_image'              => 'תמונת כותרת',
        'image'                     => 'תמונה',
        'locale'                    => 'אזור',
        'name'                      => 'שם',
        'public_campaign_filters'   => 'פילטר עולמות מערכה ציבוריות',
        'rpg_system'                => 'שיטת משחק',
        'system'                    => 'שיטה',
        'theme'                     => 'ערכת נושא',
        'visibility'                => 'נראות',
    ],
    'following'                         => 'עוקב',
    'helpers'                           => [
        'boost_required'            => 'הפעולה הזו דורשת שהמערכה תהיה מוגברת. ניתן למצוא עוד מידע בעמוד :settings.',
        'boosted'                   => 'חלק מהפעולות מאופשרות במערכה הזו כי היא מוגברת. ניתן למצוא עוד מידע בעמוד :settings.',
        'css'                       => 'כתוב CSS משלך שיטען לתוך העמודים במערכה. שים לב ששימוש לא ראוי בפיצ’ר יכול להוביל להסרת הCSS שלך. עבירות חוזרות או קיצוניות עשויות להוביל להסרת המערכה.',
        'excerpt'                   => 'תקציר המערכה יופיע במסך הבית, אז כתוב כמה משפטים כדי להציג את העולם. תיאור קצר יוביל לתוצאות מיטביות.',
        'hide_history'              => 'בחר באפשרות זו כדי להסתיר את ההיסטוריה של אובייקטים משחקנים שאינם מנהלים בעולם המערכה.',
        'hide_members'              => 'בחר באפשרות זו כדי להסתיר את רשימת המשתתפים משחקנים שאינם מנהלים בעולם המערכה.',
        'locale'                    => 'השפה בה המערכה כתובה. זה משמש ליצירת תוכן ומיון משחקים ציבוריים.',
        'name'                      => 'השם של העולם/מערכה יכול להיות כל דבר, כל עוד הוא כולל לפחות 4 אותיות או מספרים.',
        'public_campaign_filters'   => 'עזור לאחרים למצוא את עולם המערכה שלך מבין העולמות הציבוריים בעזרת המידע הבא.',
        'system'                    => 'אם המערכה פתוחה לציבור הרחב, ניתן לראות את השיטה בעמוד :link.',
        'systems'                   => 'כדי למנוע עומס יתר של אפשרויות, חלק מהאפשרויות של Kanka פתוחות רק לשיטות משחק מסויימות (כגון עמוד התכונות למפלצות במו"ד 5). הוספת שיטות נתמכות יפעיל את האפשרויות האלה.',
        'theme'                     => 'כפה ערכת נושא על המערכה. מבטל את ההגדרות של משתמש.',
        'view_public'               => 'כדי לראות את עולם המערכה כפי שמשתמש זר יראה אותו, הכנס לקישור :link בחלון גלישה בסתר.',
        'visibility'                => 'יצירת מערכה ציבורת אומרת שכל אחד עם הקישור יוכל לראות אותה.',
    ],
    'index'                             => [
        'actions'   => [
            'new'   => [
                'title' => 'מערכה חדשה',
            ],
        ],
    ],
    'invites'                           => [
        'actions'               => [
            'copy'  => 'העתק את הקישור',
            'link'  => 'קישור חדש',
        ],
        'create'                => [
            'title' => 'הזמן מישהו למערכה שלך.',
        ],
        'destroy'               => [
            'success'   => 'הזמנה הוסרה.',
        ],
        'error'                 => [
            'already_member'    => 'אתה כבר משתתף במערכה הזו.',
            'inactive_token'    => 'האסימון הזה כבר כבר בשימוש, או המערכה כבר לא קיימת.',
            'invalid_token'     => 'האסימון הזה כבר לא בתוקף.',
            'login'             => 'אנא כנס לחשבונך או צור חשבון כדי להצטרף למערכה.',
        ],
        'fields'                => [
            'created'   => 'נשלח',
            'role'      => 'תפקיד',
            'type'      => 'סוג',
        ],
        'unlimited_validity'    => 'בלתי מוגבל',
    ],
    'leave'                             => [
        'confirm'   => 'האם אתה בטוח שאתה רוצה לעזוב את המערכה :name? אתה לא תוכל לגשת אליה יותר, אלא אם מנהל יזמין אותך בחזרה.',
        'error'     => 'לא ניתן היה לעזוב את המערכה.',
        'success'   => 'עזבת את המערכהץ',
    ],
    'members'                           => [
        'actions'               => [
            'switch'        => 'החלף',
            'switch-back'   => 'חזרה למשתמש שלי',
        ],
        'create'                => [
            'title' => 'הוסף משתמשים למערכה',
        ],
        'edit'                  => [
            'title' => 'ערוך משתמש :name',
        ],
        'fields'                => [
            'joined'        => 'הצטרף',
            'last_login'    => 'כניסה אחרונה',
            'name'          => 'משתמש',
            'role'          => 'תפקיד',
            'roles'         => 'תפקידים',
        ],
        'help'                  => 'אין גבול למספר המשתמשים היכולים להיות במערכה אחת.',
        'helpers'               => [
            'admin' => 'בתור חבר בתפקיד המנהלים של המערכה, אתה יכול להזמין משתמשים חדשים, להסיר משתמשים קיימים, ולשנות את ההרשאות שלהם. כדי לבדוק את ההרשאות של משתמש ניתן להשתמש בכפתור "החלף". ניתן לקרוא עוד על הפיצ\'ר הזה ב:link.',
            'switch'=> 'החלף למשתמש הזה',
        ],
        'impersonating'         => [
            'message'   => 'אתה כרגע מסתכל על המערכה בתור משתמש אחר. ישנן מספר פעולות אשר מוגבלות במצב זה, אך מרבית הדברים נראים ומתנהגים בדיוק כפי שיהיו אצל המשתמש אותו אתה מחקה. כדי לחזור לחשבון שלך, ניתן להשתמש בכפתור "חזור למשתמש שלי" המחליף את הכפתור "התנתק".',
            'title'     => 'מחקה את :name',
        ],
        'invite'                => [
            'description'   => 'ניתן להזמין חברים להצטרף למערכה דרך הפצת קישור ההזמנה. לחיצה על הקישור תוסיף אותם למערכה, בתפקיד המוגדר. ניתן גם להגדיר כתובת דוא"ל אליה תשלח ההזמנה, בתנאי שלא מדובר בכתובת Hotmail, שכן הן תמיד חוסמות את האימיילים של Kanka.',
            'more'          => 'ניתן להוסיף עוד תפקידים ב:link.',
            'roles_page'    => 'עמוד התפקידים',
            'title'         => 'הזמן משתתפים',
        ],
        'roles'                 => [
            'member'    => 'משתתף',
            'owner'     => 'מנהל',
            'player'    => 'שחקן',
            'public'    => 'ציבור',
            'viewer'    => 'צופה',
        ],
        'switch_back_success'   => 'חזרת למשתמש המקורי שלך.',
        'title'                 => 'המשתתפים במערכה :name',
        'your_role'             => 'התפקיד שלך: <i>:role</i>',
    ],
    'panels'                            => [
        'boosted'   => 'מוגבר',
        'dashboard' => 'דף בית',
        'permission'=> 'הרשאה',
        'sharing'   => 'שיתוף',
        'systems'   => 'שיטות',
        'ui'        => 'ממשק',
    ],
    'placeholders'                      => [
        'description'   => 'תקציר על המערכה',
        'locale'        => 'קוד שפה',
        'name'          => 'שם המערכה',
        'system'        => 'מבוכים ודרקונים, פאת\'פיינדר, Fate',
    ],
    'roles'                             => [
        'actions'       => [
            'add'   => 'הוסף תפקיד',
        ],
        'create'        => [
            'success'   => 'התפקיד נוצר',
            'title'     => 'צור תפקיד חדש ל:name',
        ],
        'destroy'       => [
            'success'   => 'התפקיד הוסר.',
        ],
        'edit'          => [
            'success'   => 'התפקיד עודכן.',
            'title'     => 'ערוך את התפקיד :name',
        ],
        'fields'        => [
            'name'          => 'שם',
            'permissions'   => 'הרשאות',
            'type'          => 'סוג',
            'users'         => 'משתמשים',
        ],
        'helper'        => [
            '1' => 'אין מגבלה למספר התפקידים שניתן להוסיף לעולם מערכה. התפקיד "מנהל" אוטומטית נותן גישה לכל האובייקיטם במערכה, אבל לכל תפקיד מלבדו ניתן להגדיר הרשאות שונות עבור סוגי אובייקטים שונים (דמויות, מקומות, וכו\').',
            '2' => 'ניתן לשנות את ההרשאות של אובייקטים אינדיבידואלים ביתר דיוק דרך התפריט "הרשאות" בתוך האובייקט.',
            '3' => 'ניתן לנקוט בשתי גישות עיקריות בנוגע להרשאות: או לתת לתפקידים הרשאת צפייה בכל האובייקטים ולהגדיר דברים כ"פרטיים" כדי להסתירם משחקנים, או לתת לתפקידים הרשאות מצומצמות ולאפשר גישה לכל אובייקט בנפרד.',
        ],
        'hints'         => [
            'campaign_not_public'   => 'לתפקיד "ציבור" יש הרשאות, אבל עולם המערכה פרטי. ניתן לשנות זאת בתפריט "שיתוף" בעת עריכת עולם המערכה.',
            'role_permissions'      => 'אפשר לתפקיד \':name\' לעשות את הפעולות הבאות על כל אובייקט.',
        ],
        'members'       => 'משתתפים',
        'permissions'   => [
            'actions'   => [
                'add'           => 'יצירה',
                'delete'        => 'הסרה',
                'edit'          => 'עריכה',
                'entity-note'   => 'פתקי אובייקט',
                'permission'    => 'הרשאות',
                'read'          => 'צפייה',
                'toggle'        => 'שנה להכל',
            ],
            'helpers'   => [
                'entity_note'   => 'זה מאפשר למשתמשים שאין להם אפשרות עריכה להוסיף פתקי אובייקט.',
            ],
            'hint'      => 'לתפקיד זה יש גישה אוטומטית להכל.',
        ],
        'placeholders'  => [
            'name'  => 'שם התפקיד',
        ],
        'show'          => [
            'title' => 'תפקיד \':role, בעולם המערכה',
        ],
        'title'         => 'התפקידים של :name',
        'types'         => [
            'owner'     => 'מנהל',
            'public'    => 'ציבור',
            'standard'  => 'רגיל',
        ],
    ],
];
