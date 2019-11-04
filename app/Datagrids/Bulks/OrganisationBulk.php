<?php


namespace App\Datagrids\Bulks;


class OrganisationBulk extends Bulk
{
    protected $fields = [
        'name',
        'type',
        'location_id',
        'organisation_id',
        'tags',
        'private_choice',
    ];
}
