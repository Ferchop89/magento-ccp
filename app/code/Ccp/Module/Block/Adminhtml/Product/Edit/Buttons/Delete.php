<?php

namespace Ccp\Module\Block\Adminhtml\Product\Edit\Buttons;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Registry;

/**
 * Class Delete
 *
 * @package Ccp\Module\Block\Adminhtml\Product\Edit\Buttons
 *
 * Provides the delete button configuration for the product edit form.
 */
class Delete implements ButtonProviderInterface
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * Constructor
     *
     * @param UrlInterface $urlBuilder
     * @param RequestInterface $request
     * @param Registry $coreRegistry
     */
    public function __construct(
        UrlInterface $urlBuilder,
        RequestInterface $request,
        Registry $coreRegistry
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->request = $request;
        $this->coreRegistry = $coreRegistry;
    }

    /**
     * Get button configuration
     *
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Delete'),
            'on_click' => 'deleteConfirm(\'' . __(
                    'Are you sure you want to do this?'
                ) . '\', \'' . $this->getDeleteUrl() . '\')',
            'class' => 'delete',
            'sort_order' => 20
        ];
    }

    /**
     * Get URL for delete button
     *
     * @return string
     */
    private function getDeleteUrl()
    {
        return $this->getUrl('*/*/delete', ['product_id' => $this->getProductId()]);
    }

    /**
     * Retrieve URL by route
     *
     * @param string $route
     * @param array $params
     * @return string
     */
    private function getUrl($route = '', $params = [])
    {
        return $this->urlBuilder->getUrl($route, $params);
    }

    /**
     * Get product ID
     *
     * @return int
     */
    private function getProductId()
    {
        $product = $this->coreRegistry->registry('product');
        return $product ? $product->getId() : null;
    }
}
