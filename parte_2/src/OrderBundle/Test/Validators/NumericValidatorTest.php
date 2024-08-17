<?php

namespace OrderBundle\Test\Validators;

use OrderBundle\Validators\NumericValidator;
use PHPUnit\Framework\TestCase;

class NumericValidatorTest extends TestCase
{
    /**
     * @dataProvider valueProvider
     */
   public function testIsValid($value, $expected)
   {
           $numericValidator = new NumericValidator($value);
           $isValid = $numericValidator->isValid();
           $this->assertEquals($expected, $isValid);

   }

    public function valueProvider()
    {
        return [
            'ShouldBeValidWhenValuesIsNumber' => [ 'value' => 123, 'expected' => true ],
            'ShouldBeValidWhenValuesIsNumberString' => [ 'value' => '123', 'expected' => true ],
            'ShouldNotBeValidWhenValuesIsNotNumber' => [ 'value' => 'asd', 'expected' => false ],
            'ShouldNotBeValidWhenValuesIsEmpty' => [ 'value' => '', 'expected' => false ],
        ];
   }
}