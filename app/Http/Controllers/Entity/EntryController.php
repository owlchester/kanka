<?php


namespace App\Http\Controllers\Entity;


use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateEntityEntry;
use App\Models\Entity;

class EntryController extends Controller
{
    public function edit(Entity $entity)
    {
        $this->authorize('update', $entity->child);

        return view('entities.pages.entry.edit')
            ->with('entity', $entity);

    }

    public function update(UpdateEntityEntry $request, Entity $entity)
    {
        $this->authorize('update', $entity->child);

        return redirect()->route($entity->url('show'));
    }
}
