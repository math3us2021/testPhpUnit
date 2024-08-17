<?php

namespace OrderBundle\Test\Service;

use OrderBundle\Repository\BadWordsRepositoryInterface;
use OrderBundle\Service\BadWordsValidator;
use PHPUnit\Framework\TestCase;

class BadWordsValidatorsTest extends TestCase
{
    /**
     * @test
     * @dataProvider badWordsDataProvider
     */
    public function hasBadWords($text, $expected)
    {
        $badWordsRepository = $this->createMock(BadWordsRepositoryInterface::class);
        $badWordsRepository->method('findAllAsArray')
            ->willReturn(['bobo', 'feio', 'chule']);
        $sutBadWordsValidators = new BadWordsValidator($badWordsRepository);
        $resultHasBad = $sutBadWordsValidators->hasBadWords($text);
        $this->assertEquals($resultHasBad, $expected);
    }

    public function badWordsDataProvider()
    {
        return [
            'shouldNotBeBadWords' => [ 'text' => 'O restaurante é bom', 'expected' => false],
            'shouldBeBadWords' => [ 'text' => 'O restaurante é feio', 'expected' => true],
            'shouldBeTextEmpty' => [ 'text' => '', 'expected' => false],
        ];
    }


}