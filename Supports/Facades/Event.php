<?php

namespace Supports\Facades;

use App\Providers\EventServiceProvider;
use stdClass;
use Supports\Facades\Interfaces\ShouldQueue;
use ReflectionMethod;

class Event extends EventServiceProvider
{
    public static function dispatch($instanceEvent)
    {
        $classEvent = get_class($instanceEvent);
        if (array_key_exists($classEvent, self::LISTENER_MAPPING)) {
            $listeners = self::LISTENER_MAPPING[$classEvent];
            foreach ($listeners as $listener) {
                $objectListener = new $listener();
                if ($objectListener instanceof ShouldQueue) {
                    $listener::dispatchNow();
                } else {
                    $paramsToRun = [];
                    $reflectionMethod = new ReflectionMethod($listener, 'handle');
                    $paramsHandle = $reflectionMethod->getParameters();
                    foreach ($paramsHandle as $key => $param) {
                        if ($param->getType() !== null && !$param->getType()->isBuiltin()) {
                            if ($param->getType()->getName() === get_class($instanceEvent)) {
                                $paramsToRun[$key] = $instanceEvent;
                            } else {
                                $paramsToRun[$key] = app()->make($param->getType()->getName());
                            }
                        }
                    }
                    $objectListener->handle(...$paramsToRun);
                }
            }
        }
    }
}
