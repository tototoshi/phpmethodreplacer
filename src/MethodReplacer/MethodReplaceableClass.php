<?php
namespace MethodReplacer;

class MethodReplaceableClass {

    private $class_name;

    private $methods = array();

    const PREFIX_ORIGINAL_METHOD = '__';

    public function __construct($class_name)
    {
        $this->class_name = $class_name;
    }

    private function getFakeCode($class_name, $method_name)
    {
        return "
            return call_user_func_array(
                array('MethodReplacer\\MethodInvoker', 'invoke'),
                array_merge(array('{$class_name}', '{$method_name}'), func_get_args())
            );"
        ;
    }

    private function getStashedMethodName($method_name) {
        return self::PREFIX_ORIGINAL_METHOD . $method_name;
    }

    private function stashedMethodExists($method_name)
    {
        return method_exists($this->class_name, $this->getStashedMethodName($method_name));
    }

    public function addMethod($method_name, $func) {
        $this->methods[$method_name] = $func;

        /* 元のメソッドを __ Prefix 付きで退避させる */
        if (!$this->stashedMethodExists($method_name)) {
            runkit_method_rename($this->class_name, $method_name, $this->getStashedMethodName($method_name));
        } else {
            runkit_method_remove($this->class_name, $method_name);
        }

        $code = $this->getFakeCode($this->class_name, $method_name);
        runkit_method_add($this->class_name, $method_name, '', $code, RUNKIT_ACC_STATIC);
        return $this;
    }

    public function getMethod($method_name)
    {
        return $this->methods[$method_name];
    }

    public function removeMethod($method_name)
    {
        if ($this->stashedMethodExists($method_name)) {
            runkit_method_remove($this->class_name, $method_name);
            runkit_method_rename($this->class_name, $this->getStashedMethodName($method_name), $method_name);
        }
        unset($this->methods[$method_name]);

        return $this;
    }

}