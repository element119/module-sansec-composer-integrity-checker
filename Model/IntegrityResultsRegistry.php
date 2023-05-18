<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\SansecComposerIntegrityChecker\Model;

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

    public function __construct(
        Context $context,
        Registry $registry,
        private readonly Config $moduleConfig,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = [],
        Json $json = null,
        Serialize $serialize = null
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data, $json, $serialize);
    }

    public function getHyvaGridData(): array
    {
        $packageData = $this->moduleConfig->shouldOnlyShowFailuresInGrid()
            ? $this->getFailedMatches()
            : $this->getLastResults();

        return $this->moduleConfig->isIgnoreListEnabled() && $this->moduleConfig->shouldRemoveIgnoredPackagesFromAdminGrid()
            ? $this->removeIgnoredPackages($packageData)
            : $packageData;
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
        $packages = [];

        foreach ($data as $package) {
            $packages[$package->name] = $package;
        }

        $this->loadSelf()->setFlagData($packages);

        return $this->save();
    }

    public function getFailedMatches(array $packages = []): array
    {
        $failures = [];
        $threshold = $this->moduleConfig->getSansecComposerIntegrityMatchThreshold();

        foreach ($packages ?: $this->getLastResults() ?? [] as $package) {
            $package = (array)$package;

            if ((int)$package['percentage'] < $threshold) {
                $failures[$package['name']] = $package;
            }
        }

        return $failures;
    }

    public function removeIgnoredPackages(array &$packages): array
    {
        if (!$packages || !($ignoredPackages = $this->moduleConfig->getIgnoredPackageList())) {
            return $packages;
        }

        $allPackageNames = array_keys($packages);

        foreach ($ignoredPackages as $ignoredPackage) {
            if (in_array($ignoredPackage, $allPackageNames)) {
                unset($packages[$ignoredPackage]);
            }
        }

        return $packages;
    }
}
