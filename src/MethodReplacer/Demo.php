<?php
require 'vendor/autoload.php';

class Hoge
{

    public static function moge()
    {
        echo 'moge' . PHP_EOL;
    }

}

class Hige
{
    public static function mige()
    {
        $mock = new \MethodReplacer\ClassMethodReplacementGuard();
        $mock->override('hoge', 'moge', function () {
            echo 'mige' . PHP_EOL;
        });

        Hoge::moge();
    }
}

Hoge::moge(); //=> moge
Hige::mige(); //=> mige
Hoge::moge(); //=> moge

