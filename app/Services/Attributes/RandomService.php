<?php

namespace App\Services\Attributes;

use App\Enums\AttributeType;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Exception;

class RandomService
{
    protected AttributeType $type;
    protected mixed $value;
    /**
     * Rewrite an attribute if it's a random value
     * @return array[AttributeType, string]
     */
    public function randomAttribute(AttributeType $type, mixed $value): array
    {
        // Special case if the attribute is a random
        if ($type != AttributeType::Random) {
            return [$type, $value];
        }

        // Remap the type to a number attribute
        $this->type = AttributeType::Standard;
        $this->value = $value;

        try {
            // List of strings separated by commas
            if (Str::contains($this->value, ',')) {
                return $this->fromList();
            } elseif (Str::contains($this->value, '-')) {
                $this->type = AttributeType::Number;
                return $this->fromRange();
            }
        } catch (Exception $e) {
            // Something went wrong, let's assume the random value is badly formatted
            return [$this->type, $this->value];
        }

        return [$this->type, $this->value];
    }

    /**
     * Split an attribute by comma, selecting a value from the list
     */
    protected function fromList(): array
    {
        $values = explode(',', $this->value);
        $validValues = [];
        foreach ($values as $val) {
            $val = mb_trim($val);
            if (!empty($val)) {
                $validValues[] = $val;
            }
        }

        if (empty($validValues)) {
            return [$this->type, $this->value];
        } elseif (count($validValues) == 1) {
            return [$this->type, Arr::first($validValues)];
        }

        return [$this->type, Arr::random($validValues)];
    }

    /**
     * Fine a value between a range
     */
    protected function fromRange(): array
    {
        // Numerical value
        $values = explode('-', $this->value);
        if (count($values) !== 2) {
            return [$this->type, $this->value];
        }

        $min = (int) mb_trim($values[0]);
        $max = (int) mb_trim($values[1]);

        return [$this->type, mt_rand($min, $max)];
    }
}
