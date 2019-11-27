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

namespace ScandiPWA\StoreGraphQl\Plugin;

use Magento\StoreGraphQl\Controller\HttpHeaderProcessor\StoreProcessor as CoreStoreProcessor;

/**
 * Class StoreProcessor
 * @package ScandiPWA\StoreGraphQl\Plugin
 */
class StoreProcessor
{
    /**
     * @param CoreStoreProcessor $subject
     * @param callable $proceed
     * @param string $headerValue
     * @return void
     */
    public function aroundProcessHeaderValue(
        CoreStoreProcessor $subject,
        callable $proceed,
        string $headerValue
    ) {
        if (empty($headerValue)) {
            return;
        }

        $proceed($headerValue);
    }
}
