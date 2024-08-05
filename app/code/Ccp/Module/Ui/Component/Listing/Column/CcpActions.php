<?php

namespace Ccp\Module\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class CcpActions extends Column {
    const URL_VIEW_PATH = 'ccp_module/product/edit';
    const URL_DELETE_PATH = 'ccp_module/product/delete';

    /**
     * @var UrlInterface
     */
    protected UrlInterface $urlBuilder;

    /**
     * Constructor of SubscriptionActions class
     *
     * @param UrlInterface $urlBuilder
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        UrlInterface $urlBuilder,
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;

        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare data source for grid actions
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource): array {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $name = $this->getData('name');
                if (isset($item['product_id'])) {
                    $item[$name] = [
                        'edit' => [
                            'href' => $this->urlBuilder->getUrl(static::URL_VIEW_PATH, [
                                    'product_id' => $item['product_id'],
                                ]
                            ),
                            'label' => __('View'),
                        ],
                        'delete' => [
                            'href' => $this->urlBuilder->getUrl(static::URL_DELETE_PATH, [
                                    'product_id' => $item['product_id'],
                                ]
                            ),
                            'label' => __('Delete'),
                            'confirm' => [
                                'title' => __('Delete'),
                                'message' => __('Are you sure you want to delete selected item?')
                            ]
                        ],
                    ];
                }
            }
        }

        return $dataSource;
    }
}
