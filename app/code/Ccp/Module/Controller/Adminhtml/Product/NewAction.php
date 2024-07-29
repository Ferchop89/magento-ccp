<?php

namespace Ccp\Module\Controller\Adminhtml\Product;

/**
 * Class NewAction
 *
 * @package Ccp\Module\Controller\Adminhtml\Product
 *
 * Controller for creating a new product in the admin panel
 */
class NewAction extends Edit
{
    /**
     * Execute the action
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $this->_forward('edit');
    }
}
