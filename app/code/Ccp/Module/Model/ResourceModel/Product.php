<?php

namespace Ccp\Module\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Product
 *
 * @package Ccp\Module\Model\ResourceModel
 *
 * This class represents the Resource Model for the Product model.
 */
class Product extends AbstractDb
{
    /**
     * Initialize resource model
     */
    protected function _construct()
    {
        $this->_init('ccp_product', 'product_id');
    }
}
