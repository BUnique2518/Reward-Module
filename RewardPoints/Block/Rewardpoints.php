<?php
 namespace Appseconnect\RewardPoints\Block;
use Magento\Framework\Registry;
 use Magento\Framework\View\Element\Template;


class Rewardpoints extends Template{
    /**
     * @var Registry
     */
    private $registry;
    protected $helper;
    protected $customerSession;

    /**
     * Rewardpoints constructor.
     * @param Template\Context $context
     * @param array $data
     * @param Registry $registry
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Appseconnect\RewardPoints\Helper\Data $helperData
     * @param \Appseconnect\B2BMage\Helper\ContactPerson\Data $helperb2b
     */

    public function __construct(
     Template\Context $context,
     array $data = [],
     Registry $registry,
     \Magento\Customer\Model\Session $customerSession,
     \Appseconnect\RewardPoints\Helper\Data $helperData,
     \Appseconnect\B2BMage\Helper\ContactPerson\Data $helperb2b
    )
    {
        $this->registry=$registry;
        $this->helper = $helperData;
        $this->helperb2b = $helperb2b;
        $this->_customerSession = $customerSession;
        parent::__construct($context, $data);
    }
    public function getPoints(){
        $product=$this->getCurrentProduct();
        return ($product->getData('rp'));
    }

    /**
     * @return \Magento\Catalog\Model\Product
     */
    protected function getCurrentProduct(){
        return $this->registry->registry('product');
    }
    public function getCustomerAttributeValue(){
        $contact=$this->_customerSession->getCustomer()->getId();
        $customerDetail = $this->helperb2b->getCustomerId($contact);
        $customerId = $customerDetail['customer_id'];
        return $this->helper->getAttributeValue($customerId);

    }
}

?>

