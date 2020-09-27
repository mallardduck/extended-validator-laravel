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

    public function testValidatorsPrepareValuesAndOtherExcludesValueFromOther()
    {
        $testData = [
            'equal' => true,
            'plus' => 'sup',
            'minus' => 'minus',
        ];
        $v = $this->getValidator()->make($testData, [
            'equal' => 'required',
            'plus' => 'sometimes',
            'minus' => 'sometimes|unfilled_if:equal,false'
        ]);
        $validatorProxy = ValidatorProxy::fromValidator($v);
        [$values, $other] = $validatorProxy->prepareValuesAndOther([
            'equal',
            'plus',
            'minus',
        ]);

        self::assertIsArray($values);
        $values = array_flip($values);
        self::assertArrayNotHasKey('equal', $values);
    }
}
