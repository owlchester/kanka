<?php

namespace App\Services\Families;

use App\Models\Character;
use App\Models\Family;

class FamilyTreeService
{
    protected Family $family;

    public function family(Family $family): self
    {
        $this->family = $family;
        return $this;
    }

    public function api(): array
    {
        return $this->fake();
    }

    /**
     * Fake data for the family tree until we have actual data
     * @return array
     */
    protected function fake(): array
    {
        $campaign = $this->family->campaign;

        // Take 6 random characters
        $take = 6;
        $characters = Character::with('entity')->has('entity')->take($take)->get();

        if (count($characters) != $take) {
            return $this->error('fake.not-enough-characters');
        }

        $data = [
            'entities' => [],
        ];

        /**
         * Prepare entities
         */
        $key = 0;
        /** @var Character $character */
        foreach ($characters as $character) {
            $data['entities'][$key] = [
                'id' => $key,
                'name' => $character->name,
                'url' => $character->getLink(),
                'thumb' => $character->thumbnail()
            ];
            $key++;
        }
        $data['entities'][0]['name'] = 'Adam Morley';
        $data['entities'][1]['name'] = 'Elise Morley';
        $data['entities'][2]['name'] = 'Martha Evergreen';
        $data['entities'][3]['name'] = 'Sofie Morley';
        $data['entities'][4]['name'] = 'Boris Morley';
        $data['entities'][5]['name'] = 'Francis Morley';

        /**
         * Build nodes
         */
        $data['nodes'] = [
            [
                'entity_id' => 0,
                'relations' => [
                    // First relation, current wife with kids
                    [
                        'entity_id' => 1,
                        'role' => 'Wife',
                        'nodes' => [
                            // First child, with husband
                            [
                                'entity_id' => 3,
                                'relations' => [
                                    [
                                        'entity_id' => 4,
                                        'role' => 'Husband',
                                        'nodes' => [
                                            [
                                                'entity_id' => 5,
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ],
                    ],
                    // Second relation, ex-wife, with child
                    [
                        'entity_id' => 2,
                        'role' => 'Ex-wife',
                        'nodes' => [
                            // Child
                            [
                                'entity_id' => 4,
                            ]
                        ]
                    ]
                ]
            ]
        ];

        return $data;
    }

    /**
     * Return an error handled by the frontend
     * @param string $code
     * @return array
     */
    protected function error(string $code): array
    {
        return [
            'error' => true,
            'code' => __($code)
        ];
    }
}
