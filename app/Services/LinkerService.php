<?php

namespace App\Services;

class LinkerService
{
    /**
     * @var array
     */
    protected $elements = [
        'character',
        //'event',
        'family',
        'item',
        'journal',
        'location',
        'note',
        'organisation',
    ];

    /**
     * Get the elements
     * @return array
     */
    public function elements()
    {
        return $this->elements;
    }

    /**
     * @param string $text
     * @return mixed|string
     */
    public function parse($text = '')
    {
        foreach ($this->elements() as $element) {
            $text = preg_replace(
                '`\{' . $element . ':(.*?)\}`sui',
                '<a href="/redirect?what=' . $element . '&name=$1">$1</a>',
                $text
            );
        }

        // Bonus for our american friends.
        $text = preg_replace(
            '`\{organization:(.*?)\}`sui',
            '<a href="/redirect?what=organisation&name=$2">$2</a>',
            $text
        );

        return $text;
    }
}
