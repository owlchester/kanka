<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Entity\ExportService;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;
use Illuminate\Support\Str;
use League\HTMLToMarkdown\Converter\TableConverter;
use League\HTMLToMarkdown\HtmlConverter;

/**
 * Class ExportController
 */
class ExportController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

    protected ExportService $service;

    public function __construct(ExportService $service)
    {
        $this->service = $service;
    }

    public function json(Campaign $campaign, Entity $entity)
    {
        $this->campaign($campaign)->authEntityView($entity);

        return $this->service->entity($entity)->json();
    }

    public function markdown(Campaign $campaign, Entity $entity)
    {
        $this->campaign($campaign)->authEntityView($entity);

        $converter = new HtmlConverter;
        $converter->getConfig()->setOption('strip_tags', true);
        $converter->getEnvironment()->addConverter(new TableConverter);

        return response()->view('entities.pages.print.markdown', ['entity' => $entity, 'converter' => $converter, 'campaign' => $campaign])
            ->header('Content-Type', 'application/md')
            ->header('Content-disposition', 'attachment; filename="' . Str::slug($entity->name) . '.md"');
    }

    public function html(Campaign $campaign, Entity $entity)
    {
        $this->campaign($campaign)->authEntityView($entity);

        return view('entities.pages.print.print')
            ->with('campaign', $campaign)
            ->with('entity', $entity)
            ->with('model', ! $entity->entityType->isSpecial() ? $entity->child : null)
            ->with('name', $entity->entityType->pluralCode())
            ->with('printing', true);
    }
}
