<?php

namespace App\Http\Controllers\Entity;

use App\Facades\EntityLogger;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateEntityEntry;
use App\Models\Campaign;
use App\Models\Entity;

class EntryController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity);

        return view('entities.pages.entry.edit')
            ->with('campaign', $campaign)
            ->with('entity', $entity);
    }

    /**
     * Update the entity's entry
     */
    public function update(UpdateEntityEntry $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity);

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        $fields = $request->only('entry');
        $entity->update($fields);

        if ($entity->wasChanged()) {
            EntityLogger::entity($entity);
            $entity->touch();
        }

        $return = redirect()->to($entity->url());
        if (auth()->user()->editor === 'tiptap') {
            $count = session()->get('tiptap_survey_count', 0);
            $count++;
            session()->put('tiptap_survey_count', $count);
            if ($count % 5 === 0) {
                session()->flash('tiptap_survey', true);
            }
        }

        return $return;
    }
}
