<?php

namespace OrderBundle\Test\Validators;

use OrderBundle\Validators\NotEmptyValidator;
use PHPUnit\Framework\TestCase;

class NotEmptyValidatorTest extends TestCase
{
    /**
     * @dataProvider valueProvider
     */
   public function testIsValid($value, $expected)
   {
           $notEmptyValidator = new NotEmptyValidator($value);
           $isValid = $notEmptyValidator->isValid();
           $this->assertEquals($expected, $isValid);

   }

    public function valueProvider()
    {
        return [
            'ShouldBeValidWhenValuesIsNotEmpty' => [ 'value' => 'foo', 'expected' => true ],
            'ShouldNotBeValidWhenValuesIsEmpty' => [ 'value' => '', 'expected' => false ],
        ];
   }
}