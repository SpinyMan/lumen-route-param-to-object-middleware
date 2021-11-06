<?php

use Laravel\Lumen\Routing\Router;
use Laravel\Lumen\Testing\TestCase;

class MiddlewareTest extends TestCase
{
    public function createApplication()
    {
        return require_once __DIR__ . '/bootstrap/app.php';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->router->group(
            [
                'middleware' => 'param2object',
            ],
            static function (Router $router) {
                $router->get(
                    '/{namer}',
                    'SpinyMan\LumenRouteParamToObject\Tests\Controllers\NamerController@index'
                );
            }
        );
    }

    public function testNamer(): void
    {
        $result = $this->get('/andrew');
        $result->assertResponseOk();
        $this->assertSame(
            'Andrew',
            $result->response->getContent()
        );
    }
}
