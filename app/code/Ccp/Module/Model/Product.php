<?php

namespace Ccp\Module\Model;

use Magento\Framework\Model\AbstractModel;
use Ccp\Module\Model\ResourceModel\Product as ResourceProductModel;

/**
 * Class Product
 *
 * @package Ccp\Module\Model
 *
 * This class represents the Product model and handles product data.
 */
class Product extends AbstractModel
{
    /**
     * Initialize resource model
     */
    protected function _construct()
    {
        $this->_init(ResourceProductModel::class);
    }
}
