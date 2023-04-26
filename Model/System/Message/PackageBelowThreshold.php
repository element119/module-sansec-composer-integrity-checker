<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\SansecComposerIntegrityChecker\Model\System\Message;

use Element119\SansecComposerIntegrityChecker\Model\IntegrityResultsRegistry;
use Magento\Framework\Notification\MessageInterface;
use Magento\Framework\Phrase;

class PackageBelowThreshold implements MessageInterface
{
    public function __construct(private readonly IntegrityResultsRegistry $integrityResultsRegistry) {}

    public function getText(): Phrase
    {
        return __(
            'Sansec Composer Integrity checker found %1 package(s) that did not meet the match threshold.',
            count($this->integrityResultsRegistry->getFailedMatches())
        );
    }

    public function isDisplayed(): bool
    {
        return (bool)$this->integrityResultsRegistry->getFailedMatches();
    }

    public function getSeverity(): int
    {
        return MessageInterface::SEVERITY_MAJOR;
    }

    public function getIdentity(): string
    {
        return 'sansec_composer_integrity_checker_failed_scan';
    }
}
