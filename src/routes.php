<?php
/**
 * @global $router
 */

$router->group(['prefix' => config('uniteller.routesPrefix')], function ($router) {
    $router->post('callback', ['as' => 'uniteller-callback', 'uses' => 'UnitellerController@callback']);
    $router->get('success', ['as' => 'uniteller-success', 'uses' => 'UnitellerController@success']);
    $router->get('fail', ['as' => 'uniteller-fail', 'uses' => 'UnitellerController@fail']);
});
