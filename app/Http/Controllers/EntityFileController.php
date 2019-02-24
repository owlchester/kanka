<?php

namespace App\Http\Controllers;

use App\Exceptions\EntityFileException;
use App\Http\Requests\RenameEntityFile;
use App\Http\Requests\StoreEntityFile;
use App\Models\EntityFile;
use App\Services\EntityFileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Entity;
use Response;

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
     * @return \Illuminate\Http\Response
     */
    public function index(Entity $entity)
    {
        $this->authorize('update', $entity->child);

        $enabled = $entity->files->count() < config('entities.max_entity_files');
        return view('cruds.files.index', compact(
            'entity', 'enabled'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEntityFile $request, Entity $entity)
    {
        $this->authorize('update', $entity->child);

        try {
            $this->entityFile
                ->entity($entity)
                ->upload();

            $entity->load('files');


            // Send back the new list of files to the view
            $html = view('cruds.files.files', compact('entity'))->render();
            return response()->json([
                'success' => true,
                'html' => $html,
                'enabled' => $entity->files->count() < config('entities.max_entity_files')
            ]);
        } catch (EntityFileException $e) {
            return response()->json([
                'success' => false,
                'error' => __('crud.files.errors.' . $e->getMessage(), ['max' => config('entities.max_entity_files')])
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @param Entity $entity
     * @param EntityFile $entityFile
     * @throws \RenameEntityFile\Auth\Access\AuthorizationException
     */
    public function update(RenameEntityFile $request, Entity $entity, EntityFile $entityFile)
    {
        $this->authorize('update', $entity->child);

        $entityFile->name = $request->post('name');
        $entityFile->save();

        return response()->json(['success' => true]);
    }

    /**
     * Remove the EntityFile
     *
     * @param Entity $entity
     * @param EntityFile $entityFile
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Entity $entity, EntityFile $entityFile)
    {
        $this->authorize('update', $entity->child);

        $entityFile->delete();

        return response()->json([
            'success' => true,
            'enabled' => $entity->files->count() < config('entities.max_entity_files')
        ]);
    }
}
