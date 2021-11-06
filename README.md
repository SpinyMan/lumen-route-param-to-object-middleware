# Lumen route param to object middleware
Lumen middleware to use Route parameters as objects (like Laravel does)

This is a route middleware.

Installation:

1. Register middleware in `./bootstrap/app.php`:
```
$app->routeMiddleware(
    [
        'param2object' => \App\Http\Middleware\RouteParamToObject::class,
    ]
);
```
2. Add it to any group route (ex.: RouteServiceProvider):
```
$this->router->group(
    [
        'middleware' => 'param2object',
    ],
    function () {
        // your code goes here
    }
);
```
