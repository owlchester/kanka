<?php

namespace App\Http\Controllers\Entity;

use App\Exceptions\TranslatableException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEntityAsset;
use App\Http\Requests\StoreEntityAssets;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityAsset;
use App\Services\EntityFileService;
use App\Traits\GuestAuthTrait;
use Exception;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class AssetController extends Controller
{
    use GuestAuthTrait;

    public function index(Campaign $campaign, Entity $entity)
    {
        $this->authEntityView($entity);
        if (!$campaign->enabled('assets')) {
            return redirect()->route('entities.show', [$campaign, $entity])->with(
                'error_raw',
                __('campaigns.settings.errors.module-disabled', [
                    'fix' => '<a href="' . route('campaign.modules', [$campaign, '#assets']) . '">' . __('crud.fix-this-issue') . '</a>',
                ])
            );
        }

        $assets = $entity->assets()->with('image')->get();

        return view('entities.pages.assets.index', compact(
            'campaign',
            'entity',
            'assets'
        ));
    }

    public function show(Campaign $campaign, Entity $entity, EntityAsset $entityAsset)
    {
        return redirect()->route('entities.entity_assets.index', [$campaign, $entity]);
    }

    public function create(Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity->child);

        $typeID = (int) request()->get('type');
        if ($typeID == EntityAsset::TYPE_FILE) {
            return $this->createFile($campaign, $entity);
        } elseif ($typeID == EntityAsset::TYPE_LINK) {
            return $this->createLink($campaign, $entity);
        } elseif ($typeID == EntityAsset::TYPE_ALIAS) {
            return $this->createAlias($campaign, $entity);
        }
        abort(404);
    }

    public function store(StoreEntityAssets $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity->child);
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        $data = [];
        $type = '';
        $typeId = null;
        if (request()->get('type_id') == EntityAsset::TYPE_FILE) {
            return $this->storeFile($request, $campaign, $entity);
        } elseif (request()->get('type_id') == EntityAsset::TYPE_LINK) {
            $data = $request->only(['name', 'position', 'visibility_id', 'metadata']);
            $type = 'links';
            $typeId = EntityAsset::TYPE_LINK;
        } elseif (request()->get('type_id') == EntityAsset::TYPE_ALIAS) {
            $typeId = EntityAsset::TYPE_ALIAS;
            $data = $request->only(['name', 'visibility_id', 'is_pinned']);
            $type = 'aliases';
        }
        $data['entity_id'] = $entity->id;
        $data['type_id'] = $typeId;

        $asset = EntityAsset::create($data);

        return redirect()
            ->route('entities.entity_assets.index', [$campaign, $entity])
            ->with('success', __(
                'entities/' . $type . '.create.success',
                ['name' => $asset->name, 'entity' => $entity->name]
            ));
    }

    protected function storeFile(StoreEntityAssets $request, Campaign $campaign, Entity $entity)
    {
        /** @var EntityFileService $service */
        $service = app()->make(EntityFileService::class);

        try {
            $files = $service
                ->entity($entity)
                ->campaign($campaign)
                ->upload($request)
                ->files();

            return redirect()
                ->route('entities.entity_assets.index', [$campaign, $entity])
                ->with('success', trans_choice('entities/files.create.success_plural', count($files), ['count' => count($files), 'name' => $files['0']->name]));

        } catch (TranslatableException $e) {
            return redirect()
                ->route('entities.entity_assets.index', [$campaign, $entity])
                ->with('error', $e->getTranslatedMessage());
        } catch (Exception $e) {
            return redirect()
                ->route('entities.entity_assets.index', [$campaign, $entity])
                ->with('error', $e->getMessage());
        }
    }

    public function edit(Campaign $campaign, Entity $entity, EntityAsset $entityAsset)
    {
        $this->authorize('update', $entity->child);

        $file = 'files';
        if ($entityAsset->isLink()) {
            $file = 'links';
        } elseif ($entityAsset->isAlias()) {
            $file = 'aliases';
        }

        return view('entities.pages.' . $file . '.update')
            ->with('campaign', $campaign)
            ->with('entity', $entity)
            ->with('entityAsset', $entityAsset);
    }

    public function update(StoreEntityAsset $request, Campaign $campaign, Entity $entity, EntityAsset $entityAsset)
    {
        $this->authorize('update', $entity->child);
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        $type = 'files';
        if ($entityAsset->isAlias()) {
            $data = $request->only(['name', 'visibility_id', 'is_pinned']);
            $entityAsset->update($data);
            $type = 'aliases';
        } elseif ($entityAsset->isLink()) {
            $data = $request->only(['name', 'metadata.url', 'metadata.icon', 'visibility_id']);
            $entityAsset->update($data);
            $type = 'links';
        } elseif ($entityAsset->isFile()) {
            $data = $request->only(['name', 'visibility_id', 'is_pinned']);
            $entityAsset->update($data);
        }

        if (request()->ajax()) {
            return response()->json([
                'success' => true
            ]);
        }
        return redirect()
            ->route('entities.entity_assets.index', [$campaign, $entity])
            ->with('success', __('entities/' . $type . '.update.success', ['name' => $entityAsset->name, 'entity' => $entity->name]));
    }


    public function destroy(Campaign $campaign, Entity $entity, EntityAsset $entityAsset)
    {
        $this->authorize('update', $entity->child);

        if (!$entityAsset->delete()) {
            abort(500);
        }
        $type = 'files';
        if ($entityAsset->isLink()) {
            $type = 'links';
        } elseif ($entityAsset->isAlias()) {
            $type = 'aliases';
        }

        if (request()->ajax()) {
            return response()->json([
                'success' => true
            ]);
        }
        return redirect()
            ->route('entities.entity_assets.index', [$campaign, $entity])
            ->with('success', __('entities/' . $type . '.destroy.success', ['name' => $entityAsset->name, 'entity' => $entity->name]));
    }

    /**
     * Create a new file
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    protected function createFile(Campaign $campaign, Entity $entity)
    {
        $max = $campaign->maxEntityFiles();
        if ($entity->assets()->file()->count() >= $max) {
            return view('entities.pages.files.max')
                ->with('campaign', $campaign)
                ->with('max', $max);
        }

        return view('entities.pages.files.create')
            ->with('campaign', $campaign)
            ->with('entity', $entity);
    }

    /**
     * Create a new link
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    protected function createLink(Campaign $campaign, Entity $entity)
    {
        if (!$campaign->boosted()) {
            return view('entities.pages.links.unboosted')
                ->with('campaign', $campaign);
        }

        return view('entities.pages.links.create', compact(
            'campaign',
            'entity'
        ));
    }

    /**
     * Create a new alias
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    protected function createAlias(Campaign $campaign, Entity $entity)
    {
        if (!$campaign->boosted()) {
            return view('entities.pages.aliases.unboosted')
                ->with('campaign', $campaign);
        }

        return view('entities.pages.aliases.create', compact(
            'campaign',
            'entity'
        ));
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function go(Campaign $campaign, Entity $entity, EntityAsset $entityAsset)
    {
        $this->authEntityView($entity);

        if ($entityAsset->entity_id !== $entity->id || !$entityAsset->isLink()) {
            abort(404);
        }

        // If the link goes to the same domain, just go.
        $url = $entityAsset->metadata['url'];
        if (Str::startsWith($url, config('app.url')) && !Str::contains($url, 'entity_links/')) {
            return redirect()->to($url);
        }

        // If the domain is trusted for the user, we don't need the confirmation, just go
        $trusted = Cookie::get('kanka_trusted_domains');
        if ($trusted) {
            $domains = explode('|', $trusted);
            if (in_array($entityAsset->urlDomain(), $domains)) {
                return redirect()->to($url);
            }
        }

        return view('entities.pages.links.go', compact(
            'campaign',
            'entity',
            'entityAsset'
        ));
    }
}
