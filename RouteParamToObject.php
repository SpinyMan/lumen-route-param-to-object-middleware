<?php

namespace App\Http\Middleware;

use Closure;
use Dingo\Api\Http\Request;
use Illuminate\Support\Arr;
use ReflectionMethod;

class RouteParamToObject
{
    public function handle(Request $request, Closure $next)
    {
        $route = $request->route();

        if (is_array($route)) {
            $params = Arr::get($route, 2);
            if ($params) {
                $uses = Arr::get($route, '1.uses');
                [$controller, $action] = explode('@', $uses);
                $reflectionMethod = new ReflectionMethod($controller, $action);
                $actionParams = $reflectionMethod->getParameters();
                foreach ($actionParams as $actionParam) {
                    $name  = $actionParam->getName();
                    if (!isset($params[$name])) {
                        continue;
                    }

                    $class = $actionParam->getClass();
                    if (!$class) {
                        continue;
                    }

                    $model = $class->name;
                    if (!class_exists($model)) {
                        continue;
                    }

                    Arr::set($route, "2.{$name}", $model::findOrFail($params[$name]));
                }

                app('request')->setRouteResolver(function () use ($route) {
                    return $route;
                });
            }
        }

        return $next($request);
    }
}
