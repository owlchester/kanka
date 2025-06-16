<?php

namespace App\Services;

use App\Models\Attribute;
use App\Models\Entity;
use ChrisKonnertz\StringCalc\StringCalc;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class AttributeMentionService
{
    protected array $loadedAttributes = [];

    protected Entity $loadedEntity;

    protected Collection $calculatedAttributes;

    /**
     * Replace references in an attribute name with attribute values for ranges
     *
     * @throws \ChrisKonnertz\StringCalc\Exceptions\ContainerException
     * @throws \ChrisKonnertz\StringCalc\Exceptions\NotFoundException
     */
    public function map(Attribute $attribute, string $field = 'name'): string
    {
        if (! $this->validField((string) $attribute->$field)) {
            return (string) $attribute->$field;
        }

        if (! isset($this->loadedEntity) || $this->loadedEntity->id != $attribute->entity_id) {
            // Referencing an attribute linked to an entity the user can't access
            if (empty($attribute->entity)) {
                return (string) $attribute->$field;
            }
            $this->loadedEntity = $attribute->entity;
        }

        try {
            // Prepare all the attributes and calculates them
            $this->entityAttributes();

            $data = [
                'name' => $attribute->name,
                'value' => $attribute->$field,
            ];
            $value = $this->calculateAttributeValue($data);

            return $value;
        } catch (Exception $e) {
            return $this->$field;
        }
    }

    public function parse(Attribute $attribute, string $field = 'value'): string
    {
        if (! $this->validField((string) $attribute->$field)) {
            return (string) $attribute->$field;
        }

        if (! isset($this->loadedEntity) || $this->loadedEntity->id != $attribute->entity_id) {
            if (empty($attribute->entity)) {
                return (string) $attribute->$field;
            }
            $this->loadedEntity = $attribute->entity;
        }

        try {
            $calculated = $this->entityAttributes()->get($attribute->name);

            return (string) $calculated['final'];
        } catch (Exception $e) {
            // throw $e;
            return (string) $attribute->$field;
        }
    }

    /**
     * Determine if the text contains a valid attribute mention using {}
     * Also ignore anything with html like mentions, as the calculator
     * won't know what to do with such tags.
     */
    protected function validField(?string $value = null): bool
    {
        if (! Str::contains($value, ['{', '}'])) {
            return false;
        }

        return ! (Str::contains($value, ['<', '>']));
    }

    /**
     * Load all the entity attributes and pre-calculate the values
     */
    protected function entityAttributes(): Collection
    {
        if (isset($this->loadedAttributes[$this->loadedEntity->id])) {
            return $this->loadedAttributes[$this->loadedEntity->id];
        }

        $baseAttributes = $this->loadedEntity->attributes()->orderBy('default_order')->pluck('value', 'name');

        $this->calculatedAttributes = new Collection;

        // Prepare our attributes with first level references
        foreach ($baseAttributes as $name => $value) {
            $references = [];
            preg_match_all('`\{(.*?)\}`i', $value, $references);

            // Cleanup attribute name to remove range stuff
            $name = preg_replace('`\[range:(.*)\]`i', '', $name);

            $this->calculatedAttributes->put($name, [
                'value' => $value,
                'loop' => false,
                'name' => $name,
                'final' => null,
                'references' => ! empty($references[1]) ? $references[1] : [],
            ]);
        }

        // Loop through the attributes and calculate the values
        foreach ($this->calculatedAttributes as $name => $attribute) {
            try {
                // @phpstan-ignore-next-line
                $this->calculatedAttributes[$name] = $this->calculateAttribute($attribute);
            } catch (Exception $e) {
                $attribute['loop'] = true;
                $attribute['final'] = $attribute['value'];
                $this->calculatedAttributes[$name] = $attribute;
            }
        }

        return $this->loadedAttributes[$this->loadedEntity->id] = $this->calculatedAttributes;
    }

    /**
     * Replace any attribute mentions in a string and result any math calculations in the resulting string
     *
     * @throws \ChrisKonnertz\StringCalc\Exceptions\ContainerException
     * @throws \ChrisKonnertz\StringCalc\Exceptions\NotFoundException
     */
    protected function calculateAttributeValue(array $data, array $from = []): string
    {
        // If the final version is already calculated, use that

        // dump('parsing ' . $data['name'] . ' value ' . $data['value']);

        // First detect any loops going on here
        if (in_array($data['name'], $from)) {
            throw new Exception('loop detected on ' . $data['name']);
        }

        // Replace any attribute references
        $final = preg_replace_callback('`\{(.*?)\}`i', function ($matches) use ($data, $from) {
            $text = $matches[1];
            // dump('checking for a reference called ' . $text);
            $ref = $this->calculatedAttributes->get($text);
            if ($ref) {
                // dump('has an attribute called it!');
                if (! empty($ref['final'])) {
                    // dump('has a final version too');
                    return $ref['final'];
                } elseif ($ref['loop']) {
                    return 0;
                }
                // dump('calculating final version for ' . $text . ' with value ' . $ref['value']);
                $newFrom = $from;
                $newFrom[] = $data['name'];

                $ref['final'] = $this->calculateAttributeValue($ref, $newFrom);
                $this->calculatedAttributes[$text] = $ref;

                return $ref['final'];
                /*} catch (Exception $e) {
                    $ref['loop'] = true;
                    $ref['final'] = $ref['value'];
                    $this->calculatedAttributes[$text] = $ref;
                    return 0;
                }*/
            }
            if ($text == 'name') {
                return (string) $this->loadedEntity->name;
            }

            return 0;
        }, $data['value']);

        try {
            $calculator = new StringCalc;
            $return = (string) $calculator->calculate($final);

            return $return;
        } catch (Exception $e) {
            return $final;
        }
    }

    /**
     * Calculate the value of an attribute by performing math on it
     */
    protected function calculateAttribute(array $data): array
    {
        if (empty($data['references'])) {
            $data['final'] = $data['value'];

            return $data;
        }

        try {
            $data['final'] = $this->calculateAttributeValue($data, []);
        } catch (Exception $e) {
            // dump($e->getMessage());
            // dd('oh these is a loop in here');
            $data['final'] = 0;
            $data['loop'] = true;
        }

        return $data;
    }

    /**
     * Check if a given attribute is flagged as being in a loop
     */
    public function isLoop(string $name): bool
    {
        if (! isset($this->calculatedAttributes) || $this->calculatedAttributes->isEmpty()) {
            return false;
        }
        $ref = $this->calculatedAttributes->get($name);
        if ($ref) {
            return $ref['loop'];
        }

        return false;
    }

    public function organise(Collection $attributes): array
    {
        $sections = [];
        $section = null;
        /** @var Attribute $attribute */
        foreach ($attributes as $attribute) {
            if ($attribute->isSection()) {
                if ($section !== null) {
                    $sections[] = $section;
                }
                $section = [
                    'id' => $attribute->id,
                    'name' => $attribute->name(),
                    'is_private' => $attribute->is_private,
                    'attributes' => [],
                ];

                continue;
            } elseif ($section === null) {
                $section = [
                    'id' => 0,
                    'attributes' => [],
                ];
            }
            $section['attributes'][] = $attribute;
        }
        $sections[] = $section;

        return $sections;
    }
}
