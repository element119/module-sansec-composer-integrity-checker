<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\SansecComposerIntegrityChecker\Cron;

use Element119\SansecComposerIntegrityChecker\Model\IntegrityResultsRegistry;
use Element119\SansecComposerIntegrityChecker\Scope\Config;
use Element119\SansecComposerIntegrityChecker\Service\EmailNotifier;
use Element119\SansecComposerIntegrityChecker\Service\Scanner;
use Exception;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\MailException;

class Scan
{
    public function __construct(
        private readonly IntegrityResultsRegistry $integrityResultsRegistry,
        private readonly Config $moduleConfig,
        private readonly EmailNotifier $emailNotifier,
        private readonly Scanner $scanner,
    ) {}

    /**
     * Run the Sansec Composer Integrity Checker and store the results.
     *
     * @return void
     * @throws FileSystemException
     * @throws LocalizedException
     * @throws MailException
     * @throws Exception
     */
    public function execute(): void
    {
        if (!$this->moduleConfig->isSansecComposerIntegrityScanEnabled()) {
            return;
        }

        if ($results = $this->scanner->scan()) {
            $this->integrityResultsRegistry->setResults($results);

            if ($this->moduleConfig->isSansecComposerIntegrityEmailNotificationEnabled()
                && $failedMatches = $this->integrityResultsRegistry->getFailedMatches($results)
            ) {
                if ($this->moduleConfig->isIgnoreListEnabled()
                    && $this->moduleConfig->shouldRemoveIgnoredPackagesFromEmail()
                ) {
                    $failedMatches = $this->integrityResultsRegistry->removeIgnoredPackages($failedMatches);
                }

                if ($failedMatches) {
                    $this->emailNotifier->sendErrorNotification($failedMatches);
                }
            }
        }
    }
}
