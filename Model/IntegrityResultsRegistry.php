<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\SansecComposerIntegrityChecker\Model;

use Element119\SansecComposerIntegrityChecker\Enum\IntegrityCheckerArrayKeys;
use Element119\SansecComposerIntegrityChecker\Scope\Config;
use Exception;
use Hyva\Admin\Api\HyvaGridArrayProviderInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Flag;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\Serialize\Serializer\Serialize;

class IntegrityResultsRegistry extends Flag implements HyvaGridArrayProviderInterface
{
    protected $_flagCode = 'sansec_composer_integrity_checker_results';

    private Config $moduleConfig;

    public function __construct(
        Context $context,
        Registry $registry,
        Config $moduleConfig,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = [],
        Json $json = null,
        Serialize $serialize = null
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data, $json, $serialize);

        $this->moduleConfig = $moduleConfig;
    }

    public function getHyvaGridData(): array
    {
        return $this->getLastResults();
    }

    public function getLastResults(): ?array
    {
        try {
            return $this->loadSelf()->getFlagData();
        } catch (LocalizedException $e) {
            return [];
        }
    }

    /**
     * @throws Exception
     */
    public function setResults(array $data): self
    {
        $this->setFlagData($data);

        return $this->save();
    }

    public function getFailedMatches(array $packages = []): array
    {
        $failures = [];
        $threshold = $this->moduleConfig->getSansecComposerIntegrityMatchThreshold();

        foreach ($packages ?: $this->getLastResults() as $package) {
            if ((int)$package[IntegrityCheckerArrayKeys::Percentage->value] < $threshold) {
                $failures[] = $package;
            }
        }

        return $failures;
    }
}
