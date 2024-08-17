<?php

namespace PaymentBundle\Test\Service;

use MyFramework\HttpClientInterface;
use MyFramework\LoggerInterface;
use PaymentBundle\Service\Gateway;
use PHPUnit\Framework\TestCase;

class GatewayTest extends TestCase
{
    /**
     * @test
     */
    public function shoulNotBeAuthentication()
    {
        $user = 'test';
        $password = 'invalid-password';
        $name = 'Matheus';
        $creditCardNumber = '1234567890';
        $validity = new \DateTime('now');
        $value = 100;
        $token = 'token';

        $httpInterface = $this->createMock(HttpClientInterface::class);
        $mapSend = [
            [
                'POST',
                Gateway::BASE_URL . '/authenticate',
                [
                    'user' => $user,
                    'password' => $password
                ],
                null
            ]
        ];
        $httpInterface->expects($this->once())
            ->method('send')
            ->will($this->returnValueMap($mapSend));

        $logger = $this->createMock(LoggerInterface::class);
        $sutGateway = new Gateway($httpInterface, $logger, $user, $password);
        $paid = $sutGateway->pay(
            $name,
            $creditCardNumber,
            $validity,
            $value
        );

        $this->assertEquals(false, $paid);
    }

    /**
     * @test
     */
    public function shoulBeAuthenticationAndMakePayment()
    {
        $httpClient = $this->createMock(HttpClientInterface::class);
        $logger = $this->createMock(LoggerInterface::class);
        $user = 'test';
        $password = 'valid-password';
        $gateway = new Gateway($httpClient, $logger, $user, $password);


        $name = 'Matheus';
        $creditCardNumber = 9999999999999999;
        $validity = new \DateTime('now');
        $value = 100;
        $token = 'token';
        $map = [
            [
                'POST',
                Gateway::BASE_URL . '/authenticate',
                [
                    'user' => $user,
                    'password' => $password
                ],
                'token'
            ],
            [
                'POST',
                Gateway::BASE_URL . '/pay',
                [
                    'name' => $name,
                    'credit_card_number' => $creditCardNumber,
                    'validity' => $validity,
                    'value' => $value,
                    'token' => $token
                ],
                ['paid' => true]
            ]
        ];
        $httpClient
            ->expects($this->atLeast(2))
            ->method('send')
            ->will($this->returnValueMap($map));



        $paid = $gateway->pay(
            $name,
            $creditCardNumber,
            $validity,
            $value
        );

        $this->assertEquals(true, $paid);
    }


    /**
     * @test
     */
    public function shouldSuccessfullyPayWhenGatewayReturnOk()
    {
        $httpClient = $this->createMock(HttpClientInterface::class);
        $logger = $this->createMock(LoggerInterface::class);
        $user = 'test';
        $password = 'valid-password';
        $gateway = new Gateway($httpClient, $logger, $user, $password);

        $name = 'Vinicius Oliveira';
        $creditCardNumber = 9999999999999999;
        $validity = new \DateTime('now');
        $value = 100;
        $token = 'meu-token';

        $httpClient
            ->expects($this->at(0))
            ->method('send')
            ->willReturn($token);


        $httpClient
            ->expects($this->at(1))
            ->method('send')
            ->willReturn(false);

        $paid = $gateway->pay(
            $name,
            $creditCardNumber,
            $validity,
            $value
        );

        $this->assertEquals(false, $paid);
    }
}