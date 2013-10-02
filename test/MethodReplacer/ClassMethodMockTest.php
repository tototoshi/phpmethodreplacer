<?php
namespace MethodReplacer;


class ClassMethodMockTest extends \PHPUnit_Framework_TestCase
{

    public function expectDefaultBehavior()
    {
        $this->assertEquals(1, A::a());
        $this->assertEquals(2, B::b());
    }

    public function expectOverridedBehavior()
    {
        $mock = new ClassMethodReplacementGuard();
        $mock->override('MethodReplacer\A', 'a', function() {
            return 3;
        });
        $mock->override('MethodReplacer\B', 'b', function() {
            return 4;
        });
        $this->assertEquals(3, A::a());
        $this->assertEquals(4, B::b());
        $this->assertEquals(3, C::bar());
    }

    public function overrideTwice()
    {
        $mock = new ClassMethodReplacementGuard();
        $mock->override('MethodReplacer\A', 'a', function() {
            return 3;
        });
        $this->assertEquals(3, A::a());
        $mock->override('MethodReplacer\A', 'a', function() {
            return 4;
        });
        $this->assertEquals(4, A::a());
    }

    public function test_overrideOnlyInMethodScope()
    {
        $this->expectDefaultBehavior();
        $this->expectOverridedBehavior();
        $this->expectDefaultBehavior();
    }

    public function test_canOverride()
    {
        $mock = new ClassMethodReplacementGuard();
        $mock->override('MethodReplacer\A', 'a', function() {
            return 3;
        });
        $this->assertEquals(3, A::a());
    }

    public function test_canOverrideMethodWithOneArg()
    {
        $this->assertEquals(1, A::withOneArg(1));
        $mock = new ClassMethodReplacementGuard();
        $mock->override('MethodReplacer\A', 'withOneArg', function($arg) {
            return $arg * 2;
        });
        $this->assertEquals(2, A::withOneArg(1));
    }

    public function test_canOverrideMethodWithMultiArgs()
    {
        $this->assertEquals(0, A::withMultiArgs(1, 2));
        $mock = new ClassMethodReplacementGuard();
        $mock->override('MethodReplacer\A', 'withMultiArgs', function($arg1, $arg2) {
            return $arg1 + $arg2;
        });
        $this->assertEquals(3, A::withMultiArgs(1, 2));
    }

    public function test_canOverrideMultiMethods()
    {
        $this->assertEquals(1, A::a());
        $this->assertEquals(2, A::a2());
        $mock = new ClassMethodReplacementGuard();
        $mock->override('MethodReplacer\A', 'a', function() {
            return 'a';
        });
        $mock->override('MethodReplacer\A', 'a2', function() {
            return 'a2';
        });
        $this->assertEquals('a', A::a());
        $this->assertEquals('a2', A::a2());
    }

    public function test_canOverrideTwice()
    {
        $this->overrideTwice();
        $this->expectDefaultBehavior();
    }

    public function test_canCallOverridedMethodMultipleTimes()
    {
        $mock = new ClassMethodReplacementGuard();
        $mock->override('MethodReplacer\A', 'a', function() {
            return 3;
        });
        $this->assertEquals(3, A::a());
        $this->assertEquals(3, A::a());
    }

}