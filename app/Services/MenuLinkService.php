<?php


namespace App\Services;


use App\Http\Requests\ReorderMenuLinks;
use App\Models\MenuLink;

class MenuLinkService
{
    /**
     * @param array $data
     * @return bool
     */
    public function reorder(ReorderMenuLinks $request): bool
    {
        $ids = $request->get('menu_link');
        if (empty($ids)) {
            return false;
        }

        $position = 1;
        foreach ($ids as $id) {
            /** @var MenuLink $link */
            $link = MenuLink::where('id', $id)->first();
            if (empty($link)) {
                continue;
            }

            $link->position = $position;
            $link->savingObserver = false;
            $link->save();
            $position++;
        }

        return true;
    }
}
