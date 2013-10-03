<?php
namespace MethodReplacer;
use MethodReplacer\Exception\MethodInvocationException;

/**
 * Class MethodInvoker
 * @package MethodReplacer
 */
class MethodInvoker {

    /**
     * Invoke pseudo method that has been registered to ClassManager
     *
     * @param string $class_name
     * @param string $method_name
     * @return mixed
     * @throws Exception\MethodInvocationException
     */
    public static function invoke($class_name, $method_name)
    {
        $args = func_get_args();
        $method_args = array_slice($args, 2);

        $managed_class = ClassManager::getInstance()->getManagedClassOrNewOne($class_name);

        $fake_method = $managed_class->getMethod($method_name);

        if (!$fake_method) {
            throw new MethodInvocationException('Method not found!');
        }

        return call_user_func_array($fake_method, $method_args);
    }

}