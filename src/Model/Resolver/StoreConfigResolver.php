<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace ScandiPWA\StoreGraphQl\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\StoreGraphQl\Model\Resolver\Store\StoreConfigDataProvider;
use Magento\Customer\Helper\Address;

/**
 * StoreConfig page field resolver, used for GraphQL request processing.
 */
class StoreConfigResolver implements ResolverInterface
{
    /**
     * @var StoreConfigDataProvider
     */
    private $storeConfigDataProvider;

    /**
     * @var Address
     */
    private $address;


    /**
     * StoreConfigResolver constructor.
     * @param StoreConfigDataProvider $storeConfigDataProvider
     * @param Address $address
     */
    public function __construct(
        StoreConfigDataProvider $storeConfigDataProvider,
        Address $address
    ) {
        $this->storeConfigDataProvider = $storeConfigDataProvider;
        $this->address = $address;
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
        $storeConfig = $this->storeConfigDataProvider->getStoreConfigData($context->getExtensionAttributes()->getStore());

        $storeConfig['address_lines_quantity'] = $this->address->getStreetLines($context->getExtensionAttributes()->getStore());
        return $storeConfig;
    }
}
