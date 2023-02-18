<?php

namespace App\Http\Controllers\Entity;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Traits\GuestAuthTrait;
use ReflectionClass;

class DescendantController extends Controller
{
    use GuestAuthTrait;

    public function index(Campaign $campaign, Entity $entity)
    {
        if (empty($entity->child)) {
            abort(401);
        }
        if (auth()->check()) {
            $this->authorize('view', $entity->child);
        } else {
            $this->authorizeEntityForGuest(\App\Models\CampaignPermission::ACTION_READ, $entity->child);
        }

        $options = ['campaign' => $campaign, 'entity' => $entity];
        $filters = [];
        if (request()->has('parent_id')) {
            $options['parent_id'] = $entity->entity_id;
            if ($entity->isLocation()) {
                $filters['parent_location_id'] = $entity->entity_id;
            } else {
                $filters[strtolower($entity->entityType()) . '_id'] = $entity->entity_id;
            }
        }

        // Figure out the correct datagrid
        $reflect = new ReflectionClass($entity->child);
        $short = $reflect->getShortName();
        $datagridClass = 'App\Renderers\Layouts\\' . $short . '\\' . $short;
        Datagrid::layout($datagridClass)
            ->route('entities.descendants', $options);

        // @phpstan-ignore-next-line
        $this->rows = $entity->child
            ->descendants()
            ->sort(request()->only(['o', 'k']))
            ->filter($filters)
            ->descendantDatagrid()
            ->has('entity')
            ->paginate();

        if (request()->ajax()) {
            return $this->datagridAjax();
        }
        return view('entities.pages.descendants.index')
            ->with('entity', $entity)
            ->with('campaign', $campaign)
            ->with('rows', $this->rows)
        ;
    }

    protected function datagridAjax()
    {
        $html = view('layouts.datagrid._table')
            ->with('rows', $this->rows)
            ->render();
        $deletes = view('layouts.datagrid.delete-forms')
            ->with('models', Datagrid::deleteForms())
            ->with('params', Datagrid::getActionParams())
            ->render();

        $data = [
            'success' => true,
            'html' => $html,
            'deletes' => $deletes,
        ];

        return response()->json($data);
    }
}
