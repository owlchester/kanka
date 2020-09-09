<?php


namespace App\Http\Controllers\Search;


use App\Http\Controllers\Controller;
use App\Models\Entity;
use Illuminate\Http\Request;

class AttributeSearchController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
        $this->middleware('campaign.member');
    }

    public function index(Request $request, Entity $entity)
    {
        $attributes = $entity->attributes()
            ->where('name', 'LIKE', '%' . $request->get('q') . '%')
            //->whereNotIn('type', ['section'])
            ->get();
        $data = [];
        foreach ($attributes as $attribute) {
            $data[] = [
                'id' => $attribute->id,
                'name' => $attribute->name,
                'value' => $attribute->value
            ];
        }
        return response()->json(
            $data
        );
    }


}
