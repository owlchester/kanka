<?php

namespace App\Support\HtmlPurifier;

use HTMLPurifier_AttrDef;
use HTMLPurifier_AttrDef_Enum;
use Illuminate\Support\Str;

class CalcStyleDefinition extends HTMLPurifier_AttrDef
{
    /**
     * Bool indicating whether enumeration is case-sensitive.
     * @note In general this is always case-insensitive.
     */
    protected bool $caseSensitive = false; // values according to W3C spec

    /**
     * @param bool $caseSensitive Whether case-sensitive
     */
    public function __construct(bool $caseSensitive = false)
    {
        $this->caseSensitive = $caseSensitive;
    }

    /**
     * @param string $string
     * @param \HTMLPurifier_Config $config
     * @param \HTMLPurifier_Context $context
     * @return bool|string
     */
    public function validate($string, $config, $context)
    {
        $string = mb_trim($string);
        if (!$this->caseSensitive) {
            // we may want to do full case-insensitive libraries
            $string = ctype_lower($string) ? $string : mb_strtolower($string);
        }
        if (Str::contains($string, ['&', '<'])) {
            return false;
        }
        $result = preg_match('`calc\((.*)\)`', $string);

        return $result ? $string : false;
    }

    /**
     * I have no idea what this is for, sorry.
     *
     * @param string $string In form of comma-delimited list of case-insensitive
     *      valid values. Example: "foo,bar,baz". Prepend "s:" to make
     *      case-sensitive
     * @return HTMLPurifier_AttrDef_Enum
     */
    public function make($string)
    {
        if (mb_strlen($string) > 2 && $string[0] == 's' && $string[1] == ':') {
            $string = mb_substr($string, 2);
            $sensitive = true;
        } else {
            $sensitive = false;
        }
        $values = explode(',', $string);
        return new HTMLPurifier_AttrDef_Enum($values, $sensitive);
    }
}
