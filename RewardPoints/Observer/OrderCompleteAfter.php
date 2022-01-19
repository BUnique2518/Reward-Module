<?php
namespace Appseconnect\RewardPoints\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
class OrderCompleteAfter implements ObserverInterface
{
    protected $customerRepository;

    public function __construct(
        array $data = [],
        CustomerRepositoryInterface $customerRepository
    )
    {
        $this->customerRepository = $customerRepository;
//        $this->layout = $layout;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        $customerId=$order->getCustomerId();
        $customer=$this->customerRepository->getById($customerId);

        if($customer->getCustomAttribute('reward_points')==null){
            $customer->setCustomAttribute('reward_points', 0);
            $this->customerRepository->save($customer);
        }


        if ($order->getState() == 'complete') {
            foreach ($order->getAllItems() as $item) {
                $Reward = $item->getProduct()->getData('rp');
                $prereward=$customer->getCustomAttribute('reward_points')->getValue();
                $customer->setCustomAttribute('reward_points', $Reward+$prereward);
                $this->customerRepository->save($customer);
            }


        }

    }
}
?>