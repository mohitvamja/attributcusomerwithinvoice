<?php
namespace Customer\Attribute\Model\Checkout;


use Magento\Checkout\Block\Checkout\LayoutProcessor;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\Session as CustomerSession;

class LayoutProcessorPlugin
{
    protected $logger;
    protected $helper;
    protected $customerRepository;

    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        CustomerRepositoryInterface $customerRepository,
        CustomerSession $customerSession
    ) {
        $this->logger = $logger;
        
         $this->customerRepository = $customerRepository;
        $this->customerSession = $customerSession;
    }

    public function afterProcess(LayoutProcessor $subject, array $jsLayout)
    {
        
         if ($this->customerSession->isLoggedIn()) {
         $customerId  = $this->customerSession->getCustomer()->getId();
        $customer = $this->customerRepository->getById($customerId);
        
        $test = $customer->getCustomAttribute('customtext')->getValue();
        
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['customtext'] = [
           'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                'customScope' => 'shippingAddress',
                'template' => 'ui/form/field',
                'elementTmpl' => "ui/form/element/input",
                'options' => [],
                'id' => 'customtext'
            ],
            'value' => $test,
            'dataScope' => 'shippingAddress.customtext',
            'label' => 'customtext',
            'provider' => 'checkoutProvider',
            'visible' => true,
            'validation' => [],
            'sortOrder' => 230,
            'id' => 'customtext'
        ];

        return $jsLayout;

        }
        else{
             $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['customtext'] = [
           'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                'customScope' => 'shippingAddress',
                'template' => 'ui/form/field',
                'elementTmpl' => "ui/form/element/input",
                'options' => [],
                'id' => 'customtext'
            ],
           
            'dataScope' => 'shippingAddress.customtext',
            'label' => 'customtext',
            'provider' => 'checkoutProvider',
            'visible' => true,
            'validation' => [],
            'sortOrder' => 230,
            'id' => 'customtext'
        ];

        return $jsLayout;
        }
    }
}