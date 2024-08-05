<?php

namespace Ccp\Module\Controller\Adminhtml\Product;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\RedirectFactory;
use Ccp\Module\Model\ProductFactory;
use Magento\Framework\Message\ManagerInterface;

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
     * @var ProductFactory
     */
    protected $productFactory;

    /**
     * @var RedirectFactory
     */
    protected $resultRedirectFactory;

    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * Delete constructor.
     *
     * @param Context $context
     * @param ProductFactory $productFactory
     * @param RedirectFactory $resultRedirectFactory
     * @param ManagerInterface $messageManager
     */
    public function __construct(
        Context $context,
        ProductFactory $productFactory,
        RedirectFactory $resultRedirectFactory,
        ManagerInterface $messageManager
    ) {
        parent::__construct($context);
        $this->productFactory = $productFactory;
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->messageManager = $messageManager;
    }

    /**
     * Execute the action
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        if (!$this->_authorization->isAllowed(self::ADMIN_RESOURCE)) {
            return $this->_forward('noroute');
        }

        $id = $this->getRequest()->getParam('product_id');
        if ($id) {
            try {
                $model = $this->productFactory->create();
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccessMessage(__('The product has been deleted.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }
        /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*');
    }
}
