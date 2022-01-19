<?php

namespace Appseconnect\RewardPoints\Block;

use Magento\Framework\View\Element\Template;

class RewardPointHistory extends Template
{
    /**
     * @var \Magento\Sales\Model\ResourceModel\Order\CollectionFactory
     */

    protected $_orderCollectionFactory;
    protected $orderRepository;
    protected $_customerSession;
    protected $helper;

    /**
     * RewardPointHistory constructor.
     * @param Template\Context $context
     * @param \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory
     * @param \Magento\Sales\Api\OrderRepositoryInterface $orderRepository
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Appseconnect\B2BMage\Helper\ContactPerson\Data $helperb2b
     * @param array $data
     */

    public function __construct(
        Template\Context $context,
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \Magento\Customer\Model\Session $customerSession,
        \Appseconnect\B2BMage\Helper\ContactPerson\Data $helperb2b,
        array $data = []
    ) {
        $this->_orderCollectionFactory = $orderCollectionFactory;
        $this->orderRepository = $orderRepository;
        $this->_customerSession = $customerSession;
        $this->helperb2b = $helperb2b;
        parent::__construct($context, $data);
    }

    public function getCustomerID(){
        $contact=$this->_customerSession->getCustomer()->getId();
        $customerDetail = $this->helperb2b->getCustomerId($contact);
        $customerId = $customerDetail['customer_id'];
        return $customerId;

    }
    public function getOrderList($customerID)
    {
        $order_collection = $this->_orderCollectionFactory->create();
        $order_collection->addFieldToFilter('customer_id', $customerID);
        $order_collection->addAttributeToSelect('*');

        return $order_collection;
    }
//    public function getOrderItems($order_id)
//    {
//        return $this->orderRepository->get($order_id);
//    }
}