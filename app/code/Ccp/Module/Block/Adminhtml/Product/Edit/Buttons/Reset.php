<?php

namespace Ccp\Module\Block\Adminhtml\Product\Edit\Buttons;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class Reset
 *
 * @package Ccp\Module\Block\Adminhtml\Product\Edit\Buttons
 *
 * Provides the reset button configuration for the product edit form.
 */
class Reset implements ButtonProviderInterface
{
    /**
     * Get button configuration
     *
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Reset'),
            'on_click' => 'location.reload();',
            'class' => 'reset',
            'sort_order' => 30
        ];
    }
}
