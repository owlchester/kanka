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
        'title' => 'דמות חדשה',
    ],
    'destroy'       => [],
    'dice_rolls'    => [
        'hint'  => 'גלגולים יכולים להיות משוייכים לדמות לשימוש בעת משחק.',
        'title' => 'הגלגולים של :name',
    ],
    'edit'          => [],
    'fields'        => [
        'age'                       => 'גיל',
        'is_dead'                   => 'מת',
        'is_personality_visible'    => 'אישיות חשופה',
        'life'                      => 'חיים',
        'physical'                  => 'פיזי',
        'sex'                       => 'מגדר',
        'title'                     => 'תואר',
        'traits'                    => 'מאפיינים',
    ],
    'helpers'       => [
        'age'   => 'ניתן לקשר דמות זו ללוח שנה כדי לעדכן את הגיל שלה אוטומטית. :more.',
    ],
    'hints'         => [
        'is_dead'                   => 'הדמות הזו מתה',
        'is_personality_visible'    => 'ניתן להסתיר את כל האישיות מכל משתמש שאינו "מנהל".',
    ],
    'index'         => [],
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
        'personality_entry' => 'תיאור',
        'personality_name'  => 'מטרות, פחדים, קשרים',
        'physical'          => 'פיזי',
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
            'organisations' => 'אירגונים',
        ],
    ],
    'warnings'      => [
        'personality_hidden'    => 'אין לך הרשאה לערוך את האישיות של דמות זו.',
    ],
];
