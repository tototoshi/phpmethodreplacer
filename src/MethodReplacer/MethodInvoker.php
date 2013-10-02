<?php
namespace MethodReplacer;

class MethodInvoker {

    public static function invoke()
    {
        $args = func_get_args();

        if (count($args) < 2) {
            throw new MethodInvocationException('Class and method are not specified.');
        }

        $class_name = $args[0];
        $method_name = $args[1];
        $method_args = array_slice($args, 2);

        $class_manager = ClassManager::getInstance();

        $managed_class = $class_manager->getManagedClassOrNewOne($class_name);

        $fake_method = $managed_class->getMethod($method_name);

        if (!$fake_method) {
            throw new MethodInvocationException('Method not found!');
        }

        return call_user_func_array($fake_method, $method_args);

    }

}