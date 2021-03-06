<?php

namespace FunctionalPHP\NamedParameters;

function call_user_func_array_np($callback, array $arguments) {
    $isConstructor = is_array($callback) && ($callback[1] ?? false) === '__construct';

    $keys = array_keys($arguments);
    if($keys === array_keys($keys)) {
        // we have a non associative array, so fallback to the traditional method.
        if($isConstructor) {
            return new $callback[0](...$arguments);
        } else {
            return call_user_func_array($callback, $arguments);
        }
    }

    try {
        if($callback instanceof \Closure) {
            $rc = new \ReflectionFunction($callback);
        } else {
            $parts = is_array($callback) ? $callback : explode('::', $callback);

            switch(count($parts)) {
                case 1:
                    $rc = is_object($parts[0]) ?
                        new \ReflectionMethod($parts[0], '__invoke') :
                        new \ReflectionFunction($parts[0]);
                    break;
                case 2:
                    $rc = new \ReflectionMethod($parts[0], $parts[1]);
                    $isConstructor = $parts[1] === '__construct';
                    break;
                default:
                    throw new \LogicException("Unable to determine callback type.");
            }
        }
    } catch(\ReflectionException $e) {
        throw new \LogicException("There was an error creating the reflexion.", 0, $e);
    }

    $parameters = $rc->getParameters();
    $positionedArguments = array_map(function (\ReflectionParameter $p) use ($rc, $arguments) {
        if (array_key_exists($p->name, $arguments)) {
            return $arguments[$p->name];
        }
        if ($p->isDefaultValueAvailable()) {
            return $p->getDefaultValue();
        }

        throw new \InvalidArgumentException(sprintf("Missing value for '%s' on '%s'.", $p->name, $rc->getName()));
    }, $parameters);

    return $isConstructor ?
        new $parts[0](...$positionedArguments) :
        forward_static_call_array($callback, $positionedArguments);
}

function construct($class, array $arguments) {
    return call_user_func_array_np([$class, '__construct'], $arguments);
}
