<?php

namespace Ghostwalker\Service;

use ReflectionException;

class UtilService
{
    /**
     * @param string $methodName
     * @param string $className
     * @return void
     * @throws ReflectionException
     */
    public function checkOnMethod(string $methodName, string $className): void
    {
        $reflectionClass = new \ReflectionClass($className);
        foreach ($reflectionClass->getMethods() as $method) {
            if ($method->name === $methodName) {
                return;
            }
        }

        throw new \RuntimeException('Method '.$methodName.' not found, please create it in class '.$className);
    }
}
