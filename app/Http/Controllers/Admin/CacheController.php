<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CacheController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.cache.form');
    }

    /**
     * @param Request $request
     */
    public function destroy(Request $request)
    {
        $key = $request->get('key');
        if (Cache::has($key)) {
            Cache::forget($key);
            return redirect()->to('admin/cache')->withSuccess('Cache key \'' . $key . '\' forgotten.');
        } else {
            return redirect()->to('admin/cache')->withErrors('Cache key \'' . $key . '\' doesnt\'t exist.');
        }
    }

    public function view(Request $request)
    {
        $key = $request->get('key');
        $val = Cache::get($key);

        return view('admin.cache.form')->with('key', $key)->with('val', $val);
    }
}
