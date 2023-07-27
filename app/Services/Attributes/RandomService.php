<?php

namespace App\Services\Attributes;

use App\Models\Attribute;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Exception;

class RandomService
{
    protected int $type;
    protected mixed $value;
    /**
     * Rewrite an attribute if it's a random value
     * @param int $type
     * @param string $value
     * @return array[string, string]
     */
    public function randomAttribute(int $type, mixed $value): array
    {
        // Special case if the attribute is a random
        if ($type != Attribute::TYPE_RANDOM_ID) {
            return [$type, $value];
        }

        // Remap the type to a number attribute
        $this->type = Attribute::TYPE_STANDARD_ID;
        $this->value = $value;

        try {
            // List of strings separated by commas
            if (Str::contains($this->value, ',')) {
                return $this->fromList();
            } elseif (Str::contains($this->value, '-')) {
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
     * @return array
     */
    protected function fromList(): array
    {
        $values = explode(',', $this->value);
        $validValues = [];
        foreach ($values as $val) {
            $val = trim($val);
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
     * @return array
     */
    protected function fromRange(): array
    {
        // Numerical value
        $values = explode('-', $this->value);
        if (count($values) !== 2) {
            return [$this->type, $this->value];
        }

        $min = (int) trim($values[0]);
        $max = (int) trim($values[1]);

        return [$this->type, mt_rand($min, $max)];
    }
}
