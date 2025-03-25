<?php

namespace App\View\Components\Buttons;

trait Colours
{
    public function colour(): string
    {
        if ($this->type === 'danger') {
            if ($this->outline) {
                return 'btn2 btn-error btn-outline';
            }

            return 'btn2 btn-error';
        } elseif ($this->type === 'primary') {
            if ($this->outline) {
                return 'btn2 btn-primary btn-outline';
            }

            return 'btn2 btn-primary';
        } elseif ($this->type === 'secondary') {
            if ($this->outline) {
                return 'btn2 btn-secondary btn-outline';
            }

            return 'btn2 btn-secondary';
        } elseif ($this->type === 'ghost') {
            return 'btn2 btn-ghost';
        }

        if ($this->outline) {
            return '';
        }

        // Default
        return '';
    }
}
