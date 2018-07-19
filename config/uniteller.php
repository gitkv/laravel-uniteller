<?php
return [
    'shopId'       => env('UNITELLER_SHOP_ID'),
    'login'        => env('UNITELLER_LOGIN'),
    'password'     => env('UNITELLER_PASSWORD'),
    'baseUrl'      => "https://wpay.uniteller.ru",

    /**
     * If 'useRoutes' is set to true, the package defines three new routes:
     *
     *    Method | URI                      | Name
     *    -------|--------------------------|------------------
     *    POST   | {routesPrefix}/callback  | uniteller-callback
     *    GET    | {routesPrefix}/success   | uniteller-success
     *    GET    | {routesPrefix}/fail      | uniteller-fail
     */
    'useRoutes'    => true,

    /**
     * Default prefix
     */
    'routesPrefix' => '/uniteller',

    /**
     * Success redirect, default [APP_URL]/uniteller/success
     */
    'successUrl'   => env('APP_URL') . '/uniteller/success',

    /**
     * Failure redirect, default [APP_URL]/uniteller/fail
     */
    'failureUrl'   => env('APP_URL') . '/uniteller/fail',
];
