<?php

namespace Ccp\Module\Block\Adminhtml\Product\Edit\Buttons;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\App\RequestInterface;

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
     * Constructor
     *
     * @param UrlInterface $urlBuilder
     * @param RequestInterface $request
     */
    public function __construct(UrlInterface $urlBuilder, RequestInterface $request)
    {
        $this->urlBuilder = $urlBuilder;
        $this->request = $request;
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
        return $this->getUrl('*/*/delete', ['id' => $this->getProductId()]);
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
        return (int)$this->request->getParam('id');
    }
}
