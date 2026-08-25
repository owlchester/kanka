<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

it('keeps API documentation links pointing to existing pages', function () {
    $documentationPath = base_path('resources/api-docs/1.0');
    $documentPaths = collect(File::allFiles($documentationPath))
        ->filter(fn ($file) => $file->getExtension() === 'md')
        ->map(fn ($file) => str_replace(
            ['\\', '.md'],
            ['/', ''],
            str_replace($documentationPath . DIRECTORY_SEPARATOR, '', $file->getPathname())
        ))
        ->all();

    $missing = [];

    foreach (File::allFiles($documentationPath) as $file) {
        if ($file->getExtension() !== 'md') {
            continue;
        }

        preg_match_all(
            '/\]\(\/api-docs\/\{\{version\}\}\/([^)#]+)(?:#[^)]*)?\)/',
            $file->getContents(),
            $matches
        );

        foreach ($matches[1] as $path) {
            $path = rtrim($path, '/');
            if (! in_array($path, $documentPaths, true)) {
                $missing[] = $file->getRelativePathname() . ': ' . $path;
            }
        }
    }

    expect($missing)->toBeEmpty();
});

it('keeps documented API route contracts registered', function () {
    $contracts = [
        ['GET', 'api/1.0/profile'],
        ['GET', 'api/1.0/campaigns'],
        ['POST', 'api/1.0/campaigns'],
        ['GET', 'api/1.0/campaigns/1/characters'],
        ['GET', 'api/1.0/campaigns/1/entities'],
        ['GET', 'api/1.0/campaigns/1/category_statuses'],
        ['POST', 'api/1.0/campaigns/1/applications/2/reject'],
        ['GET', 'api/1.0/campaigns/1/recovery'],
        ['POST', 'api/1.0/campaigns/1/recover'],
        ['GET', 'api/1.0/campaigns/1/recovery/posts'],
        ['POST', 'api/1.0/campaigns/1/recover/posts'],
        ['GET', 'api/1.0/campaigns/1/maps/2/map_layers'],
        ['PATCH', 'api/1.0/campaigns/1/maps/2/map_layers/3'],
        ['GET', 'api/1.0/campaigns/1/maps/2/map_groups'],
        ['DELETE', 'api/1.0/campaigns/1/maps/2/map_groups/3'],
        ['DELETE', 'api/1.0/campaigns/1/maps/2/map_markers/3'],
        ['DELETE', 'api/1.0/campaigns/1/organisations/2/organisation_members/3'],
        ['POST', 'api/1.0/campaigns/1/entities/2/image'],
        ['POST', 'api/1.0/campaigns/1/entities/templates/2/switch'],
        ['GET', 'api/1.0/filters'],
        ['GET', 'api/1.0/entity-types'],
    ];

    foreach ($contracts as [$method, $uri]) {
        $route = null;
        try {
            $route = Route::getRoutes()->match(Request::create('/' . $uri, $method));
        } catch (Throwable) {
            // Leave the route null so the assertion reports the missing contract.
        }

        expect($route)->not->toBeNull("Missing {$method} {$uri}");
    }
});
