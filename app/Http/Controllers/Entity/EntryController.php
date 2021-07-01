<?php


namespace App\Http\Controllers\Entity;


use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateEntityEntry;
use App\Models\Entity;

class EntryController extends Controller
{
    /**
     * @param Entity $entity
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Entity $entity)
    {
        $this->authorize('update', $entity->child);

        return view('entities.pages.entry.edit')
            ->with('entity', $entity);

    }

    /**
     * @param UpdateEntityEntry $request
     * @param Entity $entity
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateEntityEntry $request, Entity $entity)
    {
        $this->authorize('update', $entity->child);

        $fields = $request->only('entry');
        $entity->child->update($fields);

        return redirect()->to($entity->url('show'));
    }
}
