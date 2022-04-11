<?php

return [
    'actions'       => [
        'add_appearance'    => 'הוסף תיאור',
        'add_organisation'  => 'הוסף ארגון',
        'add_personality'   => 'הוסף אישיות',
    ],
    'conversations' => [
        'title' => 'השיחות של :name',
    ],
    'create'        => [
        'success'   => 'הדמות \':name\' נוצרה.',
        'title'     => 'דמות חדשה',
    ],
    'destroy'       => [
        'success'   => 'הדמות \':name\' הוסרה.',
    ],
    'dice_rolls'    => [
        'hint'  => 'גלגולים יכולים להיות משוייכים לדמות לשימוש בעת משחק.',
        'title' => 'הגלגולים של :name',
    ],
    'edit'          => [
        'success'   => 'הדמות \':name\' עודכנה',
        'title'     => 'ערוך דמות :name',
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
    ],
    'hints'         => [
        'is_dead'                   => 'הדמות הזו מתה',
        'is_personality_visible'    => 'ניתן להסתיר את כל האישיות מכל משתמש שאינו "מנהל".',
    ],
    'index'         => [
        'actions'   => [
            'random'    => 'דמות אקראית חדשה',
        ],
        'add'       => 'דמות חדשה',
        'header'    => 'דמויות ב:name',
        'title'     => 'דמויות',
    ],
    'items'         => [
        'hint'  => 'ניתן לשייך חפצים לדמויות, והם יופיעו כאן.',
        'title' => 'החפצים של :name',
    ],
    'journals'      => [
        'title' => 'היומנים של :name',
    ],
    'maps'          => [
        'title' => 'מפת יחסים של הדמות :name',
    ],
    'organisations' => [
        'actions'       => [
            'add'   => 'הוסף אירגון',
        ],
        'create'        => [
            'success'   => 'הדמות הוספה לאירגון.',
            'title'     => 'אירגון חדש ל:name',
        ],
        'destroy'       => [
            'success'   => 'האירגון הוסר.',
        ],
        'edit'          => [
            'success'   => 'האירגון של הדמות עודכן.',
            'title'     => 'עדכן אירגון ל:name.',
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
        'helpers'   => [
            'quest_giver'   => 'משימות שהדמות היא המעניקה שלהן.',
            'quest_member'  => 'משימות שהדמות לוקחת בהן חלק',
        ],
    ],
    'sections'      => [
        'appearance'    => 'מראה',
        'general'       => 'מידע כללי',
        'personality'   => 'אישיות',
    ],
    'show'          => [
        'tabs'  => [
            'map'           => 'מפת יחסים',
            'organisations' => 'אירגונים',
        ],
        'title' => 'דמות :name',
    ],
    'warnings'      => [
        'personality_hidden'    => 'אין לך הרשאה לערוך את האישיות של דמות זו.',
    ],
];
