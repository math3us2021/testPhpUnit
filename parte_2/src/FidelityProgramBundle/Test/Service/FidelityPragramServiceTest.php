<?php

namespace FidelityProgramBundle\Test\Service;

use FidelityProgramBundle\Repository\PointsRepositoryInterface;
use FidelityProgramBundle\Service\FidelityProgramService;
use FidelityProgramBundle\Service\PointsCalculator;
use MyFramework\LoggerInterface;
use OrderBundle\Entity\Customer;
use PHPUnit\Framework\TestCase;

class FidelityPragramServiceTest extends TestCase
{
    private function loggerCreatMock()
    {
        return $this->createMock(LoggerInterface::class);
    }

    private function pointsCalculatorMocker($value)
    {
        $pointsCalculator = $this->createMock(PointsCalculator::class);
        $pointsCalculator->method('calculatePointsToReceive')
            ->willReturn($value);
        return $pointsCalculator;
    }


    /**
     * @test
     */
    public function shouldSaveWhenReceivePoints()
    {
        $poinstRepository = $this->createMock(PointsRepositoryInterface::class);
        $poinstRepository->expects($this->once())
            ->method('save');

        $pointsCalculator = $this->pointsCalculatorMocker(100);

        $logger = $this->loggerCreatMock();
        $sutFidelityProgramService = new FidelityProgramService($poinstRepository, $pointsCalculator, $logger);

        $customer = $this->createMock(Customer::class);
        $value = 50;
        $sutFidelityProgramService->addPoints($customer, $value);
    }


    /**
     * @test
     */
    public function shouldNotSaveWhenReceiveZeroPoint()
    {
        $poinstRepository = $this->createMock(PointsRepositoryInterface::class);
        $poinstRepository->expects($this->never())
            ->method('save');

        $pointsCalculator = $this->pointsCalculatorMocker(0);
        $logger = $this->loggerCreatMock();

        $sutFidelityProgramService = new FidelityProgramService($poinstRepository, $pointsCalculator, $logger);

        $customer = $this->createMock(Customer::class);
        $value = 20;
        $sutFidelityProgramService->addPoints($customer, $value);
    }


    /**
     * @test
     */
    public function shouldSaveWhenReceiveCheckdMensageLog()
    {
        $poinstRepository = $this->createMock(PointsRepositoryInterface::class);
        $poinstRepository->expects($this->once())
            ->method('save');

        $pointsCalculator = $this->pointsCalculatorMocker(100);

        $allMensage = [];
        $loggerInterface = $this->createMock(LoggerInterface::class);
        $loggerInterface->method('log')
            ->will($this->returnCallback(
                function ($message) use (&$allMensage){
                    $allMensage[] = $message;
                }
            ) );

        $sutFidelityProgramService = new FidelityProgramService($poinstRepository, $pointsCalculator, $loggerInterface);

        $customer = $this->createMock(Customer::class);
        $value = 50;
        $sutFidelityProgramService->addPoints($customer, $value);
        $expectedMensage = [
            'Checking points for customer',
            'Customer received points'
        ];
        $this->assertEquals($expectedMensage, $allMensage);
    }
}