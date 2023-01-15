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

        // Take X random characters
        $take = 8;
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
        $data['entities'][5]['name'] = 'Francis-Pedro Morley';
        $data['entities'][6]['name'] = 'Frederico Morley';
        $data['entities'][7]['name'] = 'Fabiano Morley-Sadhet';

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
                        'children' => [
                            // First child, with husband
                            [
                                'entity_id' => 3,
                                'relations' => [
                                    [
                                        'entity_id' => 4,
                                        'role' => 'Husband',
                                        'children' => [
                                            [
                                                'entity_id' => 5,
                                            ],
                                            [
                                                'entity_id' => 6,
                                            ],
                                            [
                                                'entity_id' => 7,
                                                'relations' => [
                                                    [
                                                        'entity_id' => 6
                                                    ]
                                                ]
                                            ],
                                            [
                                                'entity_id' => 1,
                                            ],
                                        ],
                                    ]
                                ]
                            ],
                            [
                                'entity_id' => 7
                            ]
                        ],
                    ],
                    // Second relation, ex-wife, with child
                    [
                        'entity_id' => 2,
                        'role' => 'Ex-wife',
                        'children' => [
                            // Child
                            [
                                'entity_id' => 4,
                            ],
                            [
                                'entity_id' => 7,
                            ]
                        ],
                        'largest_node' => 2
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
