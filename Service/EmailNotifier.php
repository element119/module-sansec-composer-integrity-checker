<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\SansecComposerIntegrityChecker\Service;

use Element119\SansecComposerIntegrityChecker\Scope\Config;
use Magento\Framework\App\Area;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\MailException;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Store\Model\StoreManagerInterface;

class EmailNotifier
{
    public const INTEGRITY_FAILURE_EMAIL_TEMPLATE_ID = 'sansec_composer_integrity_checker_failure';

    public function __construct(
        private readonly Config $moduleConfig,
        private readonly TransportBuilder $transportBuilder,
        private readonly StoreManagerInterface $storeManager
    ) {}

    /**
     * @param array $data
     * @return void
     * @throws LocalizedException
     * @throws MailException
     */
    public function sendErrorNotification(array $data): void
    {
        if (!$data || !($recipients = $this->moduleConfig->getSansecComposerIntegrityEmailRecipients())) {
            return;
        }

        $email = $this->transportBuilder->setTemplateIdentifier(self::INTEGRITY_FAILURE_EMAIL_TEMPLATE_ID)
            ->setTemplateOptions(
                [
                    'area' => Area::AREA_ADMINHTML,
                    'store' => $this->storeManager->getStore()->getId(),
                ]
            )->setTemplateVars(
                [
                    'failure_count' => count($data),
                    'package_data' => $data,
                ]
            )->addTo($recipients)
            ->setFromByScope('general')
            ->getTransport();

        $email->sendMessage();
    }
}
