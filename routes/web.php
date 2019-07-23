<?php
 
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
 
$router->get('/', function () use ($router) {
return $router->app->version();
});
 
$router->post(
'auth/login',
[
'uses' => 'AuthController@authenticate'
]
);
 
$router->group(['middleware' => 'jwt.auth'],function() use ($router) {
    $router->get('users', function() {
        $users = \App\User::all();
        return response()->json($users);
    });
}
);
 
$router->group(['middleware' => 'jwt.auth'],function() use ($router) {
    $router->get('shorturl', function() {
    $shorturl = \App\Url::all();
    return response()->json($shorturl);
});
}
);
 
$router->group(['prefix' => 'api'], function () use ($router) {

    //$router->get('/shorturl', 'UrlController@index');
    $router->get('/{redirect}', 'UrlController@redirect');
    $router->get('/shorturl/{id}', 'UrlController@show');
    $router->post('/shorturl', 'UrlController@create');
    $router->put('/shorturl/{id}', 'UrlController@update');
    $router->delete('/shorturl/{id}', 'UrlController@delete');
 
});
