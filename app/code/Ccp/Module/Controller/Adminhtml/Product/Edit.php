<?php

namespace Ccp\Module\Controller\Adminhtml\Product;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Registry;

/**
 * Class Edit
 *
 * @package Ccp\Module\Controller\Adminhtml\Product
 *
 * Controller for editing a product in the admin panel
 */
class Edit extends Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;
    /**
     * @var Registry
     */
    protected $coreRegistry;

    const ADMIN_RESOURCE = 'Ccp_Module::product';

    /**
     * Edit constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param Registry $coreRegistry
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Registry $coreRegistry
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->coreRegistry = $coreRegistry;
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

        $id = $this->getRequest()->getParam('id');
        $model = $this->_objectManager->create(\Ccp\Module\Model\Product::class);

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This product no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        $this->coreRegistry->register('product', $model);
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Edit Product'));

        return $resultPage;
    }
}
