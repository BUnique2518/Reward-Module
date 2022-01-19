<?php
namespace Appseconnect\RewardPoints\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Customer\Api\CustomerRepositoryInterface;
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $customerRepository;
    public function __construct(
        Context $context,
        CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
        parent::__construct($context);
    }
    public function getAttributeValue($customerId)
    {
        $customer = $this->customerRepository->getById($customerId);
        if($customer->getCustomAttribute('reward_points')==null){
            return 0;
        }
        else{
            return $customer->getCustomAttribute('reward_points')->getValue();
        }

    }
}
