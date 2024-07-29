<?php

namespace Ccp\Module\Controller\Adminhtml\Product;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 *
 * @package Ccp\Module\Controller\Adminhtml\Product
 *
 * Controller for displaying the product grid in the admin panel
 */
class Index extends Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    const ADMIN_RESOURCE = 'Ccp_Module::product';

    /**
     * Index constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(Context $context, PageFactory $resultPageFactory)
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Execute the action
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        if (!$this->_authorization->isAllowed(self::ADMIN_RESOURCE)) {
            return $this->_forward('noroute');
        }

        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Ccp_Module::product');
        $resultPage->getConfig()->getTitle()->prepend(__('CCP Products'));
        return $resultPage;
    }
}
