<?php

namespace Ccp\Module\Model\Api;

use Magento\Framework\HTTP\ClientInterface;
use Psr\Log\LoggerInterface;

/**
 * Class Client
 * Encargado de hacer las solicitudes a la API externa
 */
class Client
{
    /**
     * @var ClientInterface
     */
    protected $httpClient;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Client constructor.
     *
     * @param ClientInterface $httpClient
     * @param LoggerInterface $logger
     */
    public function __construct(ClientInterface $httpClient, LoggerInterface $logger)
    {
        $this->httpClient = $httpClient;
        $this->logger = $logger;
    }

    /**
     * Fetch products from external API
     *
     * @return array
     */
    public function fetchProducts()
    {
        $url = 'https://api.ficticia.com/products';
        try {
            $this->httpClient->get($url);
            $response = $this->httpClient->getBody();
            return json_decode($response, true);
        } catch (\Exception $e) {
            $this->logger->error('Error fetching products from external API', ['exception' => $e]);
            return [];
        }
    }
}
