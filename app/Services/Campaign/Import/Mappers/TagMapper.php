<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Tag;

class TagMapper extends StandardTreeMapper
{
    /** @var array<string, string> Legacy named colour to hex mapping for old exports */
    protected const LEGACY_COLOURS = [
        'red' => 'D93D33',
        'yellow' => 'f39c12',
        'brown' => 'a35831',
        'aqua' => '00829B',
        'light-blue' => '3A7CAD',
        'green' => '058943',
        'navy' => '001F3F',
        'teal' => '2D8289',
        'orange' => 'C85208',
        'purple' => '605ca8',
        'maroon' => 'D81B60',
        'grey' => '797676',
        'gray' => '797676',
        'pink' => 'C822D7',
        'black' => '111111',
    ];

    protected array $ignore = ['id', 'entry', 'type', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'tag_id', 'created_at', 'updated_at'];

    protected string $className = Tag::class;

    protected string $mappingName = 'tags';

    public function first(): void
    {
        $this->convertLegacyColour();

        $this
            ->prepareModel()
            ->trackMappings('tag_id');
    }

    /**
     * Convert legacy named colour values from old exports to hex
     */
    protected function convertLegacyColour(): void
    {
        if (! empty($this->data['colour']) && isset(self::LEGACY_COLOURS[$this->data['colour']])) {
            $this->data['colour'] = self::LEGACY_COLOURS[$this->data['colour']];
        }
    }
}
