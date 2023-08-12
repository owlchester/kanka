<?php

namespace App\Services\Abilities;

use App\Models\Ability;
use App\Models\Attribute;
use App\Traits\EntityAware;
use ChrisKonnertz\StringCalc\StringCalc;
use Exception;
use Illuminate\Support\Collection;

abstract class BaseAbilityService
{
    use EntityAware;

    protected Collection $attributes;

    /**
     * @param Ability $ability
     * @return int|string|null
     */
    protected function parseCharges(Ability $ability)
    {
        if (empty($ability->charges)) {
            return null;
        }

        if (is_int($ability->charges)) {
            return $ability->charges;
        }
        try {
            return $this->mapAttributes($ability->charges);
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * @param Ability $ability
     * @return float|int|mixed
     */
    protected function parseEntry(Ability $ability)
    {
        $entry = $ability->entry();
        try {
            return $this->mapAttributes($entry, false);
        } catch (Exception $e) {
            return $entry;
        }
    }

    /**
     * @param string $haystack
     * @param bool $calc
     * @return float|int|string|null
     * @throws \ChrisKonnertz\StringCalc\Exceptions\ContainerException
     * @throws \ChrisKonnertz\StringCalc\Exceptions\NotFoundException
     */
    protected function mapAttributes(string $haystack, bool $calc = true)
    {
        // Replace {} with entity attributes
        $mappedText = preg_replace_callback('`\{(.*?)\}`i', function ($matches) {
            //dd($matches);
            $text = $matches[1];
            if ($this->entityAttributes()->has($text)) {
                return $this->entityAttributes()->get($text);
            }
            return 0;
        }, $haystack);

        if (!$calc) {
            return $mappedText;
        }

        $calculator = new StringCalc();
        return $calculator->calculate($mappedText);
    }
    /**
     * @return array|\Illuminate\Support\Collection
     */
    protected function entityAttributes()
    {
        if (isset($this->attributes)) {
            return $this->attributes;
        }

        $this->attributes = new Collection();

        /** @var Attribute $attribute */
        foreach ($this->entity->attributes as $attribute) {
            $this->attributes->put($attribute->name, $attribute->mappedValue());
        }

        return $this->attributes;
    }
}