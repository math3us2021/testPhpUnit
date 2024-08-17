<?php

namespace OrderBundle\Service;

use OrderBundle\Entity\Customer;

class MediumCategory implements CustomerCategoryInterface
{

    public function isEligible(Customer $customer)
    {
        return $customer->getTotalOrders() >= 20 &&
            $customer->getTotalRatings() >= 5 &&
            $customer->getTotalRecommendations() >= 1;
    }

    public function getCategoryName()
    {
        return CustomerCategoryService::CATEGORY_MEDIUM_USER;
    }

}