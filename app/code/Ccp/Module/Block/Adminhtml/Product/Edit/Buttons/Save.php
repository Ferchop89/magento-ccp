<?php

namespace Ccp\Module\Block\Adminhtml\Product\Edit\Buttons;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class Save
 *
 * @package Ccp\Module\Block\Adminhtml\Product\Edit\Buttons
 *
 * Provides the save button configuration for the product edit form.
 */
class Save implements ButtonProviderInterface
{
    /**
     * Get button configuration
     *
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Save'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'sort_order' => 40,
        ];
    }
}
