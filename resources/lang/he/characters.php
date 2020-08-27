<?php

return [
    'actions'       => [
        'add_appearance'    => 'הוסף תיאור',
        'add_organisation'  => 'הוסף ארגון',
        'add_personality'   => 'הוסף אישיות',
    ],
    'conversations' => [
        'description'   => 'שיחות בהן הדמות משתתפת.',
        'title'         => 'השיחות של :name',
    ],
    'create'        => [
        'description'   => 'צור דמות חדשה',
        'success'       => 'הדמות \':name\' נוצרה.',
        'title'         => 'דמות חדשה',
    ],
    'destroy'       => [
        'success'   => 'הדמות \':name\' הוסרה.',
    ],
    'dice_rolls'    => [
        'description'   => 'גלגולים משוייכים לדמות.',
        'hint'          => 'גלגולים יכולים להיות משוייכים לדמות לשימוש בעת משחק.',
        'title'         => 'הגלגולים של :name',
    ],
    'edit'          => [
        'description'   => 'ערוך דמות',
        'success'       => 'הדמות \':name\' עודכנה',
        'title'         => 'ערוך דמות :name',
    ],
    'fields'        => [
        'age'                       => 'גיל',
        'family'                    => 'משפחה',
        'image'                     => 'תמונה',
        'is_dead'                   => 'מת',
        'is_personality_visible'    => 'אישיות חשופה',
        'life'                      => 'חיים',
        'location'                  => 'מיקום',
        'name'                      => 'שם',
        'physical'                  => 'פיזי',
        'race'                      => 'גזע',
        'relation'                  => 'יחס',
        'sex'                       => 'מגדר',
        'title'                     => 'תואר',
        'traits'                    => 'מאפיינים',
        'type'                      => 'סוג',
    ],
    'helpers'       => [
        'age'   => 'ניתן לקשר דמות זו ללוח שנה כדי לעדכן את הגיל שלה אוטומטית. :more.',
        'free'  => 'לאן הלך השדה "Free"? אם לדמות הזאת היה כזה, הוא עבר ל"פתקים"!',
    ],
    'hints'         => [
        'hide_personality'          => 'ניתן להסתיר את הכרטיסיה הזו מכל מי שאינו "מנהל" על ידי הסרת הסימון "אישיות חשופה" בעת עריכת הדמות.',
        'is_dead'                   => 'הדמות הזו מתה',
        'is_personality_visible'    => 'ניתן להסתיר את כל האישיות מכל משתמש שאינו "מנהל".',
    ],
    'index'         => [
        'actions'       => [
            'random'    => 'דמות אקראית חדשה',
        ],
        'add'           => 'דמות חדשה',
        'description'   => 'ניהול הדמויות של :name.',
        'header'        => 'דמויות ב:name',
        'title'         => 'דמויות',
    ],
    'items'         => [
        'description'   => 'חפצים השייכים לדמות.',
        'hint'          => 'ניתן לשייך חפצים לדמויות, והם יופיעו כאן.',
        'title'         => 'החפצים של :name',
    ],
    'journals'      => [
        'description'   => 'יומנים שהדמות כתבה.',
        'title'         => 'היומנים של :name',
    ],
    'maps'          => [
        'description'   => 'מפת קשרים של הדמות.',
        'title'         => 'מפת יחסים של הדמות :name',
    ],
    'organisations' => [
        'actions'       => [
            'add'   => 'הוסף אירגון',
        ],
        'create'        => [
            'description'   => 'שייך דמות לאירגון',
            'success'       => 'הדמות הוספה לאירגון.',
            'title'         => 'אירגון חדש ל:name',
        ],
        'description'   => 'אירגונים שהדמות שייכת אליהם.',
        'destroy'       => [
            'success'   => 'האירגון הוסר.',
        ],
        'edit'          => [
            'description'   => 'עדכן את האירגונים של הדמות.',
            'success'       => 'האירגון של הדמות עודכן.',
            'title'         => 'עדכן אירגון ל:name.',
        ],
        'fields'        => [
            'organisation'  => 'אירגון',
            'role'          => 'תפקיד',
        ],
        'hint'          => 'דמויות יכולות להיות למספר אירגונים, כדי לייצג עבור מי הן עובדות או לאיזה אירגון סודי הן שייכות.',
        'placeholders'  => [
            'organisation'  => 'בחר אירגון...',
        ],
        'title'         => 'האירגונים של :name',
    ],
    'placeholders'  => [
        'age'               => 'גיל',
        'appearance_entry'  => 'תיאור',
        'appearance_name'   => 'שיער, עיניים, עור, גובה',
        'family'            => 'בחר דמות',
        'image'             => 'תמונה',
        'location'          => 'בחר מיקום',
        'name'              => 'שם',
        'personality_entry' => 'תיאור',
        'personality_name'  => 'מטרות, פחדים, קשרים',
        'physical'          => 'פיזי',
        'race'              => 'גזע',
        'sex'               => 'מגדר',
        'title'             => 'תואר',
        'traits'            => 'מאפיינים',
        'type'              => 'דמות שחקן, דב"ש, סוחר, מלאך',
    ],
    'quests'        => [
        'description'   => 'משימות שהדמות משתתפת בהן',
        'helpers'       => [
            'quest_giver'   => 'משימות שהדמות היא המעניקה שלהן.',
            'quest_member'  => 'משימות שהדמות לוקחת בהן חלק',
        ],
        'title'         => 'המשימות של הדמות :name',
    ],
    'sections'      => [
        'appearance'    => 'מראה',
        'general'       => 'מידע כללי',
        'personality'   => 'אישיות',
    ],
    'show'          => [
        'description'   => 'מבט מפורט של דמות',
        'tabs'          => [
            'conversations' => 'שיחות',
            'dice_rolls'    => 'גלגולי קוביה',
            'items'         => 'חפצים',
            'journals'      => 'יומנים',
            'map'           => 'מפת יחסים',
            'organisations' => 'אירגונים',
            'personality'   => 'אישיות',
            'quests'        => 'משימות',
        ],
        'title'         => 'דמות :name',
    ],
    'warnings'      => [
        'personality_hidden'    => 'אין לך הרשאה לערוך את האישיות של דמות זו.',
    ],
];
