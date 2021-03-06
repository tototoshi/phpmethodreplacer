<?php
namespace MethodReplacer;

class MethodReplaceableClassTest extends \PHPUnit_Framework_TestCase
{

    public function test__construct()
    {
        $class_name = 'MethodReplacer\A';
        $actual = new MethodReplaceableClass($class_name);
        $this->assertNotNull($actual);
    }

    public function test__construct_withInvalidArg()
    {
        $class_name = 'TestClass';
        $this->setExpectedException('\MethodReplacer\Exception\ClassNotFoundException');
        new MethodReplaceableClass($class_name);
    }

    public function testAddMethodAndGetMethod()
    {
        $method_name = 'a';
        $f = function () { return 1; };
        $class = new MethodReplaceableClass('MethodReplacer\A');
        $actual = $class->addMethod($method_name, $f);
        $expected = $f;
        $this->assertEquals($expected, $actual->getMethod('a'));
    }

    public function testAddMethod_withInvalidArg()
    {
        $invalid_method_name = 'b';
        $f = function () { return 1; };
        $class = new MethodReplaceableClass('MethodReplacer\A');
        $this->setExpectedException('MethodReplacer\Exception\MethodNotFoundException');
        $class->addMethod($invalid_method_name, $f);
    }

    public function testRemoveMethod()
    {
        $method_name = 'a';
        $f = function () { return 1; };
        $class = new MethodReplaceableClass('MethodReplacer\A');
        $actual = $class->addMethod($method_name, $f)->removeMethod('a');
        $this->assertNull($actual->getMethod('a'));
    }

}
