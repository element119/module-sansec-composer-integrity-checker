<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\SansecComposerIntegrityChecker\Scope;

use Element119\SansecComposerIntegrityChecker\Block\Adminhtml\Form\Field\ComposerIntegrityNotificationEmailRecipients;
use Element119\SansecComposerIntegrityChecker\Block\Adminhtml\Form\Field\IgnoredPackages;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Serialize\SerializerInterface;

class Config
{
    private const XML_PATH_SCAN_ENABLED = 'system/sansec_composer_integrity_checker/scan_enable';
    private const XML_PATH_EMAIL_ENABLED = 'system/sansec_composer_integrity_checker/scan_email_notification_enable';
    private const XML_PATH_EMAIL_THRESHOLD = 'system/sansec_composer_integrity_checker/scan_failure_threshold';
    private const XML_PATH_EMAIL_RECIPIENTS = 'system/sansec_composer_integrity_checker/scan_error_email_recipient';
    private const XML_PATH_IGNORE_LIST_ENABLE = 'system/sansec_composer_integrity_checker/package_ignore_list_enable';
    private const XML_PATH_IGNORED_PACKAGES = 'system/sansec_composer_integrity_checker/ignored_packages';
    private const XML_PATH_REMOVE_IGNORED_PACKAGES_FROM_ADMIN_GRID =
        'system/sansec_composer_integrity_checker/remove_ignored_packages_from_admin_grid';
    private const XML_PATH_REMOVE_IGNORED_PACKAGES_FROM_ADMIN_NOTIFICATION =
        'system/sansec_composer_integrity_checker/remove_ignored_packages_from_admin_notif';
    private const XML_PATH_REMOVE_IGNORED_PACKAGES_FROM_EMAIL =
        'system/sansec_composer_integrity_checker/remove_ignored_packages_from_emails';

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

    public function isIgnoreListEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_IGNORE_LIST_ENABLE);
    }

    public function getIgnoredPackageList(): array
    {
        $ignoredPackages = [];
        $ignoredPackagesConfig = $this->scopeConfig->getValue(self::XML_PATH_IGNORED_PACKAGES) ?? [];

        if (!is_array($ignoredPackagesConfig)) {
            $ignoredPackagesConfig = $this->serializer->unserialize($ignoredPackagesConfig);
        }

        foreach ($ignoredPackagesConfig as $ignoredPackage) {
            $ignoredPackages[] = $ignoredPackage[IgnoredPackages::PACKAGE];
        }

        return $ignoredPackages;
    }

    public function shouldRemoveIgnoredPackagesFromAdminGrid(): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_REMOVE_IGNORED_PACKAGES_FROM_ADMIN_GRID);
    }

    public function shouldRemoveIgnoredPackagesFromAdminNotification(): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_REMOVE_IGNORED_PACKAGES_FROM_ADMIN_NOTIFICATION);
    }

    public function shouldRemoveIgnoredPackagesFromEmail(): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_REMOVE_IGNORED_PACKAGES_FROM_EMAIL);
    }
}
