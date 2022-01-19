<?php
namespace Appseconnect\RewardPoints\Model\Quote;
/**
 * Class Discount
 * @package Appseconnect\RewardPoints\Model\Total\Quote
 */
class Discount extends \Magento\Quote\Model\Quote\Address\Total\AbstractTotal
{
    public function __construct(
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\SalesRule\Model\Validator $validator,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
    )
    {
        $this->setCode('rewardpointdiscount');
        $this->eventManager = $eventManager;
        $this->calculator = $validator;
        $this->storeManager = $storeManager;
        $this->priceCurrency = $priceCurrency;
    }

    public function collect(
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total $total
    )
    {
        parent::collect($quote, $shippingAssignment, $total);
        $address = $shippingAssignment->getShipping()->getAddress();
        $label = 'My Reward Point Discount';
        $TotalAmount=$total->getSubtotal();
        $TotalAmount=$TotalAmount*.5; //Set 10% discount

        $discountAmount ="-".$TotalAmount;
        $appliedCartDiscount = 0;

        if($total->getDiscountDescription())
        {
            $appliedCartDiscount = $total->getDiscountAmount();
            $discountAmount = $total->getDiscountAmount()+$discountAmount;
            $label = $total->getDiscountDescription().', '.$label;
        }

        $total->setDiscountDescription($label);
        $total->setDiscountAmount($discountAmount);
        $total->setBaseDiscountAmount($discountAmount);
        $total->setSubtotalWithDiscount($total->getSubtotal() + $discountAmount);
        $total->setBaseSubtotalWithDiscount($total->getBaseSubtotal() + $discountAmount);

        if(isset($appliedCartDiscount))
        {
            $total->addTotalAmount($this->getCode(), $discountAmount - $appliedCartDiscount);
            $total->addBaseTotalAmount($this->getCode(), $discountAmount - $appliedCartDiscount);
        }
        else
        {
            $total->addTotalAmount($this->getCode(), $discountAmount);
            $total->addBaseTotalAmount($this->getCode(), $discountAmount);
        }
        return $this;
    }


}