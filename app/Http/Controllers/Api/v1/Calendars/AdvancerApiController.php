<?php

namespace App\Http\Controllers\Api\v1\Calendars;

use App\Http\Controllers\Api\v1\ApiController;
use App\Models\Calendar;
use App\Models\Campaign;
use App\Services\Calendars\AdvancerService;
use App\Services\Entity\EntitySaveService;
use App\Services\Entity\Relations\EntityRelationsServiceFactory;
use Illuminate\Http\JsonResponse;

class AdvancerApiController extends ApiController
{
    protected AdvancerService $service;

    public function __construct(
        EntitySaveService $entitySaveService,
        EntityRelationsServiceFactory $relationsFactory,
        AdvancerService $service,
    ) {
        parent::__construct($entitySaveService, $relationsFactory);
        $this->service = $service;
    }

    /**
     * @return JsonResponse
     */
    public function advance(Campaign $campaign, Calendar $calendar)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $calendar->entity);
        if ($calendar->missingDetails()) {
            return response()->json(['Invalid calendar config'], 406);
        }
        $this->service->calendar($calendar)->advance();

        return response()->json(['date' => $calendar->date]);
    }

    /**
     * @return JsonResponse
     */
    public function retreat(Campaign $campaign, Calendar $calendar)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $calendar->entity);
        if ($calendar->missingDetails()) {
            return response()->json(['Invalid calendar config'], 406);
        }
        $this->service->calendar($calendar)->retreat();

        return response()->json(['date' => $calendar->date]);
    }
}
