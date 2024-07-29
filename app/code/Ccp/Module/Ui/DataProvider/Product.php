<?php

namespace Ccp\Module\Ui\DataProvider;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Ccp\Module\Model\ResourceModel\Product\CollectionFactory;
use Psr\Log\LoggerInterface;

/**
 * Class Product
 *
 * @package Ccp\Module\Ui\DataProvider
 *
 * DataProvider for the Product grid
 */
class Product extends AbstractDataProvider
{
    protected $loadedData;
    protected $logger;

    /**
     * Product constructor.
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param LoggerInterface $logger
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        LoggerInterface $logger,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->logger = $logger;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data for the grid
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        $this->loadedData = [];

        foreach ($items as $item) {
            $this->loadedData[$item->getId()] = $item->getData();
        }

        $this->logger->debug('DataProvider loadedData', ['data' => $this->loadedData]);
        return $this->loadedData;
    }
}
