<?php

namespace SpinyMan\LumenRouteParamToObject\Middleware;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
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
                $actionParams     = $reflectionMethod->getParameters();
                foreach ($actionParams as $actionParam) {
                    $name = $actionParam->getName();
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

                    if ($model instanceof Model) {
                        $object = $model::query()
                            ->findOrFail($params[$name]);
                    } else {
                        $object = new $model($params[$name]);
                    }
                    Arr::set($route, "2.{$name}", $object);
                }

                $request->setRouteResolver(
                    function () use ($route) {
                        return $route;
                    }
                );
            }
        }

        return $next($request);
    }
}
