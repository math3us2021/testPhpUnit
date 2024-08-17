<?php

namespace OrderBundle\Service;

use OrderBundle\Entity\Customer;

class LightCategory implements CustomerCategoryInterface
{

    public function isEligible(Customer $customer):bool
    {
        return $customer->getTotalOrders() >= 5 && $customer->getTotalRatings() >=1;

    }

    public function getCategoryName(): string
    {
        return CustomerCategoryService::CATEGORY_LIGHT_USER;
    }

}