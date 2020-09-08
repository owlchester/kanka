<?php


namespace App\Services;


class BreadcrumbService
{
    /**
     * @param string $name
     * @return string
     */
    public function index(string $name): string
    {
        // If the user activated nested views by default, go back to it.
        $entityIndexRoute = route($name . '.index');
        if (auth()->check() && auth()->user()->defaultNested) {
            if (\Illuminate\Support\Facades\Route::has($name . '.tree')) {
                $entityIndexRoute = route($name . '.tree');
            }
        }
        return $entityIndexRoute;
    }
}
