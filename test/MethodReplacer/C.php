<?php
namespace MethodReplacer;


class C {

    public static function bar()
    {
        return A::a();
    }

}