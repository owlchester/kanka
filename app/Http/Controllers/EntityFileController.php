<?php

namespace App\Http\Controllers;

use App\Exceptions\EntityFileException;
use App\Facades\CampaignLocalization;
use App\Http\Requests\StoreEntityAsset;
use App\Http\Requests\UpdateEntityFile;
use App\Models\EntityFile;
use App\Services\EntityFileService;
use App\Models\Entity;
use Exception;

class EntityFileController extends Controller
{
    /**
     * @var string
     */
    protected $model = \App\Models\EntityFile::class;

    /**
     * @var EntityFileService
     */
    protected $entityFile;

    /**
     * EntityFileController constructor.
     * @param EntityFileService $entityFileService
     */
    public function __construct(EntityFileService $entityFileService)
    {
        $this->entityFile = $entityFileService;
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(Entity $entity)
    {
        return redirect()
            ->route('entities.entity_assets.index', $entity);
    }

    /**
     * @param Entity $entity
     * @param EntityFile $entityFile
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(Entity $entity, EntityFile $entityFile)
    {
        return redirect()
            ->route('entities.entity_assets.index', $entity);
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Entity $entity)
    {
        $this->authorize('update', $entity->child);

        $campaign = CampaignLocalization::getCampaign();
        $max = $campaign->maxEntityFiles();
        if ($entity->files->count() >= $max) {
            return view('entities.pages.files.max')
                ->with('campaign', $campaign)
                ->with('max', $max);
        }

        return view('entities.pages.files.create')
            ->with('entity', $entity);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEntityAsset $request, Entity $entity)
    {
        $this->authorize('update', $entity->child);
        $campaign = CampaignLocalization::getCampaign();

        try {
            $file = $this->entityFile
                ->entity($entity)
                ->campaign($campaign)
                ->upload($request);

            $entity->load('files');

            return redirect()
                ->route('entities.entity_assets.index', $entity)
                ->with('success', __('entities/files.create.success', ['file' => $file->name]));
        } catch (EntityFileException $e) {
            return redirect()
                ->route('entities.entity_assets.index', $entity)
                ->with('error', __('crud.files.errors.' . $e->getMessage(), ['max' => $campaign->maxEntityFiles()]));
        } catch (Exception $e) {
            return redirect()
                ->route('entities.entity_assets.index', $entity)
                ->with('error', $e->getMessage());
        }
    }

    /**
     * @param Entity $entity
     * @param EntityFile $entityFile
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Entity $entity, EntityFile $entityFile)
    {
        $this->authorize('update', $entity->child);

        return view('entities.pages.files.update')
            ->with('entity', $entity)
            ->with('entityFile', $entityFile);
    }

    /**
     */
    public function update(UpdateEntityFile $request, Entity $entity, EntityFile $entityFile)
    {
        $this->authorize('update', $entity->child);

        $entityFile->update($request->only('name', 'visibility_id'));

        return redirect()
            ->route('entities.entity_assets.index', $entity)
            ->with('success', __('entities/files.update.success', ['file' => $entityFile->name]));
    }

    /**
     * Remove the EntityFile
     */
    public function destroy(Entity $entity, EntityFile $entityFile)
    {
        $this->authorize('update', $entity->child);

        $entityFile->delete();

        return redirect()
            ->route('entities.entity_assets.index', $entity)
            ->with('success', __('entities/files.destroy.success', ['file' => $entityFile->name]));
    }
}
