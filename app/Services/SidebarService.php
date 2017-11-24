<?php

namespace App\Services;

use App\Campaign;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SidebarService
{
    protected $rules = [
        'characters' => [
            'characters',
            'character_relation',
        ],
        'events' => [
            'events',
        ],
        'families' => [
            'families',
            'family_relation',
        ],
        'items' => [
            'items',
        ],
        'journals' => [
            'journals',
        ],
        'locations' => [
            'locations',
        ],
        'notes' => [
            'notes',
        ],
        'organisations' => [
            'organisations',
            'organisation_member',
        ],
        'other' => [
            'releases',
        ],
        'quests' => [
            'quests',
        ],
        'releases' => [
            'releases'
        ],
    ];

    /**
     * @param $menu
     */
    public function active($menu = '', $class = 'active')
    {
        if (empty($this->rules[$menu])) {
            return null;
        }

        foreach ($this->rules[$menu] as $rule) {
            if (request()->segment(2) == $rule) { //('/' . $rule . '/')) {
                return " $class";
            }
        }
        return null;
    }

    /**
     * @param string $menu
     * @param string $css
     * @return null|string
     */
    public function open($menu = '', $css = 'menu-open')
    {
        if (empty($this->rules[$menu])) {
            return null;
        }

        foreach ($this->rules[$menu] as $rule) {
            if (request()->segment(2) == $rule) {
                return $css;
            }
        }
        return null;
    }
}
