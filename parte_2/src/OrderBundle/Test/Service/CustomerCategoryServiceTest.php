<?php

namespace OrderBundle\Test\Service;

use OrderBundle\Entity\Customer;
use OrderBundle\Service\CustomerCategoryService;
use OrderBundle\Service\HardCategory;
use OrderBundle\Service\LightCategory;
use OrderBundle\Service\MediumCategory;
use OrderBundle\Service\NewUsersCategory;
use PHPUnit\Framework\TestCase;

class CustomerCategoryServiceTest extends TestCase
{
    public $customerCategoryService;
    public $customer;

    public function setUp()
    {
        $this->customerCategoryService = new CustomerCategoryService();
        $this->customerCategoryService->addCategories(new HardCategory());
        $this->customerCategoryService->addCategories(new MediumCategory());
        $this->customerCategoryService->addCategories(new LightCategory());
        $this->customerCategoryService->addCategories(new NewUsersCategory());
        $this->customer = new Customer();

    }

    /**
     * @test
     */
    public function customerShouldBeNewUser()
    {
        $usageCategory = $this->customerCategoryService->getUsageCategory($this->customer);
        $this->assertEquals(CustomerCategoryService::CATEGORY_NEW_USER, $usageCategory);
    }

    /**
     * @test
     */
    public function customerShouldBeLightUser()
    {
        $this->customer->setTotalOrders(5);
        $this->customer->setTotalRatings(1);
        $this->customer->setTotalRecommendations(0);

        $usageCategory = $this->customerCategoryService->getUsageCategory($this->customer);
        $this->assertEquals(CustomerCategoryService::CATEGORY_LIGHT_USER, $usageCategory);
    }

    /**
     * @test
     */
    public function customerShouldBeMediumUser()
    {
        $this->customer->setTotalOrders(20);
        $this->customer->setTotalRatings(5);
        $this->customer->setTotalRecommendations(1);

        $usageCategory = $this->customerCategoryService->getUsageCategory($this->customer);
        $this->assertEquals(CustomerCategoryService::CATEGORY_MEDIUM_USER, $usageCategory);
    }

    /**
     * @test
     */
    public function customerShouldBeHardUser()
    {
        $this->customer->setTotalOrders(50);
        $this->customer->setTotalRatings(10);
        $this->customer->setTotalRecommendations(5);

        $usageCategory = $this->customerCategoryService->getUsageCategory($this->customer);
        $this->assertEquals(CustomerCategoryService::CATEGORY_HARD_USER, $usageCategory);
    }
}