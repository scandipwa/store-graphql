<?php
/**
 * ScandiPWA_StoreGraphQL
 *
 * @category    ScandiPWA
 * @package     ScandiPWA_StoreGraphQL
 * @author      Aleksandrs Kondratjevs <info@scandiweb.com>
 * @copyright   Copyright (c) 2018 Scandiweb, Ltd (https://scandiweb.com)
 */

declare(strict_types=1);

namespace ScandiPWA\StoreGraphQl\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Query\Resolver\Value;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Tax\Model\Config;

/**
 * Class PriceTaxDisplayResolver
 * @package ScandiPWA\StoreGraphQl\Model\Resolver
 */
class PriceTaxDisplayResolver implements ResolverInterface
{
    const DISPLAY_PRODUCT_PRICES_IN_CATALOG_INCL_TAX = 'DISPLAY_PRODUCT_PRICES_IN_CATALOG_INCL_TAX';
    const DISPLAY_PRODUCT_PRICES_IN_CATALOG_EXCL_TAX = 'DISPLAY_PRODUCT_PRICES_IN_CATALOG_EXCL_TAX';
    const DISPLAY_PRODUCT_PRICES_IN_CATALOG_BOTH = 'DISPLAY_PRODUCT_PRICES_IN_CATALOG_BOTH';

    const DISPLAY_SHIPPING_PRICES_INCL_TAX = 'DISPLAY_SHIPPING_PRICES_INCL_TAX';
    const DISPLAY_SHIPPING_PRICES_EXCL_TAX = 'DISPLAY_SHIPPING_PRICES_EXCL_TAX';
    const DISPLAY_SHIPPING_PRICES_BOTH = 'DISPLAY_SHIPPING_PRICES_BOTH';

    /**
     * @var Config
     */
    private $config;

    /**
     * PriceTaxDisplayResolver constructor.
     *
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param Field $field
     * @param ContextInterface $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array|Value|mixed
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    )
    {
        $store = (int)$value['id'];

        return [
            'product_price_display_type' => $this->getProductPriceDisplayType($store),
            'shipping_price_display_type' => $this->getShippingPriceDisplayType($store)
        ];
    }

    /**
     * Get product price display type
     *
     * @param int $store
     * @return string
     */
    private function  getProductPriceDisplayType(int $store)
    {
        $result = self::DISPLAY_PRODUCT_PRICES_IN_CATALOG_BOTH;

        if ($this->config->getPriceDisplayType($store) === 1) {
            $result = self::DISPLAY_PRODUCT_PRICES_IN_CATALOG_EXCL_TAX;
        } elseif ($this->config->getPriceDisplayType($store) === 2) {
            $result = self::DISPLAY_PRODUCT_PRICES_IN_CATALOG_INCL_TAX;
        }

        return $result;
    }

    /**
     * Get shipping price display type
     *
     * @param int $store
     * @return string
     */
    private function getShippingPriceDisplayType(int $store)
    {
        $result = self::DISPLAY_SHIPPING_PRICES_BOTH;

        if ($this->config->getShippingPriceDisplayType($store) === 1) {
            $result = self::DISPLAY_SHIPPING_PRICES_EXCL_TAX;
        } elseif ($this->config->getShippingPriceDisplayType($store) === 2) {
            $result = self::DISPLAY_SHIPPING_PRICES_INCL_TAX;
        }

        return $result;
    }
}
