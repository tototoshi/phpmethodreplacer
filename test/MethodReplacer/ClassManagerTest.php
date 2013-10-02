<?php
namespace MethodReplacer;

class ClassManagerTest extends \PHPUnit_Framework_TestCase
{

    public function testMock()
    {
        $manager = ClassManager::getInstance();
        $manager->register('MethodReplacer\A', 'a', function() {
            return 3;
        });
        $manager->register('MethodReplacer\B', 'b', function() {
            return 4;
        });

        $this->assertEquals(3, A::a());
        $this->assertEquals(4, B::b());

        $manager->deregister('MethodReplacer\A', 'a');
        $manager->deregister('MethodReplacer\B', 'b');

        $this->assertEquals(1, A::a());
        $this->assertEquals(2, B::b());

    }


}
