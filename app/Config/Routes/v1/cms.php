<?php

/** @var \CodeIgniter\Router\RouteCollection $routes */

$routes->group('cms', ['namespace' => '\App\Controllers\Api\V1\Cms'], function ($routes) {

    // Auth & Admin Protected Group
    $routes->group('', ['filter' => ['jwtauth', 'roleauth:admin', 'throttle']], function ($routes) {
        // Cmspost Routes
        $routes->get('cmsposts', 'CmspostController::index');
        $routes->get('cmsposts/(:num)', 'CmspostController::show/$1');
        $routes->post('cmsposts', 'CmspostController::create');
        $routes->put('cmsposts/(:num)', 'CmspostController::update/$1');
        $routes->delete('cmsposts/(:num)', 'CmspostController::delete/$1');

        // Cmsposttype Routes
        $routes->get('cmsposttypes', 'CmsposttypeController::index');
        $routes->get('cmsposttypes/(:num)', 'CmsposttypeController::show/$1');
        $routes->post('cmsposttypes', 'CmsposttypeController::create');
        $routes->put('cmsposttypes/(:num)', 'CmsposttypeController::update/$1');
        $routes->delete('cmsposttypes/(:num)', 'CmsposttypeController::delete/$1');

        // Cmssection Routes
        $routes->get('cmssections', 'CmssectionController::index');
        $routes->get('cmssections/(:num)', 'CmssectionController::show/$1');
        $routes->post('cmssections', 'CmssectionController::create');
        $routes->put('cmssections/(:num)', 'CmssectionController::update/$1');
        $routes->delete('cmssections/(:num)', 'CmssectionController::delete/$1');

        // Resource routes will be injected here
    });
});
