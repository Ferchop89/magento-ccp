<?php

namespace Ccp\Module\Controller\Adminhtml\Product;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;

/**
 * Class Delete
 *
 * @package Ccp\Module\Controller\Adminhtml\Product
 *
 * Controller for deleting a product in the admin panel
 */
class Delete extends Action
{
    const ADMIN_RESOURCE = 'Ccp_Module::product';

    /**
     * Delete constructor.
     *
     * @param Context $context
     */
    public function __construct(
        Context $context
    ) {
        parent::__construct($context);
    }

    /**
     * Execute the action
     *
     * @return void
     */
    public function execute()
    {
        if (!$this->_authorization->isAllowed(self::ADMIN_RESOURCE)) {
            return $this->_forward('noroute');
        }

        $id = $this->getRequest()->getParam('id');
        if ($id) {
            try {
                $model = $this->_objectManager->create(\Ccp\Module\Model\Product::class);
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('The product has been deleted.'));
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/');
    }
}
