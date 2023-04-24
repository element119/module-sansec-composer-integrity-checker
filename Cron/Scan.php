<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\SansecComposerIntegrityChecker\Cron;

use Element119\SansecComposerIntegrityChecker\Model\IntegrityResultsStorage;
use Element119\SansecComposerIntegrityChecker\Model\IntegrityResultsStorageFactory;
use Element119\SansecComposerIntegrityChecker\Scope\Config;
use Element119\SansecComposerIntegrityChecker\Service\Scanner;
use Exception;
use Magento\Framework\Exception\FileSystemException;

class Scan
{
    public function __construct(
        private readonly IntegrityResultsStorageFactory $integrityResultsStorageFactory,
        private readonly Config $moduleConfig,
        private readonly Scanner $scanner,
    ) {}

    /**
     * Run the Sansec Composer Integrity Checker and store the results.
     *
     * @return void
     * @throws FileSystemException
     * @throws Exception
     */
    public function execute(): void
    {
        if (!$this->moduleConfig->isSansecComposerIntegrityScanEnabled()) {
            return;
        }

        if ($results = $this->scanner->scan()) {
            /** @var IntegrityResultsStorage $integrityResultsFlag */
            $integrityResultsFlag = $this->integrityResultsStorageFactory->create();
            $integrityResultsFlag->setResults($results);
        }
    }
}
