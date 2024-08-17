<?php

namespace OrderBundle\Test\Entity;

use OrderBundle\Entity\Customer;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    /**
     * @test
     * @dataProvider  custumerAllowDataProvider
     */
    public function isAllowedToOrder($isActive, $isBlocked, $expectedAllowed)
    {
        $sutCustomer = new Customer($isActive, $isBlocked, 'Matheus', '16988881888');
        $verifyIsAllowToOrder = $sutCustomer->isAllowedToOrder();
        $this->assertEquals($verifyIsAllowToOrder, $expectedAllowed);
    }

    public function custumerAllowDataProvider()
    {
        return [
            'shoudBeAllowWhenActiveAndNotBlocked' => [
                'isActive' => true,
                'isBlocked' => false,
                'expectedAllowed' => true
            ],
            'shoudNotBeAllowWhenActiveAndButIsBlocked' => [
                'isActive' => true,
                'isBlocked' => true,
                'expectedAllowed' => false
            ],
            'shoudNotBeAllowWhenActiveAndIsNotActive' => [
                'isActive' => false,
                'isBlocked' => false,
                'expectedAllowed' => false
            ],
            'shoudNotBeAllowWhenNotActiveAndIsBlocked' => [
                'isActive' => false,
                'isBlocked' => true,
                'expectedAllowed' => false
            ],
        ];
    }
}

