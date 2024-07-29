<?php

namespace Ccp\Module\Model\Search;

use Magento\Framework\Api\Search\AggregationInterface;
use Magento\Framework\Api\Search\BucketInterface;

/**
 * Class Aggregation
 *
 * @package Ccp\Module\Model\Search
 */
class Aggregation implements AggregationInterface
{
    /**
     * @var BucketInterface[]
     */
    protected $buckets;

    /**
     * Aggregation constructor.
     *
     * @param BucketInterface[] $buckets
     */
    public function __construct(array $buckets = [])
    {
        $this->buckets = $buckets;
    }

    /**
     * @inheritdoc
     */
    public function getBuckets()
    {
        return $this->buckets;
    }

    /**
     * @inheritdoc
     */
    public function getBucket($name)
    {
        return $this->buckets[$name] ?? null;
    }

    /**
     * @inheritdoc
     */
    public function setBuckets(array $buckets)
    {
        $this->buckets = $buckets;
        return $this;
    }

    public function getBucketNames()
    {
        // TODO: Implement getBucketNames() method.
    }
}
