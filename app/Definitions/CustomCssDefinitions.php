<?php

namespace App\Definitions;

use HTMLPurifier_AttrDef_CSS_AlphaValue;
use HTMLPurifier_AttrDef_CSS_Composite;
use HTMLPurifier_AttrDef_CSS_Length;
use HTMLPurifier_AttrDef_CSS_Percentage;
use HTMLPurifier_CSSDefinition;
use Stevebauman\Purify\Definitions\CssDefinition;

class CustomCssDefinitions implements CssDefinition
{
    public static function apply(HTMLPurifier_CSSDefinition $definition): void
    {
        $definition->info['opacity'] = new HTMLPurifier_AttrDef_CSS_AlphaValue;

        $borderRadius = new HTMLPurifier_AttrDef_CSS_Composite([
            new HTMLPurifier_AttrDef_CSS_Length('0'),
            new HTMLPurifier_AttrDef_CSS_Percentage(true),
        ]);
        $definition->info['border-radius'] = $borderRadius;
    }
}
