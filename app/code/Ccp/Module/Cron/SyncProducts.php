<?php

namespace Ccp\Module\Cron;

use Ccp\Module\Model\Api\Client;
use Ccp\Module\Model\ProductFactory;
use Ccp\Module\Model\ResourceModel\Product as ProductResource;
use Psr\Log\LoggerInterface;

/**
 * Class SyncProducts
 * Cron job para sincronizar productos desde una API externa
 */
class SyncProducts
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var ProductFactory
     */
    protected $productFactory;

    /**
     * @var ProductResource
     */
    protected $productResource;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * SyncProducts constructor.
     *
     * @param Client $client
     * @param ProductFactory $productFactory
     * @param ProductResource $productResource
     * @param LoggerInterface $logger
     */
    public function __construct(
        Client $client,
        ProductFactory $productFactory,
        ProductResource $productResource,
        LoggerInterface $logger
    ) {
        $this->client = $client;
        $this->productFactory = $productFactory;
        $this->productResource = $productResource;
        $this->logger = $logger;
    }

    /**
     * Execute the cron job
     *
     * @return void
     */
    public function execute()
    {
        $products = $this->client->fetchProducts();
        foreach ($products as $productData) {
            try {
                /** @var \Ccp\Module\Model\Product $product */
                $product = $this->productFactory->create();
                $this->productResource->load($product, $productData['product_id'], 'product_id');
                $product->addData($productData);
                $this->productResource->save($product);
            } catch (\Exception $e) {
                $this->logger->error('Error saving product data', ['exception' => $e]);
            }
        }
    }
}
