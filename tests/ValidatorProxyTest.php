<?php

namespace MallardDuck\ExtendedValidator\Tests;

use MallardDuck\ExtendedValidator\ValidatorProxy;

class ValidatorProxyTest extends \MallardDuck\ExtendedValidator\Tests\BaseTest
{
    public function testNearlyImposibleButRequiredDefaultReturn()
    {
        $v = $this->getValidator()->make([
            'equal' => true,
        ], [
            'equal'  => 'required',
        ]);
        $validatorProxy = ValidatorProxy::fromValidator($v);

        $this->assertIsInt($validatorProxy->convertValuesToBoolean([42])[0]);
        $this->assertIsString($validatorProxy->convertValuesToBoolean(['not a bool'])[0]);
    }
}
