<?php
/**
 * ScandiPWA_StoreGraphQL
 *
 * @category    ScandiPWA
 * @package     ScandiPWA_StoreGraphQL
 * @author      Alfreds Genkins <info@scandiweb.com>
 * @copyright   Copyright (c) 2018 Scandiweb, Ltd (https://scandiweb.com)
 */

declare(strict_types=1);

namespace ScandiPWA\StoreGraphQl\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\StoreGraphQl\Model\Resolver\Store\StoreConfigDataProvider;

/**
 * StoreList field resolver, used for GraphQL request processing.
 */
class StoreListResolver implements ResolverInterface
{
    /**
     * @var StoreConfigDataProvider
     */
    private $storeConfigDataProvider;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @param StoreConfigDataProvider $storeConfigsDataProvider
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        StoreConfigDataProvider $storeConfigsDataProvider,
        StoreManagerInterface $storeManager
    ) {
        $this->storeConfigDataProvider = $storeConfigsDataProvider;
        $this->storeManager = $storeManager;
    }

    /**
     * @inheritdoc
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        $stores = $this->storeManager->getStores();

        return array_map(function ($store) {
            /** @var $store StoreInterface */
            return array_merge(
                $this->storeConfigDataProvider->getStoreConfigData($store),
                ['name' => $store->getName(), 'is_active' => $store->getIsActive()]
            );
        }, $stores);
    }
}
