<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\SansecComposerIntegrityChecker\Model\System\Message;

use Element119\SansecComposerIntegrityChecker\Model\IntegrityResultsRegistry;
use Element119\SansecComposerIntegrityChecker\Scope\Config as ModuleConfig;
use Magento\Framework\Notification\MessageInterface;
use Magento\Framework\Phrase;
use Magento\Framework\UrlInterface;

class PackageBelowThreshold implements MessageInterface
{
    public function __construct(
        private readonly ModuleConfig $moduleConfig,
        private readonly IntegrityResultsRegistry $integrityResultsRegistry,
        private readonly UrlInterface $urlBuilder
    ) {}

    public function getText(): Phrase
    {
        return __(
            'Sansec Composer Integrity checker found %1 package(s) that did not meet the match threshold. <a href="%2">View scan results.</a>',
            count($this->getFailedMatches()),
            $this->urlBuilder->getUrl('sansec_composer_integrity_checker/index/index')
        );
    }

    public function isDisplayed(): bool
    {
        return (bool)$this->getFailedMatches();
    }

    public function getSeverity(): int
    {
        return MessageInterface::SEVERITY_MAJOR;
    }

    public function getIdentity(): string
    {
        return 'sansec_composer_integrity_checker_failed_scan';
    }

    public function getFailedMatches(): array
    {
        $failedMatches = $this->integrityResultsRegistry->getFailedMatches();

        return $this->moduleConfig->isIgnoreListEnabled() && $this->moduleConfig->shouldRemoveIgnoredPackagesFromAdminNotification()
            ? $this->integrityResultsRegistry->removeIgnoredPackages($failedMatches)
            : $failedMatches;
    }
}
