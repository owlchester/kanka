<?php

namespace App\Definitions;

use HTMLPurifier_HTMLDefinition;
use Stevebauman\Purify\Definitions\Definition;
use Stevebauman\Purify\Definitions\Html5Definition;

class CustomDefinitions implements Definition
{
    public static function apply(HTMLPurifier_HTMLDefinition $def)
    {
        Html5Definition::apply($def);

        // Mentions
        $def->addAttribute('a', 'data-toggle', 'Text');
        $def->addAttribute('a', 'data-dropdown', 'Text');
        $def->addAttribute('a', 'data-pulse', 'Text');
        $def->addAttribute('a', 'data-animate', 'Text');
        $def->addAttribute('a', 'data-tooltip', 'Text');
        $def->addAttribute('a', 'data-title', 'Text');
        $def->addAttribute('a', 'data-html', 'Text');
        $def->addAttribute('a', 'data-entity-type', 'Text');
        $def->addAttribute('a', 'target', 'Text');

        $def->addAttribute('th', 'colwidth', 'Text');
        $def->addAttribute('td', 'colwidth', 'Text');

        // Gallery
        $def->addAttribute('img', 'data-gallery-id', 'Text');
        $def->addAttribute('img', 'data-uuid', 'Text');

        $def->addAttribute('ul', 'role', 'Text');
        $def->addAttribute('ol', 'role', 'Text');
        $def->addAttribute('li', 'role', 'Text');
        $def->addAttribute('div', 'role', 'Text');
        $def->addAttribute('a', 'role', 'Text');

        // Task lists
        $def->addAttribute('ul', 'data-type', 'Text');
        $def->addAttribute('li', 'data-type', 'Text');
        $def->addAttribute('li', 'data-checked', 'Text');
        $def->addElement('label', 'Inline', 'Inline', 'Common');
        $def->addElement('input', 'Inline', 'Empty', 'Common', [
            'type' => new \HTMLPurifier_AttrDef_Enum(['checkbox']),
            'checked' => new \HTMLPurifier_AttrDef_HTML_Bool(true),
            'disabled' => new \HTMLPurifier_AttrDef_HTML_Bool(true),
        ]);

        $def->addElement(
            'details',
            'Block',
            'Flow',
            'Common',
            [
                'open' => new \HTMLPurifier_AttrDef_HTML_Bool(true),
            ]
        );
        $def->addElement(
            'section',
            'Block',
            'Flow',
            'Common'
        );

        $def->addElement(
            'aside',
            'Block',
            'Flow',
            'Common'
        );
        $def->addElement(
            'sidebar',
            'Block',
            'Flow',
            'Common'
        );

        $def->addElement('summary', 'Inline', 'Inline', 'Common');
        $def->addElement('mark', 'Inline', 'Inline', 'Common');

        // Ordered list attributes
        $def->addAttribute('ol', 'start', 'Number');
        $def->addAttribute('ol', 'type', 'Text');
        $def->addAttribute('li', 'value', 'Number');

        // Table cell vertical alignment
        $def->addAttribute('td', 'valign', 'Text');
        $def->addAttribute('th', 'valign', 'Text');
    }
}
