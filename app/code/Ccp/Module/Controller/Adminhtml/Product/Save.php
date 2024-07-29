<?php

namespace Ccp\Module\Controller\Adminhtml\Product;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\Result\JsonFactory;
use Ccp\Module\Model\ProductFactory;
use Magento\Backend\App\Action;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;

/**
 * Class Save
 *
 * @package Ccp\Module\Controller\Adminhtml\Product
 *
 * Handles saving of the product.
 */
class Save extends Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var ProductFactory
     */
    protected $productFactory;

    /**
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * Save constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param JsonFactory $resultJsonFactory
     * @param ProductFactory $productFactory
     * @param Registry $coreRegistry
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        JsonFactory $resultJsonFactory,
        ProductFactory $productFactory,
        Registry $coreRegistry
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->productFactory = $productFactory;
        $this->coreRegistry = $coreRegistry;
    }

    /**
     * Execute method for Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        if (!$this->_authorization->isAllowed(self::ADMIN_RESOURCE)) {
            return $this->_forward('noroute');
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            $id = $this->getRequest()->getParam('product_id');
            $product = $this->productFactory->create();

            if ($id) {
                $product->load($id);
                if (!$product->getId()) {
                    $this->messageManager->addErrorMessage(__('This product no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $product->setData($data['general']);

            try {
                $product->save();
                $this->messageManager->addSuccessMessage(__('You saved the product.'));
                $this->coreRegistry->register('product', $product);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['product_id' => $product->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the product.'));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['product_id' => $id]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
