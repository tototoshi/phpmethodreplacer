# PHP Method Replacer

Note: This project is experimental, so the API is subject to change.


## Requirement
 - runkit

## Install

composer.json
```js
    "require-dev": {
        "phpmethodreplacer/phpmethodreplacer": "dev-master"
    }
```

## Example

```php
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

```