<?php

namespace App\Http\Controllers\Entity\Attributes;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateEntityAttribute;
use App\Models\Attribute;
use App\Models\Campaign;
use App\Models\Entity;
use Stevebauman\Purify\Facades\Purify;

class LiveController extends Controller
{
    public function index(Campaign $campaign, Entity $entity, Attribute $attribute)
    {
        $this->authorize('update', $entity);

        return view('entities.pages.attributes.live.edit')
            ->with('campaign', $campaign)
            ->with('entity', $entity)
            ->with('attribute', $attribute)
            ->with('uid', request()->get('uid'));
    }

    public function save(UpdateEntityAttribute $request, Campaign $campaign, Entity $entity, Attribute $attribute)
    {
        $this->authorize('update', $entity);

        if ($attribute->entity_id !== $entity->id) {
            abort(404);
        }

        $attribute->update([
            'value' => Purify::clean($request->get('value')),
        ]);
        // Track that the entity was updated
        $entity->touch();

        if (! request()->ajax()) {
            return redirect()->route('entities.attributes', [$campaign, $entity]);
        }

        $attributeValue = null;
        $result = $attribute->mappedValue();
        $attributeValue = $result;
        if ($attribute->isText()) {
            $result = nl2br($result);
            $attributeValue = $result;
        } elseif ($attribute->isCheckbox()) {
            $result = '<i ' .
                'class="fa-solid fa-' . ($attribute->value ? 'check' : 'times') . '" ' .
                'aria-hidden="true" ' .
                'aria-label="' . ($attribute->value ? 'checked' : 'unchecked') . '"></i>';
            $attributeValue = $attribute->value ? 'true' : 'false';
        }

        return response()->json([
            'value' => $result,
            'attribute' => $attributeValue,
            'id' => $attribute->id,
            'uid' => $request->get('uid'),
            'success' => __('entities/attributes.live.success', ['attribute' => $attribute->name()]),
        ]);
    }
}
