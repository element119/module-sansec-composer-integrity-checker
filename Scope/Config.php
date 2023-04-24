<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\SansecComposerIntegrityChecker\Scope;

use Magento\Framework\App\Config\ScopeConfigInterface;

class Config
{
    private const XML_PATH_SCAN_ENABLED = 'system/sansec_composer_integrity_checker/scan_enable';

    private ScopeConfigInterface $scopeConfig;

    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    public function isSansecComposerIntegrityScanEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_SCAN_ENABLED);
    }
}
