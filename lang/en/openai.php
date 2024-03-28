<?php

return [
    /** Without "fantasy", the bias is more towards the modern world. The setting might need to be user controlled */
    //'intro' => 'Write three paragraphs about a fantasy character.',
    'intro' => 'You\'re the best professional writer who will write three paragraphs about a fantasy character inspired by the provided characteristics and prompt.',
    'intro-named' => 'The character is named :name.',
    'intro-gender' => 'The character\'s gender is :gender.',
    'intro-pronouns' => 'The character\'s pronouns are :pronouns, use these when refering to the character.',

    'paragraphs' => [
        'first' => 'The first paragraph is about the character\'s :option,',
        'second' => 'the second paragraph is about the character\'s :option,',
        'third' => 'the third paragraph is about the character\'s :option,',
    ],
    'closing' => "the prompt is: :prompt",
];
