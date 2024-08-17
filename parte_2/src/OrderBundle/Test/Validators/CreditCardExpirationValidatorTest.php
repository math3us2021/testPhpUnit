<?php

namespace OrderBundle\Test\Validators;

use OrderBundle\Validators\CreditCardExpirationValidator;
use OrderBundle\Validators\NotEmptyValidator;
use PHPUnit\Framework\TestCase;

class CreditCardExpirationValidatorTest extends TestCase
{
    /**
     * @dataProvider valueProvider
     */
   public function testIsValid($value, $expected)
   {
            $creditCardExpirationDate = new \DateTime($value);
           $notEmptyValidator = new CreditCardExpirationValidator($creditCardExpirationDate);
           $isValid = $notEmptyValidator->isValid();
           $this->assertEquals($expected, $isValid);
   }

    public function valueProvider()
    {
        return [
            'ShouldBeValidWhenDateIsNotExpired' => [ 'value' => '2040-10-01', 'expected' => true ],
            'ShouldNotBeValidWhenDateIsExpired' => [ 'value' => '2020-10-01', 'expected' => false ],
        ];
   }
}