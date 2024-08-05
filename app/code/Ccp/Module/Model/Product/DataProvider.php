<?php

namespace Ccp\Module\Model\Product;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Framework\App\RequestInterface;
use Ccp\Module\Model\ResourceModel\Product;
use Ccp\Module\Model\ResourceModel\Product\CollectionFactory;

class DataProvider extends AbstractDataProvider {

    /**
     * @var RequestInterface
     */
    protected RequestInterface $request;

    private $loadedData;

    /**
     * Constructor of DataProvider class
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $contactCollectionFactory
     * @param RequestInterface $request
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        CollectionFactory $contactCollectionFactory,
        RequestInterface $request,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $contactCollectionFactory->create();
        $this->request = $request;

        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get subscription collection
     *
     * @return array
     */
    public function getData(): array {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();

        /** @var Product $product */
        foreach ($items as $product) {
            $this->loadedData[$product->getId()]['product'] = $product->getData();
        }

        $id = $this->request->getParam('product_id');

        $this->loadedData[$id]['visible'] = (bool) $id;
        $this->loadedData[$id]['disabled'] = (bool) $id;
        return $this->loadedData;
    }
}
