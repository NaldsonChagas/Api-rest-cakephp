<?php
/**of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::defaultRouteClass(DashedRoute::class);


Router::scope('/', ['prefix' => 'api'], function($routes) {
    $routes->setExtensions(['json']);

    $routes->resources('Users', [
        'map' => [
            'login' => [
                'action' => 'login',
                'method' => 'POST'
            ]
        ]
    ]);
    
    $routes->fallbacks('InflectedRoute');
});