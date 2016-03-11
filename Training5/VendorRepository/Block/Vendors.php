<?php
namespace Training5\VendorRepository\Block;

use Magento\Framework\View\Element\AbstractBlock;
use Magento\Framework\View\Element\Template;

/**
 * Class Vendors
 * @package Training5\VendorRepository\Block
 */
class Vendors extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Training4\Vendor\Api\VendorRepositoryInterfaceFactory
     */
    protected $_repositoryFactory;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    protected $_searchCriteriaBuilder;

    /**
     * @var \Magento\Framework\Api\FilterBuilder
     */
    protected $_filterBuilder;

    /**
     * @var \Magento\Framework\Api\Search\FilterGroupBuilder
     */
    protected  $_filterGroupFilter;

    /**
     * @var \Magento\Framework\Api\SortOrderBuilder
     */
    protected $_sortOrderBuilder;

    /**
     * @param Template\Context $context
     * @param array $data
     * @param \Training4\Vendor\Api\VendorRepositoryInterfaceFactory $repositoryInterfaceFactory
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Magento\Framework\Api\FilterBuilder $filterBuilder
     * @param \Magento\Framework\Api\Search\FilterGroupBuilder $filterGroupBuilder
     * @param \Magento\Framework\Api\SortOrderBuilder $sortOrderBuilder
     */
    public function __construct(
        Template\Context $context,
        array $data = [],
        \Training4\Vendor\Api\VendorRepositoryInterfaceFactory $repositoryInterfaceFactory,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\Api\FilterBuilder $filterBuilder,
        \Magento\Framework\Api\Search\FilterGroupBuilder $filterGroupBuilder,
        \Magento\Framework\Api\SortOrderBuilder $sortOrderBuilder
    ) {
        $this->_repositoryFactory = $repositoryInterfaceFactory;
        $this->_searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->_filterBuilder = $filterBuilder;
        $this->_filterGroupFilter = $filterGroupBuilder;
        $this->_sortOrderBuilder = $sortOrderBuilder;

        parent::__construct($context, $data); // TODO: Change the autogenerated stub
    }

    /**
     * Get associated products for the vendor
     *
     * @param $id
     * @return array
     */
    public function getAssocProduct($id)
    {
        $result = [];
        if ($id) {
            $repository = $this->_repositoryFactory->create();
            $result = $repository->getAssociatedProductIds($id);
        }
        return $result;
    }

    /**
     * @return bool
     */
    public function getVendorsList()
    {
        $searchCriteria = $this->_searchCriteriaBuilder->create();
        $repository = $this->_repositoryFactory->create();
        $list = $repository->getList($searchCriteria);
        if ($list) {
            return $list;
        }
        return false;
    }

    /**
     * @param $field
     * @return bool
     */
    public function getSortedBy($field)
    {
        $sortOrder[] = $this->_sortOrderBuilder
            ->setDirection('ASC')
            ->setField($field)
            ->create();
        $searchCriteria = $this->_searchCriteriaBuilder
            ->setSortOrders($sortOrder)
            ->create();
        $repository = $this->_repositoryFactory->create();
        $list = $repository->getList($searchCriteria)->getItems();
        if ($list) {
            return $list;
        }
        return false;
    }

    /**
     * @param $name
     * @return bool
     */
    public function filterByName($name)
    {
        $filters[] = $this->_filterBuilder
            ->setField('name')
            ->setValue($name)
            ->create();
        $searchCriteria = $this->_searchCriteriaBuilder
            ->addFilters($filters)
            ->create();

        $repository = $this->_repositoryFactory->create();
        $list = $repository->getList($searchCriteria)->getItems();
        if ($list) {
            return $list;
        }
        return false;
    }
}