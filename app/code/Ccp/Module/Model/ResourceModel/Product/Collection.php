<?php

namespace Ccp\Module\Model\ResourceModel\Product;

use Magento\Framework\Api\Search\AggregationInterface;
use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Psr\Log\LoggerInterface;

/**
 * Class Collection
 *
 * @package Ccp\Module\Model\ResourceModel\Product
 *
 * This class represents the Collection of Product models.
 */
class Collection extends AbstractCollection implements SearchResultInterface
{
    /**
     * @var AggregationInterface
     */
    protected $aggregations;

    /**
     * Constructor
     *
     * @param EntityFactoryInterface $entityFactory
     * @param LoggerInterface $logger
     * @param FetchStrategyInterface $fetchStrategy
     * @param ManagerInterface $eventManager
     * @param AggregationInterface $aggregations
     */
    public function __construct(
        EntityFactoryInterface $entityFactory,
        LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager,
        AggregationInterface $aggregations
    ) {
        $this->aggregations = $aggregations;
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager);
    }

    /**
     * Initialize collection model and resource model
     */
    protected function _construct()
    {
        $this->_init(\Ccp\Module\Model\Product::class, \Ccp\Module\Model\ResourceModel\Product::class);
    }

    /**
     * @inheritdoc
     */
    public function getAggregations()
    {
        return $this->aggregations;
    }

    /**
     * @inheritdoc
     */
    public function setAggregations($aggregations)
    {
        $this->aggregations = $aggregations;
    }

    /**
     * @inheritdoc
     */
    public function getSearchCriteria()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function setSearchCriteria(SearchCriteriaInterface $searchCriteria = null)
    {
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getTotalCount()
    {
        return $this->getSize();
    }

    /**
     * @inheritdoc
     */
    public function setTotalCount($totalCount)
    {
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setItems(array $items = null)
    {
        $this->clear();
        foreach ($items as $item) {
            $this->addItem($item);
        }
        return $this;
    }
}
