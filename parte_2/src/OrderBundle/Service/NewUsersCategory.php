<?php

namespace OrderBundle\Service;

use OrderBundle\Entity\Customer;

class NewUsersCategory implements CustomerCategoryInterface
{
    public function isEligible(Customer $customer)
    {
        return true;   
    }

    public function getCategoryName()
    {
        return CustomerCategoryService::CATEGORY_NEW_USER;
    }

}