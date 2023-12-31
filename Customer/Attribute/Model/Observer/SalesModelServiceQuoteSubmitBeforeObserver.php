<?php
/**
 * Created by PhpStorm.
 * User: eugen
 * Date: 27.11.2015
 * Time: 17:53
 */

namespace Customer\Attribute\Model\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class SalesModelServiceQuoteSubmitBeforeObserver
 * @package Customer\Attribute\Model\Observer
 */
class SalesModelServiceQuoteSubmitBeforeObserver implements ObserverInterface
{
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * @param \Magento\Framework\ObjectManagerInterface $objectmanager
     */
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectmanager)
    {
        $this->_objectManager = $objectmanager;
    }

    /**
     * @param EventObserver $observer
     * @return $this
     */
    public function execute(EventObserver $observer)
    {
        $order = $observer->getOrder();
        $quoteRepository = $this->_objectManager->create('Magento\Quote\Model\QuoteRepository');
        /** @var \Magento\Quote\Model\Quote $quote */
        $quote = $quoteRepository->get($order->getQuoteId());
        $order->setCustomtext( $quote->getCustomtext() );

        return $this;
    }

}