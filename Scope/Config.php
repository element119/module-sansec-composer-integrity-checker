<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\SansecComposerIntegrityChecker\Scope;

use Element119\SansecComposerIntegrityChecker\Block\Adminhtml\Form\Field\ComposerIntegrityNotificationEmailRecipients;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Serialize\SerializerInterface;

class Config
{
    private const XML_PATH_SCAN_ENABLED = 'system/sansec_composer_integrity_checker/scan_enable';
    private const XML_PATH_EMAIL_ENABLED = 'system/sansec_composer_integrity_checker/scan_email_notification_enable';
    private const XML_PATH_EMAIL_THRESHOLD = 'system/sansec_composer_integrity_checker/scan_failure_threshold';
    private const XML_PATH_EMAIL_RECIPIENTS = 'system/sansec_composer_integrity_checker/scan_error_email_recipient';

    public function __construct(
        private readonly ScopeConfigInterface $scopeConfig,
        private readonly SerializerInterface $serializer
    ) {}

    public function isSansecComposerIntegrityScanEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_SCAN_ENABLED);
    }

    public function isSansecComposerIntegrityEmailNotificationEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_EMAIL_ENABLED);
    }

    public function getSansecComposerIntegrityMatchThreshold(): int
    {
        return (int)$this->scopeConfig->getValue(self::XML_PATH_EMAIL_THRESHOLD);
    }

    public function getSansecComposerIntegrityEmailRecipients(): array
    {
        $recipients = [];
        $recipientsConfig = $this->scopeConfig->getValue(self::XML_PATH_EMAIL_RECIPIENTS) ?? [];

        if (!is_array($recipientsConfig)) {
            $recipientsConfig = $this->serializer->unserialize($recipientsConfig);
        }

        foreach ($recipientsConfig as $recipient) {
            $recipients[] = $recipient[ComposerIntegrityNotificationEmailRecipients::CSV_REPORT_EMAIL_ADDRESS];
        }

        return $recipients;
    }
}
