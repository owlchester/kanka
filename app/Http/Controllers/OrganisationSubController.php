<?php

namespace App\Http\Controllers;

use App\Facades\Datagrid;
use App\Models\Campaign;
use App\Models\Organisation;

class OrganisationSubController extends OrganisationController
{
    /**
     * @param Organisation $organisation
     */
    public function organisations(Campaign $campaign, Organisation $organisation)
    {
        $this->authCheck($organisation);

        $options = ['campaign' => $campaign, 'organisation' => $organisation];
        $filters = [];
        if (request()->has('parent_id')) {
            $options['organisation_id'] = $organisation->id;
            $filters['organisation_id'] = $organisation->id;
        }

        Datagrid::layout(\App\Renderers\Layouts\Organisation\Organisation::class)
            ->route('organisations.organisations', $options);

        // @phpstan-ignore-next-line
        $this->rows = $organisation
            ->descendants()
            ->sort(request()->only(['o', 'k']))
            ->with([
                'entity', 'entity.image', 'entity.tags',
                'organisation', 'organisation.entity'
            ])
            ->filter($filters)
            ->paginate();

        if (request()->ajax()) {
            return $this->datagridAjax();
        }

        return $this
            ->menuView($organisation, 'organisations');
    }

    /**
     * @param Organisation $organisation
     */
    public function members(Campaign $campaign, Organisation $organisation)
    {
        $this->authCheck($organisation);

        $options = ['campaign' => $campaign, 'organisation' => $organisation];
        $base = 'members';
        if (request()->has('all')) {
            $options['all'] = true;
            $base = 'allMembers';
        }
        Datagrid::layout(\App\Renderers\Layouts\Organisation\Member::class)
            ->route('organisations.members', $options)
            ->actionParams(['campaign' => $campaign->id, 'from' => 'org']);

        $this->rows = $organisation
            ->{$base}()
            ->with([
                'organisation', 'organisation.entity',
                'parent', 'parent.character',
                'character', 'character.entity', 'character.entity.image',
                'character.location', 'character.location.entity'])
            ->has('character')
            ->has('character.entity')
            ->sort(request()->only(['o', 'k']))
            ->paginate(15);

        // Ajax Datagrid
        if (request()->ajax()) {
            return $this->datagridAjax();
        }
        return $this
            ->menuView($organisation, 'members');
    }
}
