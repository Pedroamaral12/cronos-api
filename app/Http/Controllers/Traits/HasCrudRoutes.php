<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Support\Facades\Route;

trait HasCrudRoutes
{

    /*     'index' => 'view_model',      // GET /model
     *     'select' => 'select_model',  // GET /model/select  
     *     'show' => 'view_model',       // GET /model/{id}
     *     'store' => 'create_model',    // POST /model
     *     'update' => 'edit_model',     // PUT /model/{id}
     *     'destroy' => 'delete_model',  // DELETE /model/{id}
     *     'restore' => 'restore_model', // POST /model/restore/{id}
     */
    public static function registerCrudRoutes(string $prefix, string $controller, array $options = [])
    {
        $middleware = $options['middleware'] ?? [];
        $except = $options['except'] ?? [];
        $abilities = $options['abilities'] ?? [];

        $routes = [
            ['GET', '/', 'index'],
            ['GET', '/select', 'getSelect'],
            ['GET', '/{id}', 'show'],
            ['POST', '/', 'store'],
            ['PUT', '/{id}', 'update'],
            ['DELETE', '/{id}', 'destroy'],
            ['POST', '/restore/{id}', 'restore']
        ];

        Route::prefix($prefix)
            ->middleware($middleware)
            ->controller($controller)
            ->group(function () use ($routes, $except, $abilities, $prefix) {
                foreach ($routes as [$method, $uri, $action]) {
                    if (in_array($action, $except)) {
                        continue;
                    }

                    $route = Route::$method($uri, $action);

                    if (isset($abilities[$action])) {
                        $route->middleware(['ability:' . $abilities[$action]]);
                    } elseif (isset($abilities['default'])) {
                        $route->middleware(['ability:' . str_replace('{action}', $action, $abilities['default'])]);
                    }
                }
            });
    }

    public static function crudResource(string $prefix, string $controller, array $options = [])
    {
        self::registerCrudRoutes($prefix, $controller, $options);
    }
}
