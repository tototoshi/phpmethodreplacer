<?php
namespace MethodReplacer;

class ClassMethodReplacementGuard
{
    private $class_and_methods;

    public function __construct()
    {
    }

    public function __destruct()
    {
        foreach ($this->class_and_methods as $class_and_methods) {
            list ($class_name, $method_name) = $class_and_methods;
            ClassManager::getInstance()->deregister($class_name, $method_name);
        }
    }

    public function override($class_name, $method_name, $closure)
    {
        ClassManager::getInstance()->register($class_name, $method_name, $closure);
        $this->class_and_methods[] = array($class_name, $method_name);
    }

}


