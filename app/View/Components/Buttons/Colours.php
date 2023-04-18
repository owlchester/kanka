<?php

namespace App\View\Components\Buttons;

trait Colours
{
    public function colour(): string
    {
        if ($this->type === 'danger') {
            if ($this->outline) {
                return 'text-red-500 border-red-500 hover:bg-red-500 hover:border-red-500 hover:text-white';
            }
            return 'text-white border-red-500 bg-red-500 hover:bg-red-700 hover:border-red-700';
        } elseif ($this->type === 'primary') {
            if ($this->outline) {
                return 'text-blue-500 border-blue-500 hover:bg-blue-500 hover:border-blue-500 hover:text-white';
            }
            return 'text-white border-blue-500 bg-blue-500 hover:bg-blue-700 hover:border-blue-700';
        } elseif ($this->type === 'ghost') {
            return 'border-0 hover:bg-gray-200';
        }

        if ($this->outline) {
            return '';
        }

        // Default
        return '';
    }
}
