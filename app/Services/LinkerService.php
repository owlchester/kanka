<?php

namespace App\Services;

class LinkerService
{
    /**
     * @param string $text
     * @return mixed|string
     */
    public static function parse($text = '')
    {
        $text = preg_replace(
            '`\{character:(.*?)\}`sui',
            '<a href="/redirect?what=character&name=$1">$1</a>',
            $text
        );
        $text = preg_replace(
            '`\{item:(.*?)\}`sui',
            '<a href="/redirect?what=items&name=$1">$1</a>',
            $text
        );
        $text = preg_replace(
            '`\{location:(.*?)\}`sui',
            '<a href="/redirect?what=locations&name=$1">$1</a>',
            $text
        );
        $text = preg_replace(
            '`\{(organisation|organization):(.*?)\}`sui',
            '<a href="/redirect?what=organisation&name=$2">$2</a>',
            $text
        );
        $text = preg_replace(
            '`\{family:(.*?)\}`sui',
            '<a href="/redirect?what=families&name=$1">$1</a>',
            $text
        );
        $text = preg_replace(
            '`\{note:(.*?)\}`sui',
            '<a href="/redirect?what=notes&name=$1">$1</a>',
            $text
        );
        return $text;
    }
}
