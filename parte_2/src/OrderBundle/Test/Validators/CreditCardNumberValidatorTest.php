<?php

namespace OrderBundle\Test\Validators;

use OrderBundle\Validators\CreditCardNumberValidator;
use PHPUnit\Framework\TestCase;

class CreditCardNumberValidatorTest extends TestCase
{
    /**
     * @dataProvider valueProvider
     */
   public function testIsValid($value, $expected)
   {
           $cardNumberValidator = new CreditCardNumberValidator($value);
           $isValid = $cardNumberValidator->isValid();
           $this->assertEquals($expected, $isValid);

   }

    public function valueProvider()
    {
        return [
            'ShouldBeValidWhenValuesIsACreditCard' => [ 'value' => 1234567891234567, 'expected' => true ],
            'ShouldBeValidWhenValuesIsACreditCardAsString' => [ 'value' => '1234567891234567', 'expected' => true ],
            'ShouldNotBeValidWhenValuesIsNotACreditCard' => [ 'value' => 12345678, 'expected' => false ],
            'ShouldNotBeValidWhenValuesIsNotEmpty' => [ 'value' => '', 'expected' => false ],
            'ShouldNotBeValidWhenValuesIsNotString' => [ 'value' => 'asdfgh', 'expected' => false ],
        ];
   }
}