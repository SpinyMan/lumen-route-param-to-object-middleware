# Lumen route param to object middleware

Lumen middleware to use Route parameters as objects (like Laravel does)

This is a route middleware.

## Installation:
1. `composer require spinyman/lumen-route-param-to-object-middleware`
2. Register middleware in `./bootstrap/app.php`:
    ```php
    $app->routeMiddleware(
        [
            'param2object' => \SpinyMan\LumenRouteParamToObject\Middleware\RouteParamToObject::class,
        ]
    );
    ```
3. Add it to any group route (ex.: RouteServiceProvider):
    ```php
    $this->router->group(
        [
            'middleware' => 'param2object',
        ],
        static function (\Laravel\Lumen\Routing\Router $router) {
            // your code goes here
        }
    );
    ```

## Examples

### Eloquent:

```php
//router
$this->router->group(
    [
        'middleware' => 'param2object',
    ],
    static function (\Laravel\Lumen\Routing\Router $router) {
        $this->router->get(
            '/books/{book}',
            'BookController@show'
        );
    }
)
```

```php
class Book extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'books';
}
```

```php
//BookController
public function show(\Laravel\Lumen\Http\Request $request, Book $book)
{
    $bookId = $book->getKey();
    // your code goes here
}
```

### Simple class:

```php
//router
$this->router->group(
    [
        'middleware' => 'param2object',
    ],
    static function (\Laravel\Lumen\Routing\Router $router) {
        $this->router->get(
            '/namer/{namer}',
            'NamerController@run'
        );
    }
)
```

```php
// Namer class
class Namer
{
    private $name;
    
    public function __construct(string $name)
    {
        $this->name = $name;
    }
    
    public  function getName(): string
    {
        return ucfirst(
            strtolower($this->name)
        );
    }
} 
```

```php
//NamerController
public function run(\Laravel\Lumen\Http\Request $request, Namer $namer)
{
    return $namer->getName();
}
```
